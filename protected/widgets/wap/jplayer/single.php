<?php
class single extends CWidget
{
	public $song;
	public $autoPlay;
	public $isDev = false;
        public $free = false;
        var $basePath;
	var $detectDevice;
	
	public function init()
	{
		parent::init();
		$this->publishAssets();
	}
	public function publishAssets() {

		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		
		$assets = dirname(__FILE__) . '/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		$this->basePath = $baseUrl; 
		if (is_dir($assets)) {
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.jplayer.min.js', CClientScript::POS_HEAD);
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/android.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/skin/jplayer-custom.css');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/skin/jplayer.blue.monday.css');
			Yii::app()->clientScript->registerCssFile('http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css');
		} else {
			throw new CHttpException(500, 'Player - Error: Couldn\'t find assets to publish.');
		}
	}
	
	public function run()
	{
		$this->detectDevice = new Mobile_Detect();		
		$userSub = Yii::app()->user->getState('userSub');//WapUserSubscribeModel::model()->getUserSubscribe(Yii::app()->user->getState('msisdn'));
		if(empty($userSub)){
			$is_sub = 0;
		}else{
			$is_sub = 1;
		}
		$sufix = "";
		if($this->isDev){
			$sufix = "_test";
		}
                
		$this->render("single".$sufix,array('free'=>  $this->free,
						'is_sub'=>$is_sub,
					));

	}
}