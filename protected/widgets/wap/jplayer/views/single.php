<?php
if($this->detectDevice->isAndroidOS()||1)
    include 'single_audio.php';
else{
$is_user = (!Yii::app()->user->isGuest)?"before-load":"";
if(!Yii::app()->user->isGuest || $free) {
$deviceId = yii::app()->session['deviceId'];
$playUrl = WapSongModel::model()->getAudioFileUrl($this->song->id, $deviceId, 'http', $this->song->profile_ids);
?>

<script type="text/javascript">
$(document).ready(function() {
    var firstclick = 0;
    $(".overlay_player").show();
    $("#jquery_jplayer_1").jPlayer({
        ready: function() {
          $(this).jPlayer("setMedia", {
                title:"<?php echo $this->song->name?>",
                mp3:'<?php echo $playUrl ?>'
          })<?php //if($this->autoPlay) echo '.jPlayer("play")';?>;
        },
        supplied: "mp3",
        wmode: "window",
        solution: "html,flash",
        swfPath: "<?php echo $this->basePath ?>/js"
      });

    $("#jquery_jplayer_1").bind($.jPlayer.event.play, function() {
        if(firstclick==0)
        $.ajax({
            type: "GET",
            url: "<?php echo Yii::app()->createUrl("song/charging",array('id'=>$this->song->id)) ?>",
            context: document.body,
            success: function(data){
                firstclick++;
                if(data != 'success'){
              	  $("#jquery_jplayer_1").jPlayer("stop")
                    $("#error_msg").html(''+data+'');
                    _dialog("error_play","");
                    return false;
                }
                return true;
            }
        });
    });
    $("#jquery_jplayer_1").bind($.jPlayer.event.durationchange, function() {
        $("#auto-play").removeClass("before-load");
        if(!$("#auto-play").hasClass("before-load"))
            $(".overlay_player").hide();
    });
	$("#jquery_jplayer_1").bind($.jPlayer.event.play, function() {
        $("#auto-play").removeClass("before-load");
        if(!$("#auto-play").hasClass("before-load"))
            $(".overlay_player").hide();
    });

	$("#jquery_jplayer_1").bind($.jPlayer.event.loadstart, function() {
        $("#auto-play").removeClass("before-load");
        if(!$("#auto-play").hasClass("before-load"))
            $(".overlay_player").hide();
	});

	$("#jquery_jplayer_1").bind($.jPlayer.event.ready, function() {
        $("#auto-play").removeClass("before-load");
		$(".overlay_player").hide();
	});

});
//]]>
</script>
<?php } ?>
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio single_player">
    <div class="jp-type-playlist">
        <?php if($is_user){ ?>
        <div class="overlay_player" style="height: 90px !important;"></div>
        <?php } ?>
        <div class="jp-gui jp-interface" style="height: 80px!important;">
            <div id="nowplaying">
                <div id="playingtext"><marquee direction="left" scrolldelay="150"><?php echo $this->song->name?></marquee></div>
                <div class="jp-time-holder">
                    <div class="jp-duration cl6"></div>
                </div>
            </div>
            <div id="control-progress">
                <ul class="jp-controls" id="jp-controls">
                    <li><a href="javascript:;" <?php if(Yii::app()->user->isGuest && !$free){ echo 'onclick="document.location = \'/account/login\';"';}?> class="jp-play <?php echo $is_user; ?>" id="auto-play" tabindex="1">play</a></li>
                    <li class="li_pause"><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                </ul>
                <div class="jp-progress" id="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="jp-playlist">
            <ul>
                <li></li>
            </ul>
        </div>
        <div class="jp-no-solution">
            <?php
            $url = yii::app()->createUrl('song/charging', array('id' => $this->song->id, 'autoplay' => 1));
            echo yii::t('wap','<a style="color: #F60!important; font-weight:bold;font-size: 12px;" onclick=" window.location.href=\''.$url.'\' " href="'.$url.'">Nếu không nghe được, vui lòng nhấn vào đây</a>');
            ?>
        </div>
    </div>
</div>

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
<?php }
}?>