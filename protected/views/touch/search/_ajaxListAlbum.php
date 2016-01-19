<?php
$albums = $total_results['album']['results'];
?>

<?php
if($albums):
foreach ($albums as $album) :

    $link = Yii::app()->createUrl('album/view', array(
        'id' => $album['id'],
        'url_key' => Common::makeFriendlyUrl($album['name']),
        "artist"=>Common::makeFriendlyUrl(trim($album['artist_name']))
    ));
    $artist_name = $album['artist_name'];
    $avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl('s1', $album['id']), '', array(
                'class' => 'avatar'
    ));
    ?>
    <li class="item">
    	<a href="<?php echo $link ?>">
			<?php echo $avatarImage;?>
			<h3><?php echo CHtml::encode($album['name']) ?></h3>
    		<ul class="info"><li><?php echo $artist_name ?></li></ul>
		</a>
	</li>
<?php endforeach; ?>
<?php else:?>
<li><?php echo Yii::t("wap","Abum not found");?></li>
<?php endif;?>