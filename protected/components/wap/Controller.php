<?php

/**
 * class Controller
 * define base controller
 */
class Controller extends CController {

    public $layout = '';
    public $device = null;
    public $deviceOs = null;
    public $showPopup = false;
    public $showPopupKm = false;
    public $headerText = "";
    public $isPromotion = false;
    public $userSub = null;
    public $configs = null;
    public $banners = null;
    public $deviceLayout = '';
    public $itemName;
    public $artist;
    public $thumb;
    public $url;
    public $description;
    public $keyword;
    public $lyric;
    public $video_free = false;
    public $song_free = false;
    public $album_free = false;
    public $video_playlist_free = false;
    public $promotion_realtime = false;
    public $showPopupCTKM = true;

    public function init() {
        // setup multi language
        self::_setupLanguage();

        // DETECT DEVICE
        $this->device = DeviceManager::getInstance();

        if (!isset(yii::app()->session['deviceId'])) {
            Yii::app()->session['deviceId'] = $this->device->getDeviceID();
            Yii::app()->session['device'] = $this->device->getInfo('model_name');
            Yii::app()->session['deviceOS'] = $this->device->getDeviceOs();
        }
        $this->deviceOs = Yii::app()->session['deviceOS'];
        // check user login
        if (Yii::app()->user->isGuest) {
            $identity = new UserIdentity(null, null);
            $type = 'autoLogin';
            if ($identity->userAuthenticate($type, $this->deviceOs)) {
                Yii::app()->user->login($identity);
            }
        }

        // get banners
        $this->banners = WapBannerModel::getBanner('wap');
        // reload package state if request
        if (isset($_REQUEST['reloadPackage']) && ($_REQUEST['reloadPackage'] == 1)) {
            $package = WapUserSubscribeModel::model()->getUserSubscribe(Yii::app()->user->getState('msisdn')); //get user_subscribe record by phone
            if ($package) {
                $packageObj = WapPackageModel::model()->findByPk($package->package_id);
                Yii::app()->user->setState('package', $packageObj->code);
            }
        }
        $this->promotion_realtime = WapUserSubscribeModel::model()->checkPromotion(Yii::app()->user->getState('msisdn'));
        if (!isset(Yii::app()->session['isPromotion']) || Yii::app()->session['isPromotion'] == '') {
            if ((Yii::app()->user->getState('msisdn'))) {
                //Yii::app()->session['isPromotion'] = WapUserSubscribeModel::model()->checkPromotion(Yii::app()->user->getState('msisdn'));
                Yii::app()->session['isPromotion'] = $this->promotion_realtime;
            } else
                Yii::app()->session['isPromotion'] = "";
        }
        $this->isPromotion = Yii::app()->session['isPromotion'];

        if ((Yii::app()->user->getState('msisdn'))){
            $this->userSub = WapUserSubscribeModel::model()->getUserSubscribe(Yii::app()->user->getState('msisdn'));
        }


        else
            $this->userSub = "";
        Yii::app()->user->setState('userSub', $this->userSub);

        if(!Yii::app()->user->isGuest && $this->userSub == ''){
            $this->getPopup();
        }
        $this->getPopupKM();
        $this->getPopupCTKM();

        // load config from DB
        $wap_configs = Yii::app()->cache->get("WAP_CONFIG");
        if ($wap_configs === false) {
            $wap_configs = ConfigModel::model()->getConfig('', 'wap');
            Yii::app()->cache->set("WAP_CONFIG", $wap_configs, Yii::app()->params['cacheTime']);
        }

        if (!empty($wap_configs)) {
            foreach ($wap_configs as $key => $info) {
                $config_type = $info['type'];
                if ($config_type == "string")
                    Yii::app()->params[$key] = $info['value'];
                if ($config_type == "int")
                    Yii::app()->params[$key] = intval($info['value']);
                if ($config_type == "array")
                    Yii::app()->params[$key] = unserialize($info['value']);
            }
        }

        $this->updateCache();
        return parent::init();
    }

    private function getPopup() {
        if (!$this->showPopup && !Yii::app()->session['first_time']) {
            $this->showPopup = true;
            Yii::app()->session['first_time'] = "ok";
        }
        /// ko show trong 7 ngay
        //echo Yii::app()->request->cookies['first_time_month1'];exit;
        $is_cookie = isset(Yii::app()->request->cookies['first_time_month1']);
        if ($is_cookie) {
            $this->showPopup = false;
        } else {
                $cookie = new CHttpCookie('first_time_month1', 1);
                $cookie->expire = time() + 60 * 60 * 24 * 7;
                Yii::app()->request->cookies['first_time_month1'] = $cookie;
        }

        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '/account/subscribe') !== false) {
            $this->showPopup = false;
        }
        if ($this->userSub) {
        	$this->showPopup = false;
        }
    }

    private function getPopupKM() {
        if ($this->isPromotion && !$this->showPopupKm) {
            $this->showPopupKm = true;
        }

        if (isset($_SESSION['already_popupkm'])) {
            $this->showPopupKm = false;
        }

        // ko show trong 15 ngay
        $is_cookie = isset(Yii::app()->request->cookies['showPopupKm']);
        if ($is_cookie) {
            $this->showPopupKm = false;
        }

        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '/account/subscribe') !== false) {
            $this->showPopupKm = false;
        }
        if ($this->userSub) {
        	$this->showPopupKm = false;
        }
    }

    private function getPopupCTKM() {

        if (isset($_SESSION['already_popup_ctkm'])) {
            $this->showPopupCTKM = false;
        }
        // ko show trong 15 ngay
        $is_cookie = isset(Yii::app()->request->cookies['showPopupCTKm']);
        if ($is_cookie) {
            $this->showPopupCTKM = false;
        }

        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, '/account/subscribe') !== false) {
            $this->showPopupCTKM = false;
        }
        if (!$this->userSub) {
            $this->showPopupCTKM = false;
        }
    }

    protected function _isTouchLayout() {
        //$layout = Yii::app()->request->getParam('layout', "");
        $return = false;
        $layout = 'wap';
        if(!$layout && !isset(Yii::app()->session['layout_cookie'])){
        	if($this->device->getInfo("ux_full_desktop")=="true"){
        		return true;
        	}        	
        }
        //$return = false;
        if (!$layout && isset(Yii::app()->session['layout_cookie']))
            $layout = Yii::app()->session['layout_cookie'];
        if ($layout == "touch") {
            $return = true;
        } 
        else if (($this->deviceOs == "IOS") || ($this->deviceOs == "ANDROIDOS") || ($this->deviceOs == "WINDOWOS")) {
            $infoDevice = $this->device->getAllInfo();
            $blackList = $this->isMobileBlackList($infoDevice['model_name']);
            if ($blackList) {
                Yii::app()->session['layout_cookie'] = $layout;
                return false;
            }

            //check version IOS
            if ($this->deviceOs == "IOS") {
                //$infoDevice = $this->device->getAllInfo();
                $version = $this->device->getOsVersion();
                /* if(YII_DEBUG){
                  echo $version = $this->device->getOsVersion();
                  die();
                  } */
              
            } elseif ($this->deviceOs == "WINDOWOS") {
                $layout = "touch";
                $return = true;
            } else {
                $layout = "wap";
                $return = false;
            }
            $layout = "touch";
            return true;
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        //detect BB10
        if (strpos($userAgent, 'BB10') !== false) {
            $layout = "touch";
            $return = true;
        }
        if ($layout) {
            Yii::app()->session['layout_cookie'] = $layout;
        }
        return $return;
    }

    private function isMobileBlackList($model_name = '') {
        $model = array('GT-S5360');
        return in_array($model_name, $model) ? true : false;
    }

   
     /**
     * Cai dat da ngon ngu
     */
    private static function _setupLanguage() {
    	if(!isset(Yii::app()->request->cookies['lang'])){
    		$cookie = new CHttpCookie('lang', Yii::app()->params['defaultLanguage']);
    		$cookie->expire = time() + 60 * 60 * 24 * 7;
    		Yii::app()->request->cookies['lang'] = $cookie;
    	}
    	Yii::app()->language = trim(Yii::app()->request->cookies['lang']);
    }


    /**
     * hien thi danh sach bai hat/video/album/playlist cua 1 the loai
     * @param type $genreModel
     * @param type $type
     */
    public function showList($genreModel, $type, $genre_id) {
        $arr = array(
            'song' => array('modelClass' => 'WapSongModel', 'countGenreFunc' => 'countSongsByGenre',
                'getGenreFunc' => 'getSongsByGenre', 'widget' => '', 'text' => 'Bài hát'),
            'video' => array('modelClass' => 'WapVideoModel', 'countGenreFunc' => 'countVideosByGenre',
                'getGenreFunc' => 'getVideosByGenre', 'widget' => '', 'text' => 'Video'),
            'album' => array('modelClass' => 'WapAlbumModel', 'countGenreFunc' => 'countAlbumsByGenre',
                'getGenreFunc' => 'getAlbumsByGenre', 'widget' => '', 'text' => 'Album'),
            'videoPlaylist' => array('modelClass' => 'VideoPlaylistModel', 'countGenreFunc' => 'countVideoPlaylistByGenre',
                'getGenreFunc' => 'getVideoPlaylistByGenre', 'widget' => '', 'text' => 'VideoPlaylist')
        );
        $page = Yii::app()->request->getParam('page', 1);
        $pageSize = Yii::app()->params['pageSize'];
        $headerText = $arr[$type]['text'] . " " . $genreModel->name;
        $genres_ = MainActiveRecord::getGenre();

        $countObject = $arr[$type]['modelClass']::$arr[$type]['countGenreFunc']($genreModel->id);
        $objectPages = new CPagination($countObject);
        $objectPages->setPageSize($pageSize);
        $currentPage = $objectPages->getCurrentPage();
        if (!$currentPage)
            $currentPage = 1;
        $objects = $arr[$type]['modelClass']::$arr[$type]['getGenreFunc']($genreModel->id, ($page - 1) * $pageSize, $pageSize);
        $options = array();
        $options['col'] = $headerText;
        $options['headerText'] = $headerText;
        $this->render('application.views.wap.' . $type . '.list', array($type . 's' => $objects, $type . 'Pages' => $objectPages, 'type' => 'list', 'options' => $options, 'link' => Yii::app()->createUrl('/genre'), 'genres' => $genres_, 'genre_id' => $genre_id,'pager' => $objectPages,'headerText'=>$headerText));
    }

    /**
     * Van hien thi Thong tin chi tiet bai hat, video, album, playlist.
     * Chi khi click Play/send... thi redirect /account/login
     * @param type $action
     * @return type
     */
    protected function beforeAction($action) {
        // Check video hoac bai hat co dc mien phi cuoc hay khong
        //if($action->getId() == "view" && $this->uniqueId == 'video' && Yii::app()->getRequest()->getQuery('play')){
        if ($action->getId() == "view" && $this->uniqueId == 'video') {
            $id = (int) Yii::app()->request->getParam('id');
            Yii::import("application.models.admin.*");
            $collectItem = AdminCollectionItemModel::model()->findByAttributes(array('item_id' => $id, 'collect_id' => 148));
            if ($collectItem || !Yii::app()->user->getState('msisdn')) {
                $this->video_free = true;
            }
        }
        if (($action->getId() == "view" || $action->getId() == "charging") && $this->uniqueId == 'album') {
            if (!Yii::app()->user->getState('msisdn')) {
                $this->album_free = true;
                $this->song_free = true;
            }
        }
        if (($action->getId() == "view" || $action->getId() == "charging") && $this->uniqueId == 'song') {
            $id = (int) Yii::app()->request->getParam('id');
            Yii::import("application.models.admin.*");
            $collectItem = AdminCollectionItemModel::model()->findByAttributes(array('item_id' => $id, 'collect_id' => 150));
            if ($collectItem || !Yii::app()->user->getState('msisdn')) {
                $this->song_free = true;
            }
        }
        if (Yii::app()->user->isGuest) {
            $arr_controllers = array('song', 'video', 'album', 'playlist');
            if (in_array($this->uniqueId, $arr_controllers)) {
                $actionToRun = $action->getId();
                if ($actionToRun == "view") {
                    $play = Yii::app()->getRequest()->getQuery('play', 0);
                    $download = Yii::app()->getRequest()->getQuery('download', 0);
                    if ($play || $download) {
                        if ($this->uniqueId == 'video' || $this->uniqueId == 'song') {
                            if (!$this->video_free && !$this->song_free) {
                                $this->redirect('/account/login');
                            }
                        } else {
                            $this->redirect('/account/login');
                        }
                    }
                } elseif ($actionToRun == "charging") {
                    if (!$this->song_free) {
                        $returnPath = Yii::app()->getRequest()->getQuery('returnPath', 0);
                        if (!$returnPath) {
                            $this->redirect('/account/login');
                        } else {
                            $this->redirect('/account/login');
                        }
                    }
                }
            }
        }
        return parent::beforeAction($action);
    }

    private function updateCache() {
        if (Yii::app()->request->getParam('resetcache', 0) === 1)
            Yii::app()->setComponent('cache', new CDummyCache());
    }

}
