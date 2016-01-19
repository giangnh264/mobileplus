<?php

class VideoController extends TController
{


    public function actionIndex()
    {
        $page = (int)1;
        $limit = $limit_collection = Yii::app()->params['numberPerPage'];
        if ($this->layout == 'application.views.wap.layouts.main') {
            $limit = Yii::app()->params['numberSongPerPageWap'];
        }
        $count = WapVideoModel::countListByCollection('VIDEO_HOT');
        $videos = WapVideoModel::getListHot('VIDEO_HOT', $page, $limit);

        //video new
        $count_new = WapVideoModel::countListByCollection('VIDEO_NEW');
        $videos_new = WapVideoModel::getListByCollection('VIDEO_NEW', $page, $limit);
        $pager = new CPagination($count_new);
        $pager->setPageSize($limit);
        //video hot
        $videos_hot = WapVideoModel::getListByCollection('VIDEO_HOT', $page, $limit);

        //video collection
        if ($this->layout == 'application.views.wap.layouts.main') {
            $limit_collection = 3;
        }
        $videos_collection = WapVideoModel::getListByCollection('VIDEO_COLLECTION', $page, $limit_collection);

        $videoCollections = array(
            'videos' => $videos_collection,
            'headerText' => 'THẾ GIỚI CÓ GÌ',
            'link' => Yii::app()->createUrl('genre/collection', array('id' => 25)),
            'options' => 'VIDEO_COLLECTION',
        );
        //video playlist
        $video_playlist = WapVideoPlaylistModel::getListHot(1, 3);
        $videoPlaylists = array(
            'videos' => $video_playlist,
            'headerText' => 'VIDEO PLAYLIST',
            'link' => Yii::app()->createUrl('videoplaylist/index'),
            'options' => 'VIDEO_PLAYLIST',
        );
        $arr_videos = array(
            array('headerText' => 'VIDEO HOT', 'video' => $videos_hot,
                'link' => Yii::app()->createUrl('/video/list', array('s' => 'hot', 'page' => 2)), 'options' => array('col' => 'VIDEO_HOT')),
            array('headerText' => 'VIDEO MỚI', 'video' => $videos_new,
                'link' => Yii::app()->createUrl('/video/list', array('s' => 'new', 'page' => 2)), 'options' => array('col' => 'VIDEO_NEW')),
        );

        $this->render('index', array(
            'pager' => $pager,
            'arr_videos' => $arr_videos,
            'videoCollections' => $videoCollections,
            'videoPlaylists' => $videoPlaylists,
        ));
    }

    public function actionList()
    {
        $callBack = (int)Yii::app()->request->getParam('call_back', 0);
        $page = (int)Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberPerPage'];
        $c = CHtml::encode(Yii::app()->request->getParam('id', '0'));
        $s = CHtml::encode(Yii::app()->request->getParam('type', 'HOT'));
        $s = strtoupper($s);
        $cTitle = ($c == 0) ? Yii::t('wap', 'All genres') : WapGenreModel::model()->findByPk($c)->name;
        $sTitle = ($s == 'NEW') ? Yii::t('wap', 'New') : $s;
        $callBackLink = Yii::app()->createUrl("video/list", array(
            'c' => $c,
            's' => $s
        ));

        $options = array();
        if ($c == 0) {
            if (strtoupper($s) == 'NEW') {
                $count = WapVideoModel::countListByCollection('VIDEO_NEW');
                $videos = WapVideoModel::getListByCollection('VIDEO_NEW', $page, $limit);
                $options['col'] = 'VIDEO_NEW';
                $options['headerText'] = 'VIDEO MỚI';
            } else {
                $count = WapVideoModel::countListByCollection('VIDEO_HOT');
                $videos = WapVideoModel::getListByCollection('VIDEO_HOT', $page, $limit);
                $options['col'] = 'VIDEO_HOT';
                $options['headerText'] = 'VIDEO HOT';
            }

            $pager = new CPagination($count);
            $pager->setPageSize($limit);
        } else {
            if (strtoupper($s) == 'NEW') {
                $count = WapVideoModel::model()->countVideosByGenre($c);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $videos = WapVideoModel::model()->getVideosByGenre($c, $pager->getOffset(), $pager->getLimit());
                $options['headerText'] = 'Video Mới';
            } else {
                $count = WapGenreModel::getCountVideosByGenreCollection($c);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $videos = WapGenreModel::getVideosByGenreCollection($c, 3, $pager->getOffset(), $pager->getLimit());
                $options['headerText'] = 'Video Hot';
            }
        }
        if ($callBack) {
            $this->layout = false;
            $this->render("_ajaxList", compact('videos', 'pager', 'callBackLink', 'options'));
        } else {
            $this->render('list', array(
                'videos' => $videos,
                's' => $s,
                'c' => $c,
                'cTitle' => $cTitle,
                'sTitle' => $sTitle,
                'pager' => $pager,
                'callBackLink' => $callBackLink,
                'options' => $options
            ));
        }
    }

    public function actionArtistList()
    {
        $callBack = (int)Yii::app()->request->getParam('call_back', 0);
        $page = (int)Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberPerPage'];
        $offset = ($page - 1) * $limit;
        $artistId = (int)Yii::app()->request->getParam('artist_id');
        $artist = ArtistModel::model()->findByPk($artistId);
        $videoId = 0;
        $count = WapVideoModel::model()->countVideosSameArtist($videoId, $artistId);

        $videos = WapVideoModel::model()->getVideosSameArtist($videoId, $artistId, $offset, $limit);

        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $offset = $pager->getOffset();
        $callBackLink = Yii::app()->createUrl("video/artistList", array(
            'artist_id' => $artistId
        ));
        if ($callBack) {
            $this->layout = false;
            if ($videos)
                $this->render("_ajaxList", compact('videos', 'pager', 'callBackLink', 'artist'));
        } else {
            $this->render("artist", compact('videos', 'pager', 'callBackLink', 'artist'));
        }
    }


    public function actionView()
    {
        $id = (int)Yii::app()->request->getParam('id', 0);
        $playUrl = Yii::app()->request->getParam('url', null);
        $video = WapVideoModel::model()->available()->findByPk($id);
        $deactive = false;
        if (!$video || $video->status == VideoModel::DELETED) {
            $this->forward("/site/error", true);
        } else if ($video->status == VideoModel::DEACTIVE) {
            $deactive = true;
        }
        $genreId = $video->genre_id;
        $artistId = VideoArtistModel::model()->getArtistByVideo($video->id, 'id');
        $genreId = isset($genreId[0]) ? $genreId[0] : 0;
        $artistId = isset($artistId[0]) ? $artistId[0] : 0;

        $count = WapVideoModel::model()->countVideosSameArtist($id, $artistId);
        $pager = new CPagination($count);
        $pager->setPageSize(Yii::app()->params['numberPerPage']);
        $videoSameArtist = WapVideoModel::model()->getVideosSameArtist($id, $artistId, $pager->getOffset(), $pager->getLimit());
        $callBackLink = Yii::app()->createUrl("video/loadAjax", array('s' => 'artist', 'artist_id' => $artistId));

        //--- Check quyền nghe bài hát này
        $userType = "GUEST";
        if (Yii::app()->user->getState('msisdn')) {
            $userType = "MEMBER";
        }

        if (!empty($this->userSub)) {
            if (isset($this->userSub->package) && !empty($this->userSub->package)) {
                $package = $this->userSub->package->code;
            }
            $package = strtoupper($package);
            $userType = "SUB_" . $package;
        }

        $per = ContentLimitModel::getPermision($video->id, "video", $userType, "WAP");
        //---End check quyền nghe bài hát này
        // check like
        $like = null;

        $favourite = Yii::app()->request->getParam('favourite', null);
        $user_id = Yii::app()->user->id;
        $phone = yii::app()->user->getState('msisdn');
        $back_url = Yii::app()->params['base_url'] . Yii::app()->createUrl('video/view', array('id' => $id, 'url_key' => Common::makeFriendlyUrl($video->name)));
        if (isset($favourite) && $favourite == 1) {
            //yeu thich video
            if (!empty($user_id)) {
                $fav = WapFavouriteVideoModel::model()->favouriteVideo($id, $phone);
            } else {
                $this->redirect($this->createUrl("/account/login", array('back_url' => $back_url)));
            }
        } elseif (isset($favourite) && $favourite == 0) {
            if (!empty($user_id)) {
                $res = WapFavouriteVideoModel::model()->deleteAllByAttributes(array('msisdn' => $phone, 'video_id' => $id));
            } else {
                $this->redirect($this->createUrl("/account/login", array('back_url' => $back_url)));
            }
        }

        if ($phone) {
            $like = WapFavouriteVideoModel::model()->findByAttributes(array('video_id' => $video->id, 'msisdn' => $phone));
        }


        //meta data
        $this->itemName = $video->name;
        $this->artist = $video->artist_name;
        $this->thumb = VideoModel::model()->getAvatarUrl($video->id, 's1');
        $this->lyric = "";

        $videourl = URLHelper::buildFriendlyURL("video/view", $video->id, Common::makeFriendlyUrl($video->name));
        $this->url = $videourl;

        $this->render('view',
            compact('video', 'genreId', 'artistId',
                'videoSameArtist', 'pager',
                'callBackLink', 'like',
                'collectionCode', 'per',
                'playUrl','deactive'
            ));


    }

    public function actionLoadAjax()
    {
        $callBack = (int)Yii::app()->request->getParam('call_back', 0);
        $s = CHtml::encode(Yii::app()->request->getParam('s'));
        $videoId = (int)Yii::app()->request->getParam('id', 0);
        $artist_id = (int)Yii::app()->request->getParam('artist_id', 0);
        $genre_id = (int)Yii::app()->request->getParam('genre_id', 0);

        if ($s == 'genre') {
            $callBackLink = Yii::app()->createUrl("video/loadAjax", array('s' => 'genre', 'genre_id' => $genre_id));
            $count = WapVideoModel::model()->countVideosByGenre($genre_id);

            $pager = new CPagination($count);
            $pageSize = Yii::app()->params['pageSize'];
            $pager->setPageSize($pageSize);
            $currentPage = $pager->getCurrentPage();
            $videos = WapVideoModel::model()->getVideosByGenre($genre_id, $pager->getOffset() + 1, $pager->getLimit());
        } else {
            $callBackLink = Yii::app()->createUrl("video/loadAjax", array('s' => 'artist', 'artist_id' => $artist_id));
            $count = WapVideoModel::model()->countVideosSameArtist($videoId, $artist_id);

            $pager = new CPagination($count);
            $pageSize = Yii::app()->params['pageSize'];
            $pager->setPageSize($pageSize);
            $currentPage = $pager->getCurrentPage();
            $videos = WapVideoModel::model()->getVideosSameArtist($videoId, $artist_id, $pager->getOffset() + 1, $pager->getLimit());
        }

        if ($callBack) {
            $this->renderPartial("_ajaxList", compact('videos', 'pager'), false, true);
        } else {
            $this->renderPartial("_same", compact('videos', 'pager', 'callBackLink'), false, true);
        }
    }

    public function actionCharge()
    {
        $id = Yii::app()->request->getParam('id');
        $video = VideoModel::model()->findByPk($id);
        $action = Yii::app()->request->getParam('action', 'playVideo');
        $deviceId = yii::app()->session['deviceId'];
        $msg = "";
        $playUrl = '';
        if (!$video) {
            $this->redirect($this->createUrl("site/error404"));
        }
        $back_url = Yii::app()->params['base_url'] . Yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name)));
        if (Yii::app()->user->isGuest) {

            if ($action == 'downloadVideo') {
                $this->redirect($this->createUrl("/account/login", array('back_url' => $back_url)));
                Yii::app()->end();
            } else {
                //cho nghe 5 lan free
                $limit = isset(Yii::app()->session["limit_play"]) ? Yii::app()->session["limit_play"] : 0;
                if ($limit >= 5) {
                    $msg = Yii::app()->params['message']['limit_content'];
                } else {
                    Yii::app()->session["limit_play"] = Yii::app()->session["limit_play"] + 1;
                    $playUrl = VideoModel::model()->getVideoFileUrl($video->id, $deviceId, 'rtsp', true);
                    $this->redirect($this->createUrl("video/view", array('url' => $playUrl, "id" => $id, 'url_key' => $video->url_key)));
                }
                $this->render('play', compact('msg', 'back_url', 'playUrl'));
                exit;
            }
        }
        if ($action == 'downloadVideo' && empty($this->isSub)) {
            $msg = "Quý khách vui lòng đăng ký dịch vụ để tải miễn phí nội dung";
            $this->render('download', compact('msg', 'back_url'));
            exit;
        }
        $bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
        $client = new SoapClient($bmUrl, array('trace' => 1));
        if($action == 'playVideo'){
            $params = array(
                'code' => $video->code,
                'from_phone' => Yii::app()->user->getState('msisdn'),
                'source_type' => 'wap',
                'promotion' => 0,
            );
            $result = $client->__soapCall('playVideo', $params);
        }elseif($action =='downloadVideo'){
            $params = array(
                'code' => $video->code,
                'from_phone' => yii::app()->user->getState('msisdn'),
                'to_phone' => yii::app()->user->getState('msisdn'),
                'source_type' => 'wap',
                'promotion' => 0,
                'smsId' => '',
                'noteOptions' => array(),
            );
            $result = $client->__soapCall('downloadVideo', $params);
        }

        $errorCode = $result->message;
        // Log url trả về cho user
        if ($errorCode == "success") {
            if ($action == 'playVideo') {
                $playUrl = VideoModel::model()->getVideoFileUrl($video->id, $deviceId, 'rtsp', true);
            } else {
                $playUrl = VideoModel::model()->getDownloadUrl($video->id, $deviceId, 'http', true);
            }
            $this->redirect($this->createUrl("video/view", array('url' => $playUrl, "id" => $id, 'url_key' => $video->url_key)));
        } else {
            $msg = Yii::app()->params['subscribe'][$errorCode];
        }
        $this->render('play', compact('msg', 'back_url', 'playUrl'));
    }

}
