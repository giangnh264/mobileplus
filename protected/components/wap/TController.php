<?php
class TController extends Controller
{
	public $layout = 'application.views.touch.layouts.main';
	public $userPhone = false;
	public $deviceLayout = 'touch';
	public $isSub = false;
	public $is3g = false;
	public function init() {
		parent::init();
		
		if(isset($_GET["src"]) && $_GET["src"]== "ads"){
			Yii::app()->session['src'] = 'ads';
		}
		//get userPhone
		if (Yii::app()->user->isGuest) {
			$identity = new UserIdentity(null, null);
			$type = 'autoLogin';
			if ($identity->userAuthenticate($type, $this->deviceOs)) {
				Yii::app()->user->login($identity);
			}
		}
		$this->userPhone = Yii::app()->user->getState('msisdn');
		$this->banners = WapBannerModel::getBanner('wap');
		//chk is subscribe
		if(!empty($this->userPhone)){
			$this->isSub = WapUserSubscribeModel::model()->chkIsSubscribe($this->userPhone);
		}
		if(Yii::app()->user->getState('is3g') == 1){
			$this->is3g = true;
		}
		$isTouch = $this->_isTouchLayout();
		if(!$isTouch){
			$this->layout = 'application.views.wap.layouts.main';
		}
	}
	
	public function getViewPath() {
		$isTouch = $this->_isTouchLayout();
		if(!$isTouch){
			$wapView = _APP_PATH_ . "/protected/views/wap/" . $this->getId();
			return $wapView;
			$action = $this->getAction()->getId();
			if(file_exists($wapView.DS.$action.".php")){
				return $wapView;
			}			 
		}
		return parent::getViewPath();
	}
	
	public function getViewFile($viewName) {
		$rs = parent::getViewFile($viewName);
		if (!file_exists($rs)) {					
			$rs = parent::getViewFile($viewName);
		}
		return $rs;
	}
}