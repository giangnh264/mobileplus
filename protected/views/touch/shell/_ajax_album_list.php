<?php
foreach ($albums as $album) :

    $link = Yii::app()->createUrl('album/view', array(
        'id' => $album->id,
        'url_key' => Common::makeFriendlyUrl($album->name),
        "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))
    ));
    $artist_name = ArtistHelper::ArtistNamesByAlbum($album->id);
    $avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(100, $album['id']), 'avatar', array('class' => 'avatar'));
    ?>
    <li class="item">
    	<a href="<?php echo $link ?>">
			<?php echo $avatarImage;?>
			<h3><?php echo CHtml::encode($album->name) ?></h3>
    		<ul class="info"><li><?php echo Formatter::smartCut($artist_name, Yii::app()->params['limit_substring'], 0); ?></li></ul>
		</a>
	</li>
<?php endforeach; ?>