<?php
$is_user = (!Yii::app()->user->isGuest)?"before-load":"";
$is_user = "before-load";
if($is_user || $this->freeWifi) {
if($this->detectDevice->isAndroidOS()){
    $device =  "ANDROID";
}else{
    $device =  "NOT ANDROID";
}
$debugMode = 0;
$is_sub=1;
?>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function(){
	var gplayer = new vplayer({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, [
		<?php echo $this->listJs; ?>
	], {
		swfPath: "<?php echo $this->basePath ?>/js",
		solution: 'html,flash',
		supplied: "mp3",
		//preload:"auto",
		//wmode: "window",
		deviceOs:"<?php echo $device?>",
		chargingPlay:"<?php echo Yii::app()->createUrl("song/charging") ?>",
        chargingAlbum:"<?php echo Yii::app()->createUrl("album/charging") ?>",
        error_ : 0,
        error_msg : '<?php echo (!empty($errorText))? $errorText: '' ; ?>',
        error_code : '<?php echo (!empty($errorCode))? $errorCode: ''  ;?>',
		is_sub: <?php echo $is_sub ?>,
		is_confirm: 1,
        pause: 1, /* mac dinh khi play bai hat thi pause = 1 (khi click nut play ko tu dong choi nhac), khi charge thanh cong thi pause = 0 */
        charged: 0,/* bai hat/album da charge thanh cong hay chua */
        playlistOptions: { autoPlay: <?php  echo (!empty($autoPlay))? $autoPlay: 0; ?> },
        debug_mode:<?php echo $debugMode;?>
	});
	var kickoff = function () {
   	 	$("#jquery_jplayer_1").jPlayer("play");
    };
    kickoff();

	/*
	 var click = document.ontouchstart === undefined ? 'click' : 'touchstart';
     var kickoff = function () {
    	 $("#jquery_jplayer_1").jPlayer("play");
       	 document.documentElement.removeEventListener(click, kickoff, true);
     };
     document.documentElement.addEventListener(click, kickoff, true);
   	*/

	$('#notshow-btn').live('click', function(){
		gplayer.resetoption('is_confirm',0);
		$("#confirm_play").dialog("close");
		return false;
	 })
	$('#continute-btn').live('click', function(){
		$("#confirm_play").dialog("close");
		return false;
	 })
});
//]]>
</script>
<?php }else{ ?>
<script type="text/javascript">
$(document).ready(function(){
    var song = $("#listSongPlaylist li:first p").html();
    $("#playingtext marquee").html(song);
});
</script>
<?php } ?>
<div id="jquery_jplayer_1" class="jp-jplayer pl-list"></div>
<div id="jp_container_1" class="jp-audio">
    <div class="jp-type-playlist">
        <div class="jp-gui jp-interface">
            <div id="nowplaying">
                <div id="playingtext"><marquee direction="left" scrolldelay="150"></marquee></div>
                <div class="jp-time-holder">
                    <div class="jp-duration cl6"></div>
                </div>
            </div>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                <li><a href="javascript:;" class="jp-play" id="auto-play" tabindex="1">play</a></li>
                <li class="li_pause"><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
            </ul>
        </div>
        <div class="jp-playlist">
            <ul>
                <li></li>
            </ul>
        </div>
        <div class="jp-no-solution">
            <?php
            $url = Yii::app()->request->url;
            $url .= '?layout=normal';
            echo yii::t('wap','<a style="color: #F60!important; font-weight:bold;font-size: 12px;" onclick=" window.location.href=\''.$url.'\' " href="'.$url.'">Nếu không nghe được, vui lòng nhấn vào đây</a>');
            ?>
        </div>
    </div>
</div>
