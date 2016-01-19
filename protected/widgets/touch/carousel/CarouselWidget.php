<?php
class CarouselWidget extends CWidget
{
	public $_assetsUrl ='';
	public $data = null;
	public function init()
	{
		$assetPath = Yii::getPathOfAlias('application.widgets.touch.carousel.assets');
		$this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetPath,false,1,YII_DEBUG);
		$cs=Yii::app()->getClientScript();
		$cs->registerCssFile($this->_assetsUrl."/carousel.css");
		$cs->registerCssFile($this->_assetsUrl."/carousel-style.css");
		$cs->registerScriptFile($this->_assetsUrl."/carousel.js", CClientScript::POS_END);
		parent::init();
	}
	public function run()
	{
		$this->render('default', array(
				'data'=>$this->data
		));
	}
}