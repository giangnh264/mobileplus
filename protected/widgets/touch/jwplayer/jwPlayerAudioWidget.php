<?php
class jwPlayerAudioWidget extends CWidget
{
    public $id='myaudio';
    public $assetsPath;
    public $data;
    public $primary='html5';//html5, flash, primaryCookie
    public $autostart='true';
    public $songId;
    public $width='100%';
    public $height='66';
    public function init()
    {

        $assets = dirname(__FILE__) . '/assets';
        $this->assetsPath  = Yii::app()->assetManager->publish($assets,false,1,YII_DEBUG);

        if(empty($this->data))
        {
            $data[] = array(
                'file'=>$this->assetsPath.'/default.mp3',
                'label'=>'128K'
            );
            $data[] = array(
                'file'=>$this->assetsPath.'/default.mp3',
                'label'=>'320K VIP'
            );
            //$source = json_encode($data);
        }
        $song = SongModel::model()->findByPk($this->songId);
        $source = SongModel::model()->builDataPlayerSong($this->songId, $song);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($this->assetsPath . '/jwplayer.js', CClientScript::POS_END);
        $cs->registerScript('play_audio_mobile'.$this->id,"
            jwplayer('".$this->id."').setup({
                width: '".$this->width."',
                height: '".$this->height."',
                stretching: 'none',
                sources: $source,
                skin:'".$this->assetsPath."/vega-skin-audio-min-2.xml',
                autostart: ".$this->autostart.",
                primary: '".$this->primary."'
            });",CClientScript::POS_END);
        //log and track
        $deviceType = 'mobile';
        $cs->registerScript('play_audio_mobile_current' . $this->id, "
            var device_type = '".$deviceType."';
            var listPlayed =Array();
            var logPlayAudioFlag = true;
			jwplayer().onBeforePlay(function() {
				logPlayAudioFlag = true;
				console.log('set flag again|'+logPlayAudioFlag);
			});
			jwplayer().onTime(function(event) {
				if(Math.round(event.position) >=5){
					if(logPlayAudioFlag) {
						logPlayAudioFlag = false;
                        var action = 'Play Song';
						if(in_array_item(listPlayed,'song_'+".$song->id.")){
							var action = 'Replay Song';
						}
						var item = 'song_".$song->id."';
                        if(!in_array_item(listPlayed,item)){
                            listPlayed.push(item);
                        }
                        console.log(device_type+'-'+action);
						ga('send', 'event', device_type, action,'".CHtml::encode($song->name."-".$song->artist_name."-".$song->id)."');
						ajax_load('/player/logSong',{'id':".$song->id."});
					}
				}
			});", CClientScript::POS_END);
        /*$cs->registerScript('play_audio_cookie'.$this->id,"
            var primaryCookie = 'html5';
            var cookies = document.cookie.split(';');
            for (i=0; i < cookies.length; i++) {
                var x = cookies[i].substr(0, cookies[i].indexOf('='));
                var y = cookies[i].substr(cookies[i].indexOf('=') + 1);
                x = x.replace(/^\s+|\s+$/g,'');
                if (x == 'primaryCookie') {
                    primaryCookie = y;
                }
            }
        ",CClientScript::POS_END);*/
        parent::init();
    }
    public function run()
    {
        $this->render('play_audio');
    }
}