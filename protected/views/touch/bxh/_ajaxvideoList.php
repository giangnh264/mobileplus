<li class="li-spacer" id="<?php echo ($pager->getCurrentPage() + 1)?>">
	<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1) ?>">
</li>
<?php
$i = $limit * $pager->getCurrentPage();
foreach ( $topWeek as $video) :
$i++;

	$link = Yii::app ()->createUrl ( 'video/view', array (
			'id' => $video->id,
			'url_key' => Common::makeFriendlyUrl ( $video->name ),
			"artist"=>Common::makeFriendlyUrl(trim($video->artist_name))
	) );

$name = explode("-", $video['name']);
	?>

<li data-corners="false" data-shadow="false" data-iconshadow="true"
	data-wrapperels="div" data-icon="arrow-r" data-iconpos="right"
	data-theme="d"
	class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-d"><div
		class="ui-btn-inner ui-li">
		<div class="ui-btn-text">
		<span class="xbh-count-album index"><?php echo $i;?></span>
			<?php
	 	$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video->id), 'avatar', array('class' => 'video-avatar-bxh','align'=>'left'));
		echo $avatarImage;
	 	?>

				<a href="<?php echo $link?>"
				class="ui-link-inherit subtext"> <?php echo CHtml::encode($video->name)?> </a> <span
				class="artist-name subtext"><?php echo CHtml::encode($video->artist_name)?></span>
		</div>
		<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
	</div></li>

<?php endforeach;?>