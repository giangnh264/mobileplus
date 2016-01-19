<?php
foreach ($albums as $album) :

    $link = Yii::app()->createUrl('album/view', array(
        'id' => $album->id,
        'url_key' => Common::makeFriendlyUrl($album->name),
        "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))
    ));
    $artist_name = ArtistHelper::ArtistNamesByAlbum($album->id);
    $avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(100, $album['id']), 'Avatar', array('class' => 'avatar'));
    ?>
    <li class="item">
    	<a href="<?php echo $link ?>">
		<?php echo $avatarImage;?>
            <h3 class="subtext"><?php echo CHtml::encode($album->name) ?></h3>
            <ul class="info subtext"><li><?php echo CHtml::encode($artist_name); ?></li></ul>
        </a>
	</li>
<?php endforeach; ?>