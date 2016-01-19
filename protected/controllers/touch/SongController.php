<?php

class SongController extends TController {

	public function filters() {
		return array(
				'accessControl',
		);
	}
	
	public function accessRules() {
		return array(
				array('deny',
						'actions' => array('msgift'),
						'users' => array('?'),
				),
		);
	}
    public function actionIndex(){
        $type = CHtml::encode(Yii::app()->request->getParam('type', 'HOT'));
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $page = (int) Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberSongPerPage'];
        if($this->layout == 'application.views.wap.layouts.main'){
            $limit = Yii::app()->params['numberSongPerPageWap'];
        }
        $count_hot = WapSongModel::countListByCollection('SONG_HOT');
        $songs = WapSongModel::getListByCollection('SONG_HOT', $page, $limit);
        $pager = new CPagination($count_hot);
        $pager->setPageSize($limit);
        $offset = $pager->getOffset();
        $count_new = WapSongModel::countListByCollection('SONG_NEW');
        $songs_new = WapSongModel::getListByCollection('SONG_NEW', $page, $limit);
        $arr_songs = array(
            array('headerText' => yii::t('wap', 'BÀI HÁT HOT'), 'song' => $songs,
                'link' => 'song/list?type=HOT'),
            array('headerText' => yii::t('wap', 'BÀI HÁT MỚI'), 'song' => $songs_new,
                'link' => 'song/list?type=NEW'),
        );

        $callBackLink = Yii::app()->createUrl("song/index", array(
            'type' => $type
        ));
        if ($callBack) {
            $this->layout = false;
            $this->render("_ajaxList", compact('songs', 'pager', 'callBackLink', 'options'));
        } else {
            $userPlaylist = array();
            if ($this->userPhone) {
                $userPlaylist = WapPlaylistModel::model()->getPlaylistByPhone($this->userPhone, $limit, $page);
            }
            $this->render("index", compact('arr_songs', 'pager', 'callBackLink', 'userPlaylist'));
        }
    }


    public function actionList() {
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $page = (int) Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberSongPerPage'];
        $c = CHtml::encode(Yii::app()->request->getParam('id', '0'));
        $s = CHtml::encode(Yii::app()->request->getParam('type','NEW'));
        $s = strtoupper($s);
        $cTitle = ($c == 0) ? 'Tất cả thể loại' : WapGenreModel::model()->findByPk($c)->name;
        $sTitle = ($s == 'NEW') ? "Mới" : $s;
        $count = WapSongModel::countListByCollection('SONG_HOT');
        $songs = WapSongModel::getListByCollection('SONG_HOT', $page, $limit);
        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $offset = $pager->getOffset();

        $callBackLink = Yii::app()->createUrl("song/list", array(
            'c' => $c,
            's' => $s
        ));
        $options = array();
        if ($c == 0) {
            // danh sach song
            if ($s == 'NEW') {
                $count = WapSongModel::countListByCollection('SONG_NEW');
                $songs = WapSongModel::getListByCollection('SONG_NEW', $page, $limit);
                $options['col'] = 'BÀI HÁT MỚI';
            } else {
                $count = WapSongModel::countListByCollection('SONG_HOT');
                $songs = WapSongModel::getListByCollection('SONG_HOT', $page, $limit);
                $options['col'] = 'BÀI HÁT HOT';
            }

            $pager = new CPagination($count);
            $pager->setPageSize($limit);
        } else {
            $arrPattern = array('-', '_', '\'', ' '); 
            $cKey = strtoupper(str_replace($arrPattern, '', Common::strNormal($cTitle)));
            $colection_code  = 'SONG_'.$s.'_'.$cKey;
            $check_key = CollectionModel::model()->findByAttributes(array('code'=>$colection_code));
            if (isset($check_key)) {
            	$count = WapSongModel::countListByCollection($colection_code, $page, $limit);
            	$songs = WapSongModel::getListByCollection($colection_code, $page, $limit);
            	$pager = new CPagination($count); $pager->setPageSize($limit);
            } 
           else {
               if($s=='NEW'){
                    $count = WapSongModel::model()->countSongsByGenre($c);
                    $pager = new CPagination($count);
                    $pager->setPageSize($limit);
                    $songs = WapSongModel::model()->getSongsByGenre($c, $pager->getOffset(), $pager->getLimit());
                    $options['col'] = 'BÀI HÁT MỚI';
            }else{
                    //$count = WapSongModel::model()->countSongsByGenre($c);
                    $count = WapGenreModel::getCountSongsByGenreCollection($c, 1);
                    $pager = new CPagination($count);
                    $pager->setPageSize($limit);
                    $songs = WapGenreModel::getSongsByGenreCollection($c, 1, $pager->getOffset(), $pager->getLimit());
                    $options['col'] = 'BÀI HÁT HOT';
            }
           }
        }
        if ($callBack) {
            $this->layout = false;
            $this->render("_ajaxList", compact('songs', 'pager', 'callBackLink', 'options'));
        } else {
            $this->render('list', array(
                'songs' => $songs,
                's' => $s,
                'c' => $c,
                'cTitle' => $cTitle,
                'sTitle' => $sTitle,
                'pager' => $pager,
                'callBackLink' => $callBackLink,
                'options' => $options,
                'type'=>'',
            ));
        }
    }

    public function actionView() {
        $id = (int) Yii::app()->request->getParam('id', 0);
        $playUrl = Yii::app()->request->getParam('url', null);
        $lyric = (int) Yii::app()->request->getParam('lyric', 0);
        $song = WapSongModel::model()->available()->findByPk($id);
        $isDeactive = false;
        if(!$song || $song->status == SongModel::DELETED){
            $this->forward("/site/error",true);
        }elseif($song->status == SongModel::DEACTIVE){
            $isDeactive = true;
        }
        $artistId = SongArtistModel::model()->getArtistBySong($id, 'id');
        if ($artistId) {
            $artistId = $artistId [0];
        } else {
            $artistId = 0;
        }

        $genreId = SongGenreModel::model()->getCatBySong($song->id, false, true);
        if ($genreId) {
            $genreId = $genreId [0];
        } else {
            $genreId = 0;
        }
        //--- Check quyền nghe bài hát này
        $userType = "GUEST";
        if(Yii::app()->user->getState('msisdn')){
            $userType = "MEMBER";
        }

        if (!empty($this->userSub)){
            if(isset($this->userSub->package) && !empty($this->userSub->package)){
                $package = $this->userSub->package->code;
            }
            $package = strtoupper($package);
            $userType = "SUB_".$package;
        }

        $per = ContentLimitModel::getPermision($song->id, "song", $userType,"WAP");
        //---End check quyền nghe bài hát này
        $count = WapSongModel::model()->countSongsSameSinger($song->id, $artistId);
        $pager = new CPagination($count);
        $limit = Yii::app()->params ['numberPerPage'];
        if($this->layout == 'application.views.wap.layouts.main'){
            $limit = Yii::app()->params['numberSongPerPageWap'];
        }
        $pager->setPageSize($limit);

        $songArtist = WapSongModel::model()->getSongsSameSinger($song->id, $artistId, $pager->getOffset(), $pager->getLimit());
        $callBackLink = Yii::app()->createUrl("song/artist", array(
            'song_id' => $song->id,
            'artist_id' => $artistId,
        ));

        // check like
        $like = null;
        $favourite = Yii::app()->request->getParam('favourite', null);
        $user_id = Yii::app()->user->id;
        $phone = yii::app()->user->getState('msisdn');
        $artist_name = Common::makeFriendlyUrl($song->artist_name);
        $back_url = Yii::app()->params['base_url'] . Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
        if (isset($favourite) && $favourite == 1) {
            //yeu thich video
            if (!empty($phone)) {
                $fav = WapFavouriteSongModel::model()->favouriteSong($id, $phone, $phone);
            } else {
                $this->redirect($this->createUrl("/account/login", array('back_url'=>$back_url)));
            }
        } elseif (isset($favourite) && $favourite == 0) {
            if (!empty($user_id)) {
                $res = WapFavouriteSongModel::model()->deleteAll("song_id=$id AND msisdn=$phone");
            } else {
                $this->redirect($this->createUrl("/account/login",array('back_url'=>$back_url)));
            }
        }
        if ($phone) {
            $like = WapFavouriteSongModel::model()->findByAttributes(array('song_id' => $song->id, 'msisdn' => $phone));
        }

        
        // Get Song Meta Data
        $Artist = ArtistModel::model()->findByPk($song->song_artist[0]->artist_id);
        $this->url = URLHelper::buildFriendlyURL("song", $song->id, $song->url_key);
        $this->itemName = $song->name;
        $this->artist = ($Artist)?$Artist->name:'Music';
        $this->thumb = ArtistModel::model()->getAvatarUrl($song->song_artist[0]->artist_id,'s1');
        $userSub = $this->userSub;
        $this->render('view', compact('song', 'songArtist', 'pager', 'callBackLink', 'artistId', 'genreId', 'like','per','lyric','playUrl','isDeactive'));
    }

    public function actionArtist() {
        $page = (int) Yii::app()->request->getParam('page', 2);
        $songId = (int) Yii::app()->request->getParam('song_id');
        $artistId = (int) Yii::app()->request->getParam('artist_id');
        $count = WapSongModel::model()->countSongsSameSinger($songId, $artistId);
        $pager = new CPagination($count);
        $limit = Yii::app()->params ['numberPerPage'];
        $pager->setPageSize($limit);

        $songs = WapSongModel::model()->getSongsSameSinger($songId, $artistId, $pager->getOffset(), $pager->getLimit());
        $this->layout = false;
        $this->render("_ajaxList", compact('songs', 'pager'));
    }
	public function actionArtistList()
	{
		$callBack = (int) Yii::app()->request->getParam('call_back', 0);
		$page = (int) Yii::app()->request->getParam('page', 1);
		$limit = Yii::app()->params ['numberPerPage'];
		$offset = ($page-1)*$limit;
		$artistId = (int) Yii::app()->request->getParam('artist_id');
		$artist = ArtistModel::model()->findByPk($artistId);
		$songId = 0;
		$count = WapSongModel::model()->countSongsSameSinger($songId, $artistId);
		
		$songs = WapSongModel::model()->getSongsSameSinger($songId, $artistId, $offset, $limit);
		
		$pager = new CPagination($count);
		$pager->setPageSize($limit);
		$offset = $pager->getOffset();
		$callBackLink = Yii::app()->createUrl("song/artistList", array(
				'artist_id'=>$artistId
		));
		if ($callBack) {
			$this->layout = false;
			$this->render("_ajaxList", compact('songs', 'pager', 'callBackLink','artist'));
		} else {
			$this->render("artist", compact('songs', 'pager', 'callBackLink','artist'));
		}
	}
    public function actionAddToPlaylist() {
        $songId = (int) Yii::app()->request->getParam('songId', 0);
        $playlistId = (int) Yii::app()->request->getParam('pid', 0);
        $songInPl = PlaylistSongModel::model()->findAllByAttributes(array(
            "playlist_id" => $playlistId));
        $listsong = CHtml::listData($songInPl, 'song_id', 'song_id');
        if (in_array($songId, $listsong)) {
            echo 'success';
        } else {
        	$sql = "INSERT INTO playlist_song(playlist_id, song_id) VALUE(:p_id, :s_id)
        			ON DUPLICATE KEY UPDATE playlist_id=:p_id, song_id=:s_id
        			";
        	$command = Yii::app()->db->createCommand($sql);
        	$command->bindParam(':p_id', $playlistId, PDO::PARAM_INT);
        	$command->bindParam(':s_id', $songId, PDO::PARAM_INT);
                
        	$ret = $command->execute();
            if ($ret) {
                echo 'success';
            } else {
                echo 'fail';
            }
        }
        $this->layout = false;
    }

    public function actionAddNewPlaylist() {
        $name = CHtml::encode(Yii::app()->request->getParam('name', 0));
        $song_id = (int) Yii::app()->request->getParam('songId', 0);
        $phone = Yii::app()->user->getState('msisdn');
        if(strlen($name) >= 80){
            echo "3";
        }else{
            $playlist_name = ucwords($name);
            //if( !preg_match('/^[0-9a-zA-Z_ ]+$/', $playlist_name) ){//ten playlistk dc su dung ky tu dac biet
            if(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $playlist_name)){
                echo '4';
                $this->layout = false;
                Yii::app()->end();
            }
            $list = PlaylistModel::model()->findAllByAttributes(array(
                'msisdn' => $phone
            ));
            $listPl = CHtml::listData($list, 'name', 'name');
            if (in_array($playlist_name, $listPl, true)) {
                echo "1"; // trung ten
            } else {
                $model = new PlaylistModel();
                $model->name = $playlist_name;
                $model->url_key = Common::makeFriendlyUrl($name);
                $model->msisdn = Formatter::formatPhone($phone);
                $model->created_time = new CDbExpression('NOW()');
                if ($model->insert()) {
                    // check xem bai hat do da co chua?
                    // $song_in_pl = WapPlaylistSongModel::model()->findByAttributes(array('playlist_id'=>$model->id,'song_id'=>$song_id));
                    $songInPl = PlaylistSongModel::model()->findAllByAttributes(array(
                        "playlist_id" => $model->id
                    ));
                    $listsong = CHtml::listData($songInPl, 'song_id', 'song_id');
                    if (!$listsong) {
                        $playlist_song = new PlaylistSongModel ();
                        $playlist_song->playlist_id = $model->id;
                        $playlist_song->song_id = $song_id;
                        $playlist_song->status = '1';
                        $ret = $playlist_song->save();
                        if ($ret)
                            echo '2';
                    }
                } else {
                    echo '0';
                }
            }
        }
        $this->layout = false;
        Yii::app()->end();
    }

    public function actionLoadAjax() {
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $s = CHtml::encode(Yii::app()->request->getParam('s'));
        $id = (int) Yii::app()->request->getParam('id', 0);
        $artist_id = (int) Yii::app()->request->getParam('artist_id', 0);
        $genre_id = (int) Yii::app()->request->getParam('genre_id', 0);

        if ($s == 'genre') {
            $callBackLink = Yii::app()->createUrl("song/loadAjax", array(
                's' => 'genre',
                'genre_id' => $genre_id
            ));
            $count = WapSongModel::model()->countSongsByGenre($genre_id);

            $pager = new CPagination($count);
            $pageSize = Yii::app()->params ['pageSize'];
            $pager->setPageSize($pageSize);
            $currentPage = $pager->getCurrentPage();
            $songs = WapSongModel::model()->getSongsByGenre($genre_id, $pager->getOffset(), $pager->getLimit());
        } else {
            $callBackLink = Yii::app()->createUrl("song/loadAjax", array(
                's' => 'artist',
                'artist_id' => $artist_id
            ));
            $count = WapSongModel::model()->countSongsSameSinger($id, $artist_id);

            $pager = new CPagination($count);
            $pageSize = Yii::app()->params ['pageSize'];
            $pager->setPageSize($pageSize);
            $currentPage = $pager->getCurrentPage();
            $songs = WapSongModel::model()->getSongsSameSinger($id, $artist_id, $pager->getOffset(), $pager->getLimit());
        }

        if ($callBack) {
            $this->renderPartial("_ajaxList", compact('songs', 'pager'), false, true);
        } else {
            $this->renderPartial("_same", compact('songs', 'pager', 'callBackLink'), false, true);
        }
    }
    
    /**
     * QuĂ  táº·ng
     */
    function isValidDateTime($dateTime)
    {
    	if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
    		if (checkdate($matches[2], $matches[3], $matches[1])) {
    			return true;
    		}
    	}
    	return false;
    }

    public function actionCharge(){
        $id = Yii::app()->request->getParam('id');
        $song = SongModel::model()->findByPk($id);
        $action = Yii::app()->request->getParam('action','playSong');
        $deviceId = yii::app()->session['deviceId'];
        $msg = "";
        $playUrl = '';
        if (!$song) {
            $this->forward("/site/error",true);
        }
        $artist_name = Common::makeFriendlyUrl($song->artist_name);
        $back_url = Yii::app()->params['base_url'] . Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
        if(Yii::app()->user->isGuest){
            if($action =='downloadSong'){
                $this->redirect($this->createUrl("/account/login", array('back_url'=>$back_url)));
                Yii::app()->end();
            }else{
                //cho nghe 5 lan free
                $limit = isset(Yii::app()->session["limit_play"])? Yii::app()->session["limit_play"] : 0;
                if($limit >= 5) {
                    $msg = Yii::app()->params['message']['limit_content'];
                }else{
                    Yii::app()->session["limit_play"]= Yii::app()->session["limit_play"] + 1;
                    $playUrl = WapSongModel::model()->getAudioFileUrl($song->id, $deviceId, 'rtsp', $song->profile_ids);
                    $this->redirect($this->createUrl("song/view", array('url'=>$playUrl,"id"=>$id, 'url_key'=>$song->url_key)));
                }
                $this->render('play', compact('msg','back_url','playUrl'));
               exit;
            }
        }
        if($action == 'downloadSong' && empty($this->isSub)){
            $msg = "Quý khách vui lòng đăng ký dịch vụ để tải miễn phí nội dung";
            $this->render('download', compact('msg','back_url'));
            exit;
        }

        $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
        $client = new SoapClient($bmUrl, array('trace' => 1));
        if($action =='downloadSong'){
            $params = array(
                'code' => $song->code,
                'from_phone' => yii::app()->user->getState('msisdn'),
                'to_phone' => yii::app()->user->getState('msisdn'),
                'source_type' => 'wap',
                'promotion' => 0,
                'smsId' => '',
                'noteOptions' => array(),
            );
            $result = $client->__soapCall('downloadSong', $params);
        }elseif($action == 'playSong'){
            $params = array(
                'code' => $song->code,
                'from_phone' => Yii::app()->user->getState('msisdn'),
                'source_type' => 'wap',
                'promotion' => 0,
            );
            $result = $client->__soapCall('playSong', $params);
        }
        $errorCode = $result->message;
        // Log url trả về cho user
        if ($errorCode == "success") {
            if($action =='playSong'){
                $playUrl = WapSongModel::model()->getAudioFileUrl($song->id, $deviceId, 'rtsp', $song->profile_ids);
            }else{
                $playUrl = WapSongModel::model()->getNiceDownloadUrl($song->id, $deviceId, 'http', $song->profile_ids, $song->url_key, $song->artist_name);
            }
            $this->redirect($this->createUrl("song/view", array('url'=>$playUrl,"id"=>$id, 'url_key'=>$song->url_key)));
        }else{
            $msg = Yii::app()->params['subscribe'][$errorCode];
        }
        $this->render('play', compact('msg','back_url','playUrl'));
    }

}