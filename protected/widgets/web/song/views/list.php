<?php if ($this->songs): ?>
<ul class="list_song lists_song <?php echo ($this->type == 'BXH') ? 'chart_song' : ''; ?>">
<?php $i = 0; ?>
<?php foreach ($this->songs as $song):
$urlKey = isset($song->url_key)?trim($song->url_key,"-"):Common::makeFriendlyUrl($song->name);
$artist_name = Common::makeFriendlyUrl($song->artist_name);
$link = Yii::app()->createUrl("song/view",array("id"=>$song->id,"title"=>$urlKey, 'artist'=>$artist_name));
if (!empty($song->song_statistic) && !empty($song->song_statistic->played_count)) {
	$totalPlay = $song->song_statistic->played_count;
} else{
	$totalPlay = 0;
}
$duration = isset($song->duration)?$song->duration:250;
?>
	<li class="clb <?php echo ($this->type == 'BXH' && $i < 3) ? 'song_top' : ''; ?>">
		<?php if ($this->type == 'BXH'): ?>
		<div class="stt fll">
			<?php echo (($i < 9) ? '0' : '') . (string)($i + 1); ?>.
		</div>
		<div class="img_artist fll">
			<a href="<?php echo $link; ?>" title="<?php CHtml::encode($song->name); ?>">
				<img src="<?php echo AvatarHelper::getAvatar("artist", $song->song_artist[0]->artist_id, 50)?>" alt="song" />
			</a>
		</div>
		<?php endif; ?>
		<div class="col1 fll">
                    <h3>
                        <a href="<?php echo $link?>" title="<?php echo CHtml::encode($song->name) ?>" >
                            <?php echo Formatter::smartCut(CHtml::encode($song->name), 27) ?>
                            	<?php if(SongModel::model()->isHQ($song->profile_ids)):?>
	                            &nbsp;&nbsp;<i class="hq">HQ</i>
	                            <?php endif;?>
                        </a>
                        <?php if($song->video_id > 0):?>
                            <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                            <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key, "artist"=>Common::makeFriendlyUrl($song->artist_name)));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                                <i class="icon icon_video"></i>
                            </a>
                        <?php endif;?>
                    </h3>
		</div>
		<div class="col2 fll" style="height: 45px;">
			<?php
			$artistName = str_replace("-", ",", $song->artist_name);
			$artistList = explode(",", $artistName);
			$j=0;
			foreach ($artistList as $artist):
			$artist = trim($artist);
			?>
			<h4><a href="<?php echo Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($artist))); ?>" title="<?php echo CHtml::encode($artist) ?>"><?php echo Formatter::smartCut(CHtml::encode($artist), 23) ?></a></h4>
			<?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
			<?php $j++; endforeach;?>
		</div>
		<div class="col3 fll"><?php echo Yii::t('web','{total} views',array('{total}'=>$totalPlay)); ?></div>
		<div class="col4 flr"><?php echo Formatter::formatDuration($duration)?></div>
		<div class="more_action <?php echo ($this->type == 'USER') ? 'shorter' : ''; ?> content_action">
			<ul>
				<li><a href="javascript:;" title="<?php echo Yii::t("web", "Like"); ?>" class="like_song" id="song-<?php echo $song->id?>"><i class="icon icon_like"></i></a></li>
				<li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Download"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
				<li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Add to playlist"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
				<li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Download/Gift ringbacktone"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/rbt", array("id" => $song->id)) ?>" ><i class="icon icon_phone"></i></a></li>
				<li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Gift ringbacktone"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/gift", array("id" => $song->id)) ?>"><i class="icon icon_gift"></i></a></li>
				<?php $shareLink = Yii::app()->request->getHostInfo().Yii::app()->request->baseUrl . URLHelper::buildFriendlyURL("song", $song->id, $urlKey);?>
				<li><a title="<?php echo Yii::t("web", "Share via facebook"); ?>" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&amp;t=<?php echo urlencode($song->name);?>" target="_blank"><i class="icon icon_share"></i></a></li>
			</ul>
		</div>
		<div class="meta-content hide" style="display: none;">
			<span class="content_song_id"><?php echo $song->id?></span>
		</div>
	</li>
	<?php $i++; ?>
<?php endforeach;?>
</ul>
<?php else: ?>
	<p><?php echo Yii::t('web','Not found anything!');?></p>
<?php endif; ?>
