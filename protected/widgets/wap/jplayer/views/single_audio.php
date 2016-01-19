<?php 
$is_user = (!Yii::app()->user->isGuest)?"before-load":"";
if(!Yii::app()->user->isGuest || $free) {
$deviceId = yii::app()->session['deviceId'];
$playUrl = WapSongModel::model()->getAudioFileUrl($this->song->id, $deviceId, 'http', $this->song->profile_ids);	
?>
<script type="text/javascript">
var firstclick = 0;
var success = 0;
var inti;
$(document).ready(function() {    
    var audio = document.getElementById("new_audio");
    // neu sau 10 giay ko load dc File thi Hide Player
    inti = setInterval(function(){
        if (audio.networkState!=1 && audio.networkState!=2){
            inti = window.clearInterval(inti);
            $(".li_play").hide();$(".li_pause").hide();
        }	
    },10000);
});
function playSong(){
    if($("#auto-play").hasClass("before-load"))
        return false;
    if(success == 1){
        successPlay();
    }
    if(firstclick==0){
        $.ajax({
            type: "GET",
            url: "<?php echo Yii::app()->createUrl("song/charging",array('id'=>$this->song->id)) ?>",
            context: document.body,
            async: false,
            success: function(data){            
                if(data != 'success'){
                    $("#error_msg").html(''+data+'');
                    _dialog("error_play","");
                    return false;
                }
                else{
                    success = 1;
					setTimeout(function() {	
						successPlay();
					},0);
                    
                    return true;
                }                
            }
        });
    }
    firstclick++;   
}
//get audio, play
var dev_mode = <?php echo (Yii::app()->user->getState('msisdn') == '84948867431')?"1":"0"?>;


function successPlay(){
    $(".li_play").hide();$(".li_pause").show();
    var audio = document.getElementById("new_audio");
	audio.play();	  	
    $("#song_time").html(formatSecondsAsTime(audio.duration));
    
}
//get audio, pause
function pauseSong(){
    var audio = document.getElementById("new_audio");
    audio.pause();
    $(".li_pause").hide();$(".li_play").show();
}
function updateProgressBar(){
    var audio = document.getElementById("new_audio");
    var time_ = audio.currentTime * 100 / audio.duration;
    $("#jp-play-bar").css('width',time_+'%');
}
function hideLoading(){
    $("#auto-play").removeClass("before-load");
    inti = window.clearInterval(inti);
//    $(".overlay_player").hide();
}
function formatSecondsAsTime(secs) {
  var hr  = Math.floor(secs / 3600);
  var min = Math.floor((secs - (hr * 3600))/60);
  var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

  if (min < 10){ 
    min = "0" + min; 
  }
  if (sec < 10){ 
    sec  = "0" + sec;
  }

  return min + ':' + sec;
}
//]]>
</script>
<?php } ?>
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio single_player">
    <div class="jp-type-playlist">
        <div class="overlay_player" id="overlay_player" style="height: 90px !important;display: none"></div>
        <div id="jp-interface" class="jp-gui jp-interface" style="height: 80px!important;">        	
            <div id="nowplaying">
                <div id="playingtext"><marquee direction="left" scrolldelay="150"><?php echo $this->song->name?></marquee></div>
                <div class="jp-time-holder">
                    <div class="jp-duration cl6" id="song_time"></div>
                </div>
            </div>
            <div id="control-progress">
                <ul class="jp-controls" id="jp-controls">
                    <li class="li_play"><a href="javascript:;" <?php if(Yii::app()->user->isGuest && !$free){ echo 'onclick="document.location = \'/account/login\';"';} else echo 'onclick="playSong()"'?> 
                           class="jp-play before-load" id="auto-play" tabindex="1" >play</a>
                    </li>
                    <li class="li_pause"><a href="javascript:;" class="jp-pause" tabindex="1" onclick="pauseSong()">pause</a></li>
                    <li class="li_error"><a href="javascript:;" class="jp-error" tabindex="1">&nbsp;</a></li>
                </ul>
                <div class="jp-progress" id="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar" id="jp-play-bar"></div>
                    </div>
                </div>
            </div>

        </div>        
        <div class="jp-no-solution">
            <?php 
            $url = yii::app()->createUrl('song/charging', array('id' => $this->song->id, 'autoplay' => 1));
            echo yii::t('wap','<a style="color: #F60!important; font-weight:bold;font-size: 12px;" onclick=" window.location.href=\''.$url.'\' " href="'.$url.'">Nếu không nghe được, vui lòng nhấn vào đây</a>');
            ?>
        </div>
    </div>
</div>
<?php
$style = "";
if(Yii::app()->user->getState('msisdn') != '84948867431'){
	$style = "display: none";
}
?>

<audio style="<?php echo $style ?>" controls preload="auto" oncanplay="hideLoading()" id="new_audio" ontimeupdate="updateProgressBar()">
  <source src="<?php echo $playUrl?>" type="audio/mpeg">
Your browser does not support the audio element.
</audio>

<?php if($is_user){ ?>
<div id="confirm_play" style="display:none">
    
<?php
echo yii::app()->params['charging']['confirmText'];
echo CHtml::button("Đăng ký", array('id' => 'register_btn', 'onclick' => 'register()'));
echo CHtml::button("Tiếp tục", array('id' => 'continue_btn'));
echo CHtml::button("Không hỏi lại nữa", array('id' => 'dontask_btn'));
?>
</div>


<div id="error_play" style="display:none">
<?php
echo '<div id="error_msg"></div>';
?>
</div>
<?php } ?>
