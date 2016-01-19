
<?php
if ($playlist->id) {
	$avatarImage = CHtml::image(WapPlaylistModel::model()->getThumbnailUrl(100, $playlist->id), 'avatar', array('class' => 'avatar'));
} else {
	$avatarImage = CHtml::image('/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
}
 //$artist_name = WapArtistModel::model()->findByPk($playlist->artist_id)->name;
?>
<div class="vg_album">
	<?php echo $avatarImage;?>
	<h3 class="name"><?php echo Formatter::smartCut(CHtml::encode($playlist->name), 10, 0);?></h3>
	<p class="artist"><?php echo CHtml::encode($user_msisdn) ?></p>
</div>

<?php
$this->widget ( 'application.widgets.touch.player.ListPlayer', array (
		'album' => $playlist,
		'songs'=>$songsOfPlaylist,
		'type'=>'playlist'
) );
?>

<ul class="orther clb">
	<li style="width: 100%"><a class="same active"><?php echo Yii::t("wap","Playlist same creator");?></a></li>
</ul>
<div id="res-albums">
<?php
	$this->widget('application.widgets.touch.playlist.MyPlaylistWidget',array('playlist'=>$playlistsSameUser));
?>
</div>
