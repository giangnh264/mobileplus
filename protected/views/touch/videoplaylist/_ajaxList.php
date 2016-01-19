<?php
foreach ($videoPlaylists as $videoPlaylist) :

    $link = Yii::app()->createUrl('videoplaylist/view', array(
        'id' => $videoPlaylist->id,
        'baseid' => isset($videoPlaylist->base_id) ? $videoPlaylist->base_id : 0,
        'url_key' => Common::makeFriendlyUrl($videoPlaylist->name)
    ));
    if(isset($options['col'])&&$options['col']){
        $link = Yii::app()->createUrl('videoplaylist/view', array(
        'id' => $videoPlaylist->id,
        'baseid' => isset($videoPlaylist->base_id) ? $videoPlaylist->base_id : 0,
        'url_key' => Common::makeFriendlyUrl($videoPlaylist->name),
        'src'=>$options['col']
    ));
    }
    $artist_name = ArtistHelper::ArtistNamesByVideoPlaylist($videoPlaylist->id);
    $avatarImage = CHtml::image(WapVideoPlaylistModel::model()->getThumbnailUrl(100, $videoPlaylist['id']), 'avatar', array('class' => 'avatar'));
    ?>
    <li class="item">
    	<a href="<?php echo $link ?>">
			<?php echo $avatarImage;?>
            <h3 class="subtext"><?php echo CHtml::encode($videoPlaylist->name) ?></h3>
            <ul class="info subtext"><li><?php echo CHtml::encode($artist_name); ?></li></ul>
	</a>
	</li>
<?php endforeach; ?>