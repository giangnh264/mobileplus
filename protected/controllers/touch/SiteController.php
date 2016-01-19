<?php
class SiteController extends TController
{
	const _NUMBER_ITEM = 4;
	public function actionIndex() {
		$limit = self::_NUMBER_ITEM;
		$albums = WapAlbumModel::getListHot(1, $limit);
		$videos = WapVideoModel::getListByCollection('VIDEO_HOT', 1, $limit);
		$songs = WapSongModel::getListByCollection('SONG_HOT', 1, 5);
		$news = WapNewsModel::getTopNews(0, 5);
        $video_playlist =  WapVideoPlaylistModel::getListByCollection('VIDEO_PLAYLIST_HOT', 1, $limit);
		$this->render("index", compact('albums','videos','songs','news','video_playlist'));
	}
	public function actionError()
	{
        $this->render('error');
	}
	public function actionAppDownload()
	{
		$this->render('app_download');
	}
       public function actionLoadLang() {
        $path = Yii::getPathOfAlias('application.messages');
        $data = require_once $path.DS.Yii::app()->language.DS."js.php" ;
        $this->renderPartial("lang",compact('data'), false, true);
    }

    public function actionChangeLang() {
        $this->layout = false;
        $lang = CHtml::encode(Yii::app()->request->getParam("lang", 'vi-vn'));
        $url =  base64_decode(Yii::app()->request->getParam("url", '/'));

        if($url === FALSE) {
        	// redirect to homepage
        	$url = '/';
        } else {
        	$path = parse_url($url);

        	if (isset($path['host'])) {
        		$url = (isset($path['path'])) ? $path['path'] : '/';
        	}
        }
        if ($lang){
            //Yii::app()->session['lang'] = $lang;
        	$cookie = new CHttpCookie('lang', $lang);
        	$cookie->expire = time() + 60 * 60 * 24 * 7;
        	Yii::app()->request->cookies['lang'] = $cookie;
        }

        $this->redirect($url);
    }
	public function actionPopupDk()
	{
		$this->renderPartial('popup_dk');
	}
	public function actionPopupKm()
	{
		$this->renderPartial('popup_km');
	}
        
        public function actionUrl()
    {
        Yii::import("application.vendors.Hashids.*");
        $hashStr =  Yii::app()->request->getParam('code');
        $hashStrId = substr($hashStr, 2);
        $prefix =  substr($hashStr, 0,2);

        $hashids = new Hashids(Yii::app()->params["hash_url"]);
        $parse = $hashids->decode($hashStrId);
        if(!isset($parse[0])){
            throw new CHttpException(404);
        }
        $id = $parse[0];
        $_GET["id"] = $id;
        $_GET["url_key"] = Yii::app()->request->getParam('url_key');
        switch ($prefix){
            case "pl":
            case "ab":
                $this->forward("album/view",true);
                break;
            case "pu":
                $this->forward("playlist/view",true);
                break;
            case "so":
                $this->forward("song/view",true);
                break;
            case "mv":
                $this->forward("video/view",true);
                break;
            case "cs":
                $this->forward("collection/view",true);
                break;
            case "hl":
                $this->forward("html/view",true);
                break;
            case "bx":
                $dataBxhId = array(
                    'song_VN'=>1,
                    'song_KOR'=>2,
                    'song_EUR'=>3,
                    'video_VN'=>4,
                    'video_KOR'=>5,
                    'video_EUR'=>6,
                    'album_VN'=>7,
                    'album_KOR'=>8,
                    'album_EUR'=>9
                );
                $key = array_search ($id, $dataBxhId);
                $keyEx = explode('_',$key);
                $_GET["type"] = $keyEx[0];
                $_GET["genre"] = $keyEx[1];
                $this->forward("bxh/index",true);
                break;
            default:
                $this->forward("site/error",true);
                break;
        }
    }

    public function actionUrl2()
    {
        Yii::import("application.vendors.Hashids.*");
        $hashStr =  Yii::app()->request->getParam('code');
        $hashStrId = substr($hashStr, 2);
        $prefix =  substr($hashStr, 0,2);
        $url_key = Yii::app()->request->getParam('url_key');
        $hashids = new Hashids(Yii::app()->params["hash_url"]);
        $parse = $hashids->decode($hashStrId);
        $id = $parse[0];
        $_GET["id"] = $id;

        $action = Yii::app()->request->getParam('action');
        switch ($prefix){
            case "gr":
                //$_GET["url_key"] = Yii::app()->request->getParam('url_key');
                $_GET["type"] = Yii::app()->request->getParam('gt');
                if($_GET["type"]=='moi') $_GET["type"]='new';
                if(!in_array($_GET["type"], array('new','hot'))){
                    $_GET["type"] = 'hot';
                }
                if($action=='bai-hat') $action='song';
                //echo '<pre>';print_r($_GET);exit;
                $this->forward("$action/list",true);
                break;
            case "at":
                $this->forward("artist/view",true);
                break;
            case "ai":
                //$_GET['keyword'] = $url_key.'-'.$_GET['gt'];
                //echo '<pre>';print_r($_GET);exit;
                $this->forward("artist/index",true);
                break;
            case "tv":
                //echo '<pre>';print_r($_GET);exit;
                $this->forward("topContent/view",true);
                break;
            case "ti":
                //echo '<pre>';print_r($_GET);exit;
                $_GET['name'] = $url_key.'-'.$_GET['gt'];
                $this->forward("tag/index",true);
                break;
            default:
                $this->forward("site/error",true);
                break;
        }
    }
    public function actionUrl3()
    {
        Yii::import("application.vendors.Hashids.*");
        $hashStr =  Yii::app()->request->getParam('code');
        $hashStrId = substr($hashStr, 2);
        $prefix =  substr($hashStr, 0,2);
        $url_key = Yii::app()->request->getParam('url_key');
        $hashids = new Hashids(Yii::app()->params["hash_url"]);
        $parse = $hashids->decode($hashStrId);
        $id = $parse[0];
        $_GET["id"] = $id;

        $action = Yii::app()->request->getParam('action');
        switch ($prefix){
            case "tt":
                $_GET["type"] = Yii::app()->request->getParam('action_sub');
                $this->forward("topContent/tag",true);
                break;
            case "at":
                $ac = Yii::app()->request->getParam('action_sub');
                $controller = '';
                if($ac=='bai-hat'){
                    $tab = 'song';
                    $controller = 'song';
                }elseif($ac=='video'){
                    $tab = 'mv';
                    $controller = 'video';
                }elseif($ac == 'album'){
                    $controller = 'album';
                    $tab = 'album';
                }elseif($ac=='tieu-su'){
                    $tab = 'info';
                }else{
                    $tab = $ac;
                }
                $_GET["tab"] = $tab;
                if($tab!=''){
                    $_GET["artist_id"] = $_GET["id"];
                    echo $controller;
                    $this->forward("/".$controller."/artistList",true);
                }else
                    $this->forward("artist/view",true);
                break;
            case "ti":
                $ac = Yii::app()->request->getParam('action_sub');
                if($ac=='bai-hat'){
                    $type = 'song';
                }else{
                    $type = $ac;
                }
                $_GET["type"] = $type;
                $_GET["name"] = $url_key;
                $this->forward("tag/index",true);
                break;
            default:
                $this->forward("site/error",true);
                break;
        }
    }


}