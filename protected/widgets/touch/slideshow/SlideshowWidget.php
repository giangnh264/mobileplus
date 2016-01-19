<?php
class SlideshowWidget extends  CWidget{
    public $_assetsUrl ='';
    public $data = null;
    public function init()
    {
        $assetPath = Yii::getPathOfAlias('application.widgets.touch.slideshow.assets');
        $this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetPath,false,1,YII_DEBUG);
        $cs=Yii::app()->getClientScript();
        $cs->registerCssFile($this->_assetsUrl."/swiper.min.css");
        $cs->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/zepto/zepto.min.js');
        $cs->registerScriptFile($this->_assetsUrl.'/swiper.min.js');
        parent::init();
    }
    public function run()
    {
        $this->render('slideshow', array(
        'data'=>$this->data
    ));
    }
}
