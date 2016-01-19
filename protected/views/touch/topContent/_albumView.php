<?php
if ($content->id) {
	$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl("s4", $content->id), $content->name,array('class' => 'avatar'));
} else {
	$avatarImage = CHtml::image('/touch/css/wap/images/icon/clip-50.png', '', array('class' => 'avatar'));
}
$artist_name = $content->artist_name;
?>
<div class="vg_album">
	<?php echo $avatarImage;?>
	<h3 class="name"><?php echo CHtml::encode($content->name);?></h3>
	<p class="artist subtext"><?php echo CHtml::encode($artist_name); ?></p>
</div>
<?php
if($perLimit):
?>
<div class="limit_content">
	<div class="msglimit">
		<?php echo $perLimit->msg_warning;?>
	</div>
</div>
<?php else:?>
<?php 
$this->widget ( 'application.widgets.touch.player.ListPlayer', array (
		'album' => $content,
		'songs'=>$songsOfAlbum,
		'like'=>$like,
) );
?>
<?php endif;?>