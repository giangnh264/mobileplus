<?php
class jwPlayerVideoWidget extends CWidget
{
    public $id='myvideo';
    public $assetsPath;
    public $imageAds = '';
    public $data;
    public $primary='html5';//html5, flash, primaryCookie
    public $autostart='true';
    public $videoId;
    public $offset=0;//0: xuat hien ngay; n: xuat hien sau n(s)
    public $expand=true;
    public $mode='mobile';
    public $height=388;
    public $width='100%';
    public $deviceId = '';
    public function init()
    {
        $assets = dirname(__FILE__) . '/assets';
        $this->assetsPath  = Yii::app()->assetManager->publish($assets,false,1,YII_DEBUG);

        if(empty($this->imageAds))
        {
            $this->imageAds = '/web/images/bg_default.png';
        }
        if(empty($this->data))
        {
            $data[] = array(
                'file'=>'https://s3.amazonaws.com/jomedia-jwplayer/samples/tears-of-steel.mp4',
                'label'=>'128K'
            );
            $data[] = array(
                'file'=>'https://s3.amazonaws.com/jomedia-jwplayer/samples/tears-of-steel.mp4',
                'label'=>'320K VIP'
            );
            $source = json_encode($data);
        }
        $video = VideoModel::model()->findByPk($this->videoId);

        //check xem co phai iphone 3G khong
        $device = Yii::app()->session['device'];

        /*if(!empty($device) && $device['os'] == 'iOS' && (int) Yii::app()->session['deviceOS'] <= 6 ){
            $source = VideoModel::model()->builDataPlayerVideo($this->videoId,null, Yii::app()->params['video.profile.default']['iphone'][0]);
        }else {
            $source = VideoModel::model()->builDataPlayerVideo($this->videoId);
        }*/
        $source = VideoModel::model()->builDataPlayerVideo($this->videoId);
        $image = AvatarHelper::getAvatar("video", $this->videoId, 640);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($this->assetsPath . '/jwplayer.js', CClientScript::POS_END);
        $cs->registerScript('play_video'.$this->id,"
            jwplayer('".$this->id."').setup({
                width: '".$this->width."',
                height: ".$this->height.",
                image: '".$image."',
                sources: $source,
                autostart: ".$this->autostart.",
                expand: '".$this->expand."',
                primary: '".$this->primary."',
                /*plugins: {
                    '".$this->assetsPath."/vast.js': {
                      client:'vast',
                      schedule:{
                        overlay: { offset: ".$this->offset.", tag: '".Yii::app()->createUrl('/player/banner')."', type:'nonlinear' }
                      }
                    }
                  }*/
            });
        ",CClientScript::POS_END);
        if($this->expand) {
            $cs->registerScript('play_video_expand' . $this->id, "
            function onPlayerExpandCollapse() {

                if(jwplayer('" . $this->id . "').getFullscreen) {
                    jwplayer('" . $this->id . "').setFullscreen(false);
                }
                if($('.video_player').width() <= 745){
                    $('.colum2').css({'margin-top':'20px'});
                    $('.video_player').css({'height':'540px'});
                    $('.video_player').css({'width':'960px'});
                    $('#player-holder').removeClass('watch-normal-mode');
                    $('#player-holder').addClass('watch-large-mode');
                    $('.video_player .colum2').css({'margin-top':'-370px'});
                    onPlayerExpand();
                }else{
                    onPlayerCollapse();
                    $('.colum2').css({'margin-top':''});
                    $('.video_player').css({'height':'390px'});
                    $('.video_player').css({'width':'745px'});
                    $('#player-holder').removeClass('watch-large-mode');
                    $('#player-holder').addClass('watch-normal-mode');
                }
            }

            function onPlayerExpand() {
              jwplayer('" . $this->id . "').resize(960,540);
            }

            function onPlayerCollapse() {
              jwplayer('" . $this->id . "').resize(745,390);
            }
            ;
        ", CClientScript::POS_END);
        }
        //track and log

        $deviceType = 'mobile';
        $isUserLogin = Yii::app()->user->isGuest?'false':'true';
        $cs->registerScript('play_video_current' . $this->id, "
        var device_type = '".$deviceType."';
        var listPlayed =Array();
        var playVideoFlag = true;
        var logedin = ".$isUserLogin.";
        jwplayer().onPlay(function(){
            console.log(JSON.stringify(check_video_quality()));
            if(!check_video_quality()){
             jwplayer('".$this->id."').pause();
            }

        });
        jwplayer().onBeforePlay(function() {

            playVideoFlag = false;
        });
        jwplayer().onTime(function(event) {
            if(Math.round(event.position) >=5){
                if(playVideoFlag) {
                    playVideoFlag = false;
                    var action = 'Play Video';
                    if(in_array_item(listPlayed,'video_".$video->id."')){
                        var action = 'Replay Video';
                    }
                    var item = 'video_".$video->id."';
                    if(!in_array_item(listPlayed,item)){
                        listPlayed.push(item);
                    }
                    console.log(device_type+'-'+action);
                    ga('send', 'event', device_type, action,'".CHtml::encode($video->name."-".$video->artist_name."-".$video->id)."');
                    ajax_load('/player/logVideo',{'id':".$video->id."});
                }
            }
        });
        ", CClientScript::POS_END);

        //check login 720p
        $obj = array("obj_type"=>'video','name'=>$video->name,'id'=>$video->id,'artist'=>$video->artist_name);
        $urlDetail = URLHelper::makeUrl($obj);
        $lac = Yii::app()->user->getState('last_action');
        $lurl = Yii::app()->user->getState('last_url');
        Yii::app()->user->setState('last_url',null);
        $register_url = Yii::app()->createUrl("account/package");
        $login_url = Yii::app()->createUrl("account/login");
        $js='';
        if($lac=='720p' && $lurl==$urlDetail && !Yii::app()->user->isGuest){
            $js = 'jwplayer().setCurrentQuality(0);';
        }
        $js = 'jwplayer().setCurrentQuality(0);';

        $cs->registerScript('play_video_current_changeQ' . $this->id, "

                jwplayer().onQualityLevels(function(event){
                    var currQIndex = jwplayer().getCurrentQuality();
                    var currQL = jwplayer().getQualityLevels();
                    var bitrate = currQL[currQIndex].label;
                    if(logedin==false && bitrate=='720p'){
                        jwplayer().setCurrentQuality(currQIndex+1);
                    }
                    jwplayer().setCurrentQuality(currQIndex+1);
                });
                jwplayer().onQualityChange(function(event){
                    var logedin = false;

                    $.ajax({
                        url: '/ajax/isAuthenticate',
                        type: 'post',
                        data: {fa:'720p',url_return:'".$urlDetail."'},
                        async: false,
                        dataType: 'json',
                        success: function(data){
                            if(data.errorCode==0){
                                logedin = true;
                            }
                        }
                    })
                    var currEQIndex = jwplayer().getCurrentQuality();
                    var currQL = jwplayer().getQualityLevels();
                    var bitrate = currQL[currEQIndex].label;

                    if(logedin==false && bitrate=='720p'){
                         var html = 'Quý khách vui lòng đăng ký để nghe miễn phí nội dung chất lượng cao.';
                            html += '<div class=\"clb ovh\">';
                            html += '<div class=\"btn-popup btn-popup-green\" style=\"width: 45%; float: left;\">';
                            html += '<a href=\"  $register_url \" class=\"show\" style=\"color: #FFF\">Đăng ký</a>';
                            html += '</div>';
                            html += '<div class=\"btn-popup btn-popup-green\" style=\"width: 45%; float: right;\">';
                            html += '<a href=\"javascript::void();\" onclick=\"Popup.close()\" class=\"show\" style=\"color: #FFF\">Hủy</a>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                         Popup.alert(html);


                    }
                });
            ",CClientScript::POS_END);
        $cs->registerScript('check_current_video' . $this->id, "
        function check_video_quality(){
            var anable_play = true;
            var currEQIndex = jwplayer().getCurrentQuality();
            var currQL = jwplayer().getQualityLevels();
            var bitrate = currQL[currEQIndex].label;
            if(!userSubs){
                console.log(JSON.stringify(bitrate));
                if(userPhone && bitrate == '720p'){
                   return false;
                }else{
                }
            }
        }
            ",CClientScript::POS_END);
        parent::init();
    }
    public function run()
    {
        $this->render('play_video');
    }
}