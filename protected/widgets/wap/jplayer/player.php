<?php

class player extends CWidget {

    public $songList = array();
    public $errorCode = "";
    public $errorText = "";
    public $autoPlay = "";
    public $freeWifi = false;
    var $basePath;
    var $listJs;
    var $detectDevice;

    public function init() {
        parent::init();
        $this->publishAssets();
    }

    public function publishAssets() {
    	if($this->freeWifi){
    		if(!Yii::app()->user->getState('is3G')){
    			$localConfig = require(Yii::getPathOfAlias('application.config').'/local.php');
    			Yii::app()->params['storage'] = $localConfig['params']['storage'];
    		}
    	}
    	
        $list = "";
        $deviceId = yii::app()->session['deviceId'];
        $deviceProfile = SongModel::model()->getSongProfileIdSuport($deviceId, 'http');
        foreach ($this->songList as $song) {
            //$audioTest = 'http://audio.chacha.vn/songs/output/22/184609/4.mp3';
            $playUrl = WapSongModel::model()->getAudioFileUrl($song->id, $deviceId, 'http', $song->profile_ids ,$deviceProfile);
            $playeCount = ($song->song_statistic) ? $song->song_statistic->played_count : 0;
            $songName = str_replace("'", "\'", $song->name);
            $songArtist = str_replace("'", "\'", $song->artist_name);
            $list .= "{
				title:'{$songName}',
				mp3:'{$playUrl}',
				song_id:'{$song->id}',
				artist:'{$songArtist}',
				play_count:'{$playeCount}',
			 },";
        }
        $this->listJs = $list;

        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');

        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        $this->basePath = $baseUrl;
        if (is_dir($assets)) {
            //Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.jplayer.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.jplayer.js', CClientScript::POS_HEAD);
            //Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jplayer.playlist.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jplayer.playlist.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/player.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/skin/jplayer-custom.css');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/skin/jplayer.blue.monday.css');
            Yii::app()->clientScript->registerCssFile('http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css');
        } else {
            throw new CHttpException(500, 'Player - Error: Couldn\'t find assets to publish.');
        }
    }

    public function run() {
        $this->detectDevice = new Mobile_Detect();
        $userSub = WapUserSubscribeModel::model()->getUserSubscribe(Yii::app()->user->getState('msisdn'));
        if (empty($userSub)) {
            $is_sub = 0;
        } else {
            $is_sub = 1;
        }
		if($this->freeWifi){
			$view = 'player_wifi';
		}else{
			$view = 'player';
		}
        $this->render("$view", array(
            'is_sub' => $is_sub,
            'errorCode' => $this->errorCode,
            'errorText' => $this->errorText,
            'autoPlay' => $this->autoPlay
        ));
    }

}
