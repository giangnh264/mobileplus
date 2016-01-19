<?php
class GenreController extends TController
{
	public function actionCollection()
	{
		$arr_item = array(
			'song' => array('widget'=>'song.SongList'),
			'video'=> array('widget'=>'video.VideoList'),
			'album'=> array('widget'=>'album.AlbumList'),
			'videoPlaylist'=> array('widget'=>'video_playlist.Video_playlistList'),
		);
		$callBack =(int) Yii::app()->request->getParam('call_back', 0);
		$page = (int)Yii::app()->request->getParam('page', 1);
		$limit = Yii::app()->params ['numberPerPage'];
		
		$id = Yii::app()->request->getParam('id','');
		$collection = CollectionModel::model()->findByPk($id);

		$callBackLink = Yii::app()->createUrl("genre/collection", array(
				'id' => $id,
		));
		
		$colection_code  = $collection->code;
		
		$count = WapSongModel::countListByCollection($colection_code, $page, $limit);
		$videos = WapSongModel::getListByCollection($colection_code, $page, $limit);
		
		$pager = new CPagination($count); 
		$pager->setPageSize($limit);
		
		if ($callBack) {
			$this->layout = false;
			$this->render("_ajaxList", compact('videos', 'pager', 'callBackLink'));
		} else {
			$this->render('collection', array(
					'videos' => $videos,
					'pager' => $pager,
					'callBackLink' => $callBackLink,
					'collection' => $collection,
					'arr_item' => $arr_item,
					'options'=>array('col'=>$collection->id, 'display_type' => ($collection->code == 'VIDEO_COLLECTION' ? 'VIDEO_COLLECTION' : '')),
			));
		}
	}
	public function actionView()
	{
		$arr_item = array(
			'song' => array('widget'=>'song.SongList'),
			'video'=> array('widget'=>'video.VideoList'),
			'album'=> array('widget'=>'album.AlbumList'),
			'videoPlaylist'=> array('widget'=>'video_playlist.Video_playlistList'),
		);
		$genre_id = Yii::app()->request->getParam('id',0);
		$type = Yii::app()->request->getParam('type','song');
		$genreModel = GenreModel::model()->findByPk($genre_id);
		if(!$genreModel) {
			//throw new CHttpException(404);
			switch($type) {
				case "song":
					Yii::app()->request->redirect(Yii::app()->createUrl("song"));
					break;
				case "video":
					Yii::app()->request->redirect(Yii::app()->createUrl("video"));
					break;
				case "album":
					Yii::app()->request->redirect(Yii::app()->createUrl("album"));
					break;
				case "videoPlaylist":
					Yii::app()->request->redirect(Yii::app()->createUrl("videoPlaylist"));
					break;
				default:
					Yii::app()->request->redirect(Yii::app()->createUrl("genre"));
					break;
			}
		}
		if(array_key_exists($type,$arr_item)){
			$this->showList($genreModel,$type, $genre_id);
		}
		else{
			$this->redirect(Yii::app()->createUrl("/$type"),array('g' => $genre_id));
		}

	}

	public function actionDetail(){
		$genre_id = Yii::app()->request->getParam('id',0);
		$type = Yii::app()->request->getParam('type','song');
		$this->redirect(Yii::app()->createUrl('genre/view',array('id'=>$genre_id,'type'=>$type)),true,301);
	}
	public function actionIndex(){
		$type = Yii::app()->request->getParam('type','song');
		$parentGenres = MainActiveRecord::getGenre(0);
		$arrSubGenres = array();
		foreach($parentGenres as $pgenre){
			$pid = $pgenre->id;
			$cri = new CDbCriteria;
			$cri->condition = "parent_id = $pid AND status = 1";
			$cri->order = "sorder ASC";
			$subGenres = GenreModel::model()->findAll($cri);
			$arrSubGenres[$pid] = $subGenres;
		}
		$this->render('list',array(
			'parentGenres' => $parentGenres,
			'arrSubGenres' => $arrSubGenres,
			'type' => $type
		));
	}
}