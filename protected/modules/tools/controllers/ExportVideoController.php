<?php
class ExportVideoController extends Controller
{
	public $type = AdminVideoModel::ALL;
	public function actionIndex()
	{
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize', $pageSize);
		$model = new AdminVideoModel('search');
		$copyrightType = Yii::app()->request->getParam('ccp_type',null);
		if (isset($_GET['AdminVideoModel'])) {
			if (isset($_GET['AdminVideoModel']['created_time']) && $_GET['AdminVideoModel']['created_time'] != "") {
				// Re-setAttribute create datetime
				$createdTime = $_GET['AdminVideoModel']['created_time'];
				if (strrpos($createdTime, "-")) {
					$createdTime = explode("-", $createdTime);
					$fromDate = explode("/", trim($createdTime[0]));
					$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
					$fromDate .=" 00:00:00";
					$toDate = explode("/", trim($createdTime[1]));
					$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
					$toDate .=" 23:59:59";
				} else {
					$fromDate = date("Y-m-d", strtotime($_GET['AdminVideoModel']['created_time'])) . " 00:00:00";
					$toDate = date("Y-m-d", strtotime($_GET['AdminVideoModel']['created_time'])) . " 23:59:59";
				}
			}
		}
		
		$is_composer="";
		if (isset($_GET['is_composer']) && $_GET['is_composer']>0) {
			$is_composer = $_GET['is_composer'];
		}
		$is_lyric="";
		if (isset($_GET['is_lyric']) && $_GET['is_lyric']>0) {
			$is_lyric = $_GET['is_lyric'];
		}
		
		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();
		
		$numPage = 1;
		$count = 0;
		
		if(isset($_GET['AdminVideoModel'])){
			$limit=10;
			$offset=0;
			$where ="";
			if($_GET['AdminVideoModel']['genre_id']!=''){
				$genreId = (int) $_GET['AdminVideoModel']['genre_id'];
				$where .=" and (g.id = '{$genreId}' OR g.parent_id= '{$genreId}')";
			}
			if($_GET['AdminVideoModel']['name']!=''){
				$where .=" and t.name LIKE '%".$_GET['AdminVideoModel']['name']."%' ";
			}
			if($_GET['AdminVideoModel']['artist_name']!=''){
				$where .=" and a.name LIKE '%".$_GET['AdminVideoModel']['artist_name']."%' ";
			}
			if($_GET['is_composer']==1 || $_GET['is_composer']==2){
				if($_GET['is_composer']==1){
					$where .=" and t.composer_id > 0 ";
				}else{
					$where .=" and t.composer_id = 0 ";
				}
			}
			if($_GET['is_lyric']==1 || $_GET['is_lyric']==2){
				if($_GET['is_lyric']==1){
					$where .=" and ve.description <> '' ";
				}else{
					$where .=" and (ve.description = '' OR ve.description is null)";
				}
			}
			if($_GET['AdminVideoModel']['max_bitrate']!=''){
				$bitRate = $_GET['AdminVideoModel']['max_bitrate'];
				if($bitRate == "720"){
					$where .=" and t.profile_ids LIKE  '%9%'";
				}
			}
			
			if($_GET['AdminVideoModel']['created_time']!=''){
				$where .=" and t.created_time BETWEEN '$fromDate' AND '$toDate' ";
			}
			$sql = "SELECT count(DISTINCT `t`.`id`)
					FROM video t 
					INNER JOIN video_status st ON t.id = st.video_id
					LEFT JOIN video_artist va ON t.id =va.video_id
					LEFT JOIN artist a ON a.id=va.artist_id
					LEFT JOIN genre g ON g.id = t.genre_id
					LEFT JOIN video_extra ve ON t.id = ve.video_id
					WHERE true $where
					";
			$count = Yii::app()->db->createCommand($sql)->queryScalar();
			$perPage = 5000;
			
			if ($count <= $perPage) {
				$numPage = 1;
			} elseif (($count % $perPage) == 0) {
				$numPage = ($count / $perPage) ;
			} else {
				$numPage = ($count / $perPage) + 1;
				$numPage = (int) $numPage;
			}
			if(isset($_GET['export'])){
				$page = Yii::app()->request->getParam('page',1);
				$limit = $perPage;
				$offset = ($page - 1) * $limit;
				$sql = "SELECT t.id, t.name as video_name, a.name as composer_name, 
				t.composer_id, t.genre_id, g.name, t.artist_name,ve.description as lyric,
				sc.copryright_id as copyright_id,c.appendix_no,c.contract_no 
				FROM video t
				INNER JOIN video_status st ON t.id = st.video_id
				LEFT JOIN video_artist va ON va.video_id = t.id
				LEFT JOIN artist a ON a.id=t.composer_id
				LEFT JOIN genre g ON g.id=t.genre_id
				LEFT JOIN video_extra ve ON t.id = ve.video_id
				LEFT JOIN video_copyright sc ON sc.video_id=t.id
				LEFT JOIN copyright c ON c.id=sc.copryright_id 				
				WHERE true $where
				GROUP BY t.id
				ORDER BY t.id ASC
				LIMIT $limit
				OFFSET $offset
				";
				$data = Yii::app()->db->createCommand($sql)->queryAll();
				$label = array(
						'id'=>'ID',
						'video_name'=>'Video',
						'artist_name'=>'Ca sỹ',
						'composer_name'=>'Nhạc sỹ',
						'composer_id'=>'composer_id',
						'name'=>'Thể loại',
						'lyric'=>'Lyric',
						'contract_no'=>'Số hợp đồng',
						'cc'=>'Tên CP, Ca sĩ, đại diện HĐ',
						'appendix_no'=>'Số phụ lục',
						'copyright_id'=>'ID Hợp đồng'

				);
				$title = Yii::t('admin', 'Export_'.$page);
				$excelObj = new ExcelExport($data, $label, $title);
				$excelObj->export();
				exit;
			}
		}
		$this->render('index', array(
				'model' => $model,
				'categoryList' => $categoryList,
				'cpList' => $cpList,
				'pageSize' => $pageSize,
				'is_composer'=>$is_composer,
				'copyrightType'=>$copyrightType,
				'numPage'=>$numPage,
				'count'=>$count,
				'is_lyric'=>$is_lyric
		));
	}

}
