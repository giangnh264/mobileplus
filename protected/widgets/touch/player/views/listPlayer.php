<?php
$songFirst = $this->songs[0];
$playUrl = WapSongModel::model()->getAudioFileUrl($songFirst->id, '', 'http', $songFirst->profile_ids);
?>
<div class="player-plist">
	<div class="play-song">
            <p id="song-playing" class="subtext"><?php echo $songFirst->name;?></p>
	</div>
	<div class="hide-html5">
		<audio controls="controls" id="audio"
			oncanplay="myOnCanPlayFunction()"
			oncanplaythrough="myOnCanPlayThroughFunction()"
			onloadeddata="myOnLoadedData()" ontimeupdate="updateProgressBar()">
			<source id="mp3_src" type="audio/mpeg" src="<?php echo $playUrl;?>"/>
		</audio>
	</div>
	<div class="pdplay">
		<div class="pdcontrol">
			<div id="prev"></div>
			<div class="play control" id="play"></div>
			<div class="pause control" id="pause" style="display: none;"></div>
			<div id="next"></div>
		</div>
		<div id="progress">
			<div id="progress_box">
				<div style="" id="load_progress">
					<div style="left: 0px;" id="hand_progress" class="hand-control"></div>
					<div style="width: 0px;" id="play_progress"></div>
				</div>
			</div>
		</div>
		<div id="play_time">
			<div id="current_time_display">00:00</div>
		</div>
	</div>
</div>
<?php
$phone = Yii::app()->user->getState('msisdn');
$like = null;
if ($phone) {
	$userId = WapUserModel::model()->findByAttributes(array('phone'=>$phone))->id;

}
?>
<div class="action">
	<table class="action_album" width="100%">
		<tr>
			<?php
			$width = ($this->type=='playlist')?'50%':'33%';
			if($this->type!='playlist'):
			?>
			<!--<td width="<?php /*echo $width;*/?>" align="center" id="album-<?php /*echo  $this->album->id;*/?>">
				<a onclick="<?php /*echo $this->like ? "VegaCoreJs.dislikethis" : "VegaCoreJs.likethis"; */?>('album', <?php /*echo $this->album->id; */?>, 'detail');"
					href="javascript:;">
						<p>
							<i class="vg_icon <?php /*if($this->like):*/?>icon_action_dislike<?php /*else:*/?>icon_action_like<?php /*endif;*/?>"></i>
						</p>
						<?php /*if($this->like):*/?>
						<p><?php /*echo Yii::t("wap","DisLike");*/?></p>
						<?php /*else:*/?>
						<p><?php /*echo Yii::t("wap","Like");*/?></p>
						<?php /*endif;*/?>
				</a>
			</td>-->
			<?php endif;?>
			<!--<td align="center" width="<?php /*echo $width;*/?>">
				<?php /*$share_url = 'http://www.facebook.com/share.php?u=' . Yii::app()->createAbsoluteUrl('/video/view', array('id'=> $this->album->id, 'url_key'=> $this->album->url_key)) ;*/?>
				<a href="<?php /*echo $share_url*/?>" target="_blank">
				<p>
					<i class="vg_icon icon_action_share"></i>
				</p>
				<p><?php /*echo Yii::t("wap","Share");*/?></p>
				</a>
			</td>-->
			<td align="center" width="<?php echo $width;?>">
				<a href="#" id="lyric-icon">
				<p>
					<i class="vg_icon icon_lyricss"></i>
				</p>
				<p><?php echo Yii::t("wap","Lyric");?></p>
				</a>
			</td>
		</tr>
	</table>
</div>
<!-- list song -->
<div class="box-content clear album-player">
	<ul class="song_list items-list" id="listSong">
		<?php
		$i=0;
		foreach($this->songs as $key => $song):
			$artist_name = Common::makeFriendlyUrl($song->artist_name);
		$link = Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
		$i++;
		?>
	 	<li class="item item-in-list song-item-<?php echo ($i-1) ?>" id="item-<?php echo ($i-1) ?>">
			<a href="javascript:void(0)"> <span class="fll album_number"><?php echo $i;?></span>
				<h3><?php echo CHtml::encode($song->name)?></h3>
				<?php if(!empty($song->artist_name)):?>
				<ul class="info">
					<li><?php echo CHtml::encode($song->artist_name)?></li>
				</ul>
				<?php endif;?>
			</a>
			<div id="lyric-<?php echo $song->id ?>" style="display: none;">
				<?php
				if(isset($song->song_extra) && $song->song_extra->lyrics!=""){
					$p = new CHtmlPurifier();
					$p->options = array('HTML.ForbiddenElements' => array('p', 'span','a','script'));
					$content = $p->purify($song->song_extra->lyrics);
					$lyric = nl2br($content);
				}else{
					$lyric = Yii::t("wap","Lyric Updating");
				}
				?>
				<?php  echo $lyric; ?>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php 
if(!empty($this->controller->userPhone) && empty($this->controller->userSub) && Yii::app()->session['src']=='ads'):?>
<script  type="text/javascript">
<?php if($this->controller->isPromotion){?>
var txt_popup = decodeURIComponent("<?php echo rawurlencode(ConfigModel::getConfig("PLAYER_REG_KM_TEXT")); ?>");
<?php }else{?>
var txt_popup = decodeURIComponent("<?php echo rawurlencode(ConfigModel::getConfig("PLAYER_REG_CHARG_TEXT")); ?>");
<?php }?>
var ssid = 'album_<?php echo $this->controller->userPhone.Yii::app()->session->sessionID;?>';
</script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/touch/js/vplayer_ads_album.js?v=1.0"></script>
<?php else:?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/touch/js/vplayer.js?v=1.0"></script>
<?php endif;?>
<script type="text/javascript">
$(document).ready(function(){
	var albumObj = {
				id:<?php echo $this->album->id ?>,
				name:"<?php echo CHtml::encode($this->album->name) ?>",
				listSong:{}
			};
	listSong = Array();
	<?php
		foreach($this->songs as $key => $song):
		$playUrl = WapSongModel::model()->getAudioFileUrl($song->id, '', 'http', $song->profile_ids);
	?>
	var item = {
		title: "<?php echo $song->name ?>",
		mp3: "<?php echo $playUrl; ?>",
		id: <?php echo $song->id?>,
		code: '<?php echo $song->code?>',
		listen_price: '<?php echo $song->listen_price ?>',
		duration:'<?php echo $song->duration?>',
		detailUrl:"<?php echo Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>Common::makeFriendlyUrl($song->artist_name))); ?>"
		<?php /*lyric:"<?php echo base64_encode($lyric) ?>"*/?>
	};
	listSong.push(item);
	<?php endforeach;?>
	$("#mp3_src").attr("src",listSong[0].mp3);

	albumObj.listSong = listSong;

	<?php if($this->type=='album'):?>
	new albumPlayer("audio",albumObj);
	<?php else:?>
	new playlistPlayer("audio",albumObj);
	<?php endif;?>
})
</script>
