    <?php
class VideoplaylistController extends TController
{
    /**
     * function actionIndex
     * call to render hot video playlist page
     */
    public function actionIndex() {
        $limit = Yii::app()->params['numberPerPage'];
            $c = CHtml::encode(Yii::app()->request->getParam('c','0'));
            $c = (!empty($c))?$c:'0';
            $s = CHtml::encode(Yii::app()->request->getParam('s'));
            $s = (!empty($s))?$s : Yii::t('wap','Hot');
            $cTitle = ($c==0)? Yii::t('wap','All genres') : WapGenreModel::model()->findByPk($c)->name;
            $sTitle = 'HOT';
            $page = (int)Yii::app()->request->getParam('page', 1);
            $callBack = (int)Yii::app()->request->getParam('call_back',0);
            $callBackLink = Yii::app()->createUrl("videoPlaylist/index",array('type'=>$c, 's'=>$s, 'c'=>$c));
            $options = array();
		
        if ($c == 0) {
            if ($s == 'NEW') {
                $sTitle = 'MỚI';
                $count = WapVideoPlaylistModel::countListByCollection('VIDEO_PLAYLIST_NEW');
                $videoPlaylists = WapVideoPlaylistModel::getLisNew($page,$limit);
                $options = array('col' => 'VIDEO_PLAYLIST_NEW');
            } else {
                $count = WapVideoPlaylistModel::countListByCollection('VIDEO_PLAYLIST_HOT');
                $videoPlaylists = WapVideoPlaylistModel::getListHot($page,$limit);
                $options = array(
                    'col' => 'VIDEO_PLAYLIST_HOT',
                    );
            }
            $pager = new CPagination($count);
            $pager->setPageSize($limit);
        } else {
            $count = WapVideoPlaylistModel::model()->countByGenre($c);
            $pager = new CPagination($count);
             $pager->setPageSize($limit);
            if($s=='NEW'){
                $sTitle = 'MỚI';
                $albums = WapAlbumModel::model()->getAlbumsByGenre($c, $pager->getOffset(), $pager->getLimit(),'new');
            }else{
                $albums = WapAlbumModel::model()->getAlbumsByGenre($c, $pager->getOffset(), $pager->getLimit(),'hot');
            }
        }
            $pager = new CPagination($count);
            $pager->setPageSize($limit);
            if($callBack){
                    $this->layout = false;
                    $this->render("_ajaxList",compact('videoPlaylists','pager','callBackLink', 'options'));
            }	
            else {
            $this->render('index', array(
                'videoPlaylists' => $videoPlaylists,
                's'=>$s,
                'c'=>$c,
                'cTitle'=>$cTitle,
                'sTitle'=>$sTitle,
                'pager'=>$pager,
                'callBackLink'=>$callBackLink,
                'options' => $options
            ));
            }
    }
    /**
     * VideoPlaylist detail
     */
    /**
     * function actionView
     * call to render detail VideoPlaylist page
     */
    public function actionView() {
    	$id = (int)Yii::app()->request->getParam('id');
    	$video_id = Yii::app()->request->getParam('video_id',null);
    	$videoPlaylist = WapVideoPlaylistModel::model()->published()->with('video_playlist_artist')->findByPk($id);
    	$playPrice = $videoPlaylist->price;
    	if (!$videoPlaylist) {
            $this->forward("/site/error",true);
    	}

        $list_video_playlist = WapVideoModel::model()->getVideosOfVideoPlaylist($id);
        //check noi dung doc quyen
        $userType = "GUEST";
        $phone = Yii::app()->user->getState('phone');
        if ($phone) {
            $userType = "MEMBER";
        }
        $userSub = Yii::app()->user->getState('userSub');
        $packageCode = Yii::app()->user->getState('packageCode');
        if ($userSub) {
            $userType = "SUB_" . $packageCode;
        }
        $content_limit = ContentLimitModel::model()->getIdByType('video','WAP',$userType);
        $list_video = array();
        for($i=0;$i< count($list_video_playlist);$i++){
            if(!in_array($list_video_playlist[$i]->id,$content_limit)){
                $list_video[] = $list_video_playlist[$i];
            }
        }
        $phone = Yii::app()->user->getState('msisdn');
        $like = null;
        if ($phone) {
            $like = FavouriteVideoPlaylistModel::model()->findByAttributes(array('video_playlist_id' => $id, 'msisdn' => $phone));
        }
        $video = WapVideoModel::model()->with("video_extra")->findByPk($video_id);
        $video = isset($video)? $video : $list_video[0];
        $artist_id = $videoPlaylist->video_playlist_artist[0]->artist_id;
        $count = VideoPlaylistArtistModel::model()->countVideoPlaylistByArtist($artist_id);
        $pager = new CPagination($count);
        $pager->setPageSize(Yii::app()->params['numberPerPage']);
        $videoPlaylistSameArtist = WapVideoPlaylistModel::model()->getVideoPlaylistsSameArtists($artist_id, $pager->getOffset(), $pager->getLimit());
        $callBackLink = Yii::app()->createUrl("videoPlaylist/loadAjax", array('s' => 'artist', 'artist_id' => $artist_id));

        $this->render('view', compact('video', 'list_video','videoPlaylist','pager','videoPlaylistSameArtist','callBackLink','like','artist_id'));


    }
    /**
     * Load same videoPlaylist via Ajax
     */
    public function actionLoadAjax()
    {
    	$s = CHtml::encode(Yii::app()->request->getParam('s'));
    	$videoPlaylistId = Yii::app()->request->getParam('id',0);
    	$artist_id = (int)Yii::app()->request->getParam('artist_id',0);
    	$genre_id = (int)Yii::app()->request->getParam('genre_id',0);
    	if($s=='genre'){
    		$countVideoPlaylistsSameGenre = WapVideoPlaylistModel::model()->countVideoPlaylistsSameGenre($videoPlaylistId, $genre_id);
    		$videoPlaylistPages = new CPagination($countVideoPlaylistsSameGenre);
    		$pageSize = Yii::app()->params['pageSize'];
    		$videoPlaylistPages->setPageSize($pageSize);
    		$currentPage = $videoPlaylistPages->getCurrentPage();
    		$data = WapVideoPlaylistModel::model()->getVideoPlaylistsSameGenre($videoPlaylistId, $genre_id, $currentPage * $pageSize, $pageSize);
    	}else{
    		$countVideoPlaylistsSameArtist = VideoPlaylistArtistModel::model()->countVideoPlaylistByArtist($artist_id);
    		$videoPlaylistPages = new CPagination($countVideoPlaylistsSameArtist);
    		$pageSize = Yii::app()->params['pageSize'];
    		$videoPlaylistPages->setPageSize($pageSize);
    		$currentPage = $videoPlaylistPages->getCurrentPage();
    		
//     		$data = WapVideoPlaylistModel::model()->getVideoPlaylistsSameArtist($videoPlaylistId, $artist_id, $currentPage * $pageSize, $pageSize);
    		
    		/*NEW*/
    		$artists = VideoPlaylistArtistModel::model()->getArtistsByVideoPlaylist($videoPlaylistId);
    		$artistIds = '';
    		if ($artists) {
    			foreach ($artists as $artist) {
    				$artistIds .= ',' . $artist->artist_id;
    			}
    		}
    		$artistIds = ($artistIds != '') ? substr($artistIds, 1) :'';
    		$data = $videoPlaylistsSameArtist = WapVideoPlaylistModel::model()->getVideoPlaylistsSameArtists($artistIds, $currentPage * $pageSize, $pageSize);
    		/*END*/
    	}
    	$this->renderPartial('_same',array('videoPlaylists'=>$data), false, true);
    }

}