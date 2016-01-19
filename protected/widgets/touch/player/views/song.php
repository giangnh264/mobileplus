<style>
<!--
.before-load{
	background: none!important;
}
-->
</style>
<?php
$isFirefox = false;
if(strrpos($_SERVER["HTTP_USER_AGENT"], "Firefox")!==false){
	$isFirefox = true;
}
	$playUrl = WapSongModel::model()->getAudioFileUrl($this->song->id, '', 'http', $this->song->profile_ids);
?>

<div class="hide-html5">
	<audio controls="controls" preload="auto" id="audio" oncanplay="myOnCanPlayFunction()"
       oncanplaythrough="myOnCanPlayThroughFunction()"
       onloadeddata="myOnLoadedData()" ontimeupdate="updateProgressBar()"  type="audio/mpeg">
		<source id="mp3_src" type="audio/mpeg" src="<?php echo $playUrl ?>" />
	</audio>
</div>
<?php if($this->controller->deviceOs =='ANDROIDOS' && !$isFirefox):?>
<div class="play control before-load" id="play">
<img width="61" height="61" src="<?php echo Yii::app()->request->baseUrl;?>/touch/images/loading-small.gif" />
</div>
<?php else:?>
<div class="play control" id="play"></div>
<?php endif;?>
<div class="pause control" id="pause" style="display: none;"></div>
<div id="progress">
	<div id="progress_box">
		<div style="" id="load_progress">
			<div style="left: 0px;" id="hand_progress" class="hand-control">
			</div>
			<div style="width: 0px;" id="play_progress">
			</div>
		</div>
	</div>
</div>
<div id="play_time">
	<span id="current_time_display"><?php echo Formatter::formatDuration($this->song->duration) ?></span>
</div>
<div class="loading-data" id ="loading-data" style="display: none;">
	<img alt="" src="<?php echo Yii::app()->request->baseUrl;?>/touch/images/loading-small.gif" width="60">
</div>
<?php
if(YII_DEBUG){
	echo '<a href="'.$playUrl.'">'.$playUrl.'</a>';
}

?>
<?php
if(!empty($this->controller->userPhone) && empty($this->controller->userSub) && Yii::app()->session['src']=='ads'):?>
<script  type="text/javascript">
<?php if($this->controller->isPromotion){?>
var txt_popup = decodeURIComponent("<?php echo rawurlencode(ConfigModel::getConfig("PLAYER_REG_KM_TEXT")); ?>");
<?php }else{?>
var txt_popup = decodeURIComponent("<?php echo rawurlencode(ConfigModel::getConfig("PLAYER_REG_CHARG_TEXT")); ?>");
<?php }?>
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/touch/js/vplayer_ads.js?v=1.0"></script>
<?php else:?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/touch/js/vplayer.js?v=1.0"></script>
<?php endif;?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	var songObj = <?php echo CJSON::encode($this->song); ?>;
	var chachaPlayer = new audioPlayer("audio",songObj);
	<?php
	//check is Subscribe, dùng chrome, android
	$userSubs = WapUserSubscribeModel::model()->getUserSubscribe(Yii::app()->user->getState('msisdn'));
	/* if ($userSubs):
	?>
	setTimeout(function() {
		chachaPlayer._play();
	},50);

	<?php endif;*/ ?>
})
<?php if(Yii::app()->session['src']=='ads'):?>
var ssid = '<?php echo Yii::app()->session->sessionID;?>';
var u = VegaCoreJs.getCookie('<?php echo Yii::app()->session->sessionID;?>');
if(u==null){
	var u = '<?php echo $this->song->id;?>';
	VegaCoreJs.setCookie('<?php echo Yii::app()->session->sessionID;?>',u,1);
}else{
	if(u.indexOf(<?php echo $this->song->id;?>)<0){
		u = u+','+'<?php echo $this->song->id;?>';
		VegaCoreJs.setCookie('<?php echo Yii::app()->session->sessionID;?>',u,1);
	}
}
<?php endif;?>
//]]>
</script>