<?php
class Init extends  CWidget
{
	public $basePath;
	public $slider;
	public function init() {
		$this->publishAssets();
		parent::init();
	}

	public function publishAssets()
	{
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		$assets = dirname(__FILE__) . '/assets';
		$this->basePath  = Yii::app()->assetManager->publish($assets,false,1,YII_DEBUG);
		if (is_dir($assets)) {
			Yii::app()->clientScript->registerCssFile($this->basePath . '/css/slide.css');
			Yii::app()->clientScript->registerScriptFile($this->basePath . '/js/jssor.slider.mini.js', CClientScript::POS_END);
		}
	}
	public function run()
	{
		$this->render("init");
	}
}
