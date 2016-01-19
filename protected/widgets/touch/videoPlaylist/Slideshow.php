<?php
/**
 * class videoPlaylistList
 *
 * @author : longtv
 */
class Slideshow extends CWidget
{
    public $controller;    
    public function init()
    {
    	$assetPath = Yii::getPathOfAlias('application.widgets.touch.carousel.assets');
    	$assetsUrl = Yii::app()->getAssetManager()->publish($assetPath,false,1,YII_DEBUG);
    	$cs=Yii::app()->getClientScript();
    	$cs->registerCssFile($assetsUrl."/carousel.css");
    	$cs->registerCssFile($assetsUrl."/carousel-style.css");
    	$cs->registerScriptFile($assetsUrl."/carousel.js", CClientScript::POS_END);
    	$cs->registerScript("video_playlist_slide","
    			$('.m-carousel').carousel();
    	", CClientScript::POS_END);
    	parent::init();
    }

    public function run()
    {
    	$action = Yii::app()->controller->action->id;
    	$s = Yii::app()->request->getParam('s', '');
    	$slideVideos = null;
    	if($this->controller == 'video' && $action == 'index' && $s == null) {
    		//$slideVideos = WapVideoModel::getListByCollection('VIDEO_HOT', 1, 3);
    		$channel = 'web';
    		$sql = "SELECT c2.artist_name as artist_name, t.name, t.id,t.object_id
					FROM `news_event` `t` left join video c2 ON t.object_id=c2.id 
					WHERE channel = '$channel' AND type='video' 
					ORDER BY t.sorder ASC, t.id DESC
    				";
    		$slideVideos = Yii::app()->db->createCommand($sql)->queryAll();
    	}    	
        $this->render('slideshowWidget', array('controller' => $this->controller,  
        			'action' => $action, 
        			's' => $s,
        			'slideVideos' => $slideVideos,
        ));
    }
}
?>
