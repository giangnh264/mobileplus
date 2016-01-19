<?php

class AlbumController extends TController {

    /**
     * function actionIndex
     * call to render hot album page
     */
    public function actionIndex(){
        $limit = Yii::app()->params['numberPerPage'];
        if($this->layout == 'application.views.wap.layouts.main'){
            $limit = Yii::app()->params['numberSongPerPageWap'];
        }
        $page = (int) 1;
        $count_new = WapAlbumModel::countListByCollection('ALBUM_NEW');
        $albums_new = WapAlbumModel::getListNew($page, $limit);
        $pager = new CPagination($count_new);
        $pager->setPageSize($limit);

        $albums_hot = WapAlbumModel::getListHot($page, $limit);
        $arr_albums = array(
            array('headerText' => 'Album hot', 'album' => $albums_hot,
                'link' => Yii::app()->createUrl('album/list', array('s'=>'hot','page'=>2)), 'options' => array('col' => 'ALBUM_HOT','headerText'=>'ALBUM HOT')),
            array('headerText' => 'Album mới', 'album' => $albums_new,
                'link' => Yii::app()->createUrl('album/list', array('s'=>'new','page'=>2)), 'options' => array('col' => 'ALBUM_NEW','headerText'=>'ALBUM NEW')),
        );
        $this->render('index', compact('arr_albums', 'pager'));
    }

    public function actionList() {
        $limit = Yii::app()->params['numberPerPage'];
        $c = CHtml::encode(Yii::app()->request->getParam('id', '0'));
        $c = (int)(!empty($c)) ? $c : '0';
        $s = CHtml::encode(Yii::app()->request->getParam('type'));
        $s = (!empty($s)) ? $s : Yii::t('wap','Hot');
        $s = strtoupper($s);
        $cTitle = ($c == 0) ? Yii::t('wap','All genres') : WapGenreModel::model()->findByPk($c)->name;
        $sTitle = ($s == 'NEW') ? Yii::t('wap','New') : $s;
        $page = (int) Yii::app()->request->getParam('page', 1);
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $callBackLink = Yii::app()->createUrl("album/list", array('type' => $c, 's' => $s, 'c' => $c));
        $options = array();
        if ($c == 0) {
            if ($s == 'NEW') {
                $count = WapAlbumModel::countListByCollection('ALBUM_NEW');
                $albums = WapAlbumModel::getListNew($page, $limit);
                $options = array('col' => 'ALBUM_NEW','headerText'=>"ALBUM MỚI");
            } else {
                $options = array('col' => 'ALBUM_HOT','headerText'=>"ALBUM HOT");
                $albums = WapAlbumModel::getListHot($page, $limit);
                $count = WapAlbumModel::countListByCollection('ALBUM_HOT');
            }
            $pager = new CPagination($count);
            $pager->setPageSize($limit);
        } else {
            if($s=='NEW'){
                $count = WapAlbumModel::model()->countAlbumsByGenre($c);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $albums = WapAlbumModel::model()->getAlbumsByGenre($c, $pager->getOffset(), $pager->getLimit());
            }else{
                $count = WapGenreModel::getCountAlbumsByGenreCollection($c);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $id_album_hot = 6;
                $albums = WapGenreModel::getAlbumsByGenreCollection($c, $id_album_hot, $page, $limit);
            }
        }
        if ($callBack) {
            $this->layout = false;
            $this->render("_ajaxList", compact('albums', 'pager', 'callBackLink', 'options'));
        } else {
            $this->render('list', array(
                'albums' => $albums,
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

    public function actionArtistList() {
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $page = (int) Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params['numberPerPage'];
        $offset = ($page - 1) * $limit;
        $artistId = (int) Yii::app()->request->getParam('artist_id');
        $artist = ArtistModel::model()->findByPk($artistId);
        $albumId = 0;
        $count = WapAlbumModel::model()->countAlbumsSameArtist($albumId, $artistId);

        $albums = WapAlbumModel::model()->getAlbumsSameArtist($albumId, $artistId, $offset, $limit);

        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $offset = $pager->getOffset();
        $callBackLink = Yii::app()->createUrl("album/artistList", array(
            'artist_id' => $artistId
        ));
        if ($callBack) {
            $this->layout = false;
            if ($albums)
                $this->render("_ajaxList", compact('albums', 'pager', 'callBackLink', 'artist'));
        } else {
            $this->render("artist", compact('albums', 'pager', 'callBackLink', 'artist'));
        }
    }

    /**
     * Album detail
     */

    /**
     * function actionView
     * call to render detail album page
     */
    public function actionView() {
        $albumId = (int) Yii::app()->request->getParam('id');
        $album = WapAlbumModel::model()->available()->findByPk($albumId);
        if (!$album) {
            $this->forward("/site/error",true);
        }else if($album->status ==0){
            $deactive = true;
        }

        $songsOfAlbum = WapSongModel::model()->getSongsOfAlbum($albumId);

        //samge artist
        $countAlbumsSameArtist = WapAlbumModel::model()->countAlbumsSameArtist($album->id, $album->artist_id);
        $albumPages = new CPagination($countAlbumsSameArtist);
        $pageSize = Yii::app()->params['pageSize'];
        $albumPages->setPageSize($pageSize);
        $currentPage = $albumPages->getCurrentPage();

        /* NEW */
        $artists = AlbumArtistModel::model()->getArtistsByAlbum($albumId);
        $artistIds = '';
        if ($artists) {
            foreach ($artists as $artist) {
                $artistIds .= ',' . $artist->artist_id;
            }
        }
        $artistIds = ($artistIds != '') ? substr($artistIds, 1) : '';
        $albumsSameArtist = WapAlbumModel::model()->getAlbumbyArtists($artistIds, $pageSize, $currentPage * $pageSize);
        /* END */

        $phone = yii::app()->user->getState('msisdn');
        $errorCode = 'success';
        $errorDescription = '';

        //for show price
        $favourite = Yii::app()->request->getParam('favourite', null);
        $phone = yii::app()->user->getState('msisdn');
        $user_id = Yii::app()->user->id;
        if (isset($favourite) && $favourite == 0) {
            if (!empty($user_id)) {
                $res = WapFavouriteAlbumModel::model()->deleteAllByAttributes(array('msisdn' => $phone, 'album_id' => $albumId));
            } else {
                $this->redirect($this->createUrl("/account/login"));
            }
        }
        if (isset($favourite) && $favourite == 1) {
            if (!empty($phone)) {
                $res = WapFavouriteAlbumModel::model()->favouriteAlbum($phone, $albumId);
            } else {
                $this->redirect($this->createUrl("/account/login"));
            }
        }
        $like = null;
        if ($phone) {
            $like = FavouriteAlbumModel::model()->findByAttributes(array('album_id' => $albumId, 'msisdn' => $phone));
        }
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
        $perLimit = ContentLimitModel::getPermision($albumId, "album", $userType, "WAP");
        ///meta tag
        $AlbumDetail = AlbumModel::model()->findByPk($albumId);
        $artistId = !empty($artists) ? $artists[0]->artist_id : $AlbumDetail->artist_id;
        $ArtistInfo = ArtistModel::model()->findByPk($artistId);
        $this->itemName = $AlbumDetail->name;
        $this->artist = $ArtistInfo->name;

        $this->thumb = AlbumModel::model()->getAvatarUrl($albumId, 's1');
        $this->url = URLHelper::buildFriendlyURL("album", $albumId, Common::makeFriendlyUrl($ArtistInfo->name));
        $this->description = strip_tags($AlbumDetail->description);

        $this->render('view', array(
            'album'             => $album,
            'songsOfAlbum'      => $songsOfAlbum,
            'albumsSameArtist'  => $albumsSameArtist,
            'albumPages'        => $albumPages,
            'errorCode'         => $errorCode,
            'errorDescription'  => $errorDescription,
            'userSub'           => $userSub,
            'like'              =>$like,
            'perLimit'          =>$perLimit,
            'deactive'         =>$deactive,
        ));
    }

    /**
     * Load same album via Ajax
     */
    public function actionLoadAjax() {
        $s = CHtml::encode(Yii::app()->request->getParam('s'));
        $albumId = Yii::app()->request->getParam('id', 0);
        $artist_id = (int) Yii::app()->request->getParam('artist_id', 0);
        $genre_id = (int) Yii::app()->request->getParam('genre_id', 0);
        if ($s == 'genre') {
            $countAlbumsSameGenre = WapAlbumModel::model()->countAlbumsSameGenre($albumId, $genre_id);
            $albumPages = new CPagination($countAlbumsSameGenre);
            $pageSize = Yii::app()->params['pageSize'];
            $albumPages->setPageSize($pageSize);
            $currentPage = $albumPages->getCurrentPage();
            $data = WapAlbumModel::model()->getAlbumsSameGenre($albumId, $genre_id, $currentPage * $pageSize, $pageSize);
        } else {
            $countAlbumsSameArtist = AlbumArtistModel::model()->countAlbumByArtist($artist_id);
            $albumPages = new CPagination($countAlbumsSameArtist);
            $pageSize = Yii::app()->params['pageSize'];
            $albumPages->setPageSize($pageSize);
            $currentPage = $albumPages->getCurrentPage();

//     		$data = WapAlbumModel::model()->getAlbumsSameArtist($albumId, $artist_id, $currentPage * $pageSize, $pageSize);

            /* NEW */
            $artists = AlbumArtistModel::model()->getArtistsByAlbum($albumId);
            $artistIds = '';
            if ($artists) {
                foreach ($artists as $artist) {
                    $artistIds .= ',' . $artist->artist_id;
                }
            }
            $artistIds = ($artistIds != '') ? substr($artistIds, 1) : '';
            $data = $albumsSameArtist = WapAlbumModel::model()->getAlbumbyArtists($artistIds, $pageSize, $currentPage * $pageSize);
            /* END */
        }
        $this->renderPartial('_same', array('albums' => $data), false, true);
    }

}
