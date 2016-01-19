<?php if ($this->songs): ?>
<ul class="list_song lists_song <?php echo ($this->type == 'BXH') ? 'chart_song' : ''; ?>">
<?php $i = 0; ?>
<?php foreach ($this->songs as $song):
$urlKey = isset($song->url_key)?trim($song->url_key,"-"):Common::makeFriendlyUrl($song->name);
$artist_name = Common::makeFriendlyUrl($song->artist_name);
$link = Yii::app()->createUrl("song/view",array("id"=>$song->id,"title"=>$urlKey,'artist'=>$artist_name));
if (!empty($song->song_statistic) && !empty($song->song_statistic->played_count)) {
	$totalPlay = $song->song_statistic->played_count;
} else{
	$totalPlay = 0;
}
$duration = isset($song->duration)?$song->duration:250;
?>
	<li class="clb <?php echo ($this->type == 'BXH' && $i < 3) ? 'song_top' : ''; ?>" id="song_<?php echo $song->id; ?>">
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
                            <?php echo Formatter::smartCut(CHtml::encode($song->name), 28) ?>
                        </a>
                        <?php if($song->video_id > 0):?>
                            <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                            <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key, "artist"=>Common::makeFriendlyUrl($song->artist_name)));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                                <i class="icon icon_video"></i>
                            </a>
                        <?php endif;?>
                    </h3>
		</div>
		<div class="col2 fll">
			<h4><a href="#"><?php echo Formatter::smartCut(CHtml::encode($song->artist_name), 23) ?></a></h4>
		</div>
		<div class="col3 fll"><?php echo Yii::t('web','{total} views',array('{total}'=>$totalPlay)); ?></div>

		<?php if ($this->type == 'playlist'): ?>
		<?php $deleteAction = Yii::app()->createUrl("/playlist/deleteSong/s_id/".$song->id."/p_id/".$this->playlist_id); ?>
		<div class="col4 flr"><a onclick="submitDelete(this, '<?php echo (string)$deleteAction; ?>', 'song_<?php echo $song->id; ?>')" href="javascript:void(0)"><?php echo Yii::t('web','Delete'); ?></a></div>
		<?php endif; ?>

		<div class="meta-content hide" style="display: none;">
			<span class="content_song_id"><?php echo $song->id?></span>
		</div>
	</li>
	<?php $i++; ?>
<?php endforeach;?>
</ul>
<?php else: ?>
	<p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
<?php endif; ?>
