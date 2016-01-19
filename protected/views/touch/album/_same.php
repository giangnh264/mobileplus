<?php if(!empty($albums)): ?>
<ul class="album_list items-list">
		<?php 
		$i=0;
		foreach ($albums as $key => $album):
			$i++;
			$albumLink = yii::app()->createUrl('album/view', array('id' => $album->id, 'url_key' => Common::makeFriendlyUrl($album->name), "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
			if ($album->id) {
				$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl("s4", $album->id),$album->name, array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
			}
		?>
		<li class="item">
			<a href="<?php echo $albumLink ?>">
				<?php echo $avatarImage;?>
				<h3 class="subtext padT10"><?php echo CHtml::encode($album->name, 10, 0);?></h3>
    			<ul class="subtext info"><li><?php echo CHtml::encode($album->artist_name, 10, 0) ?></li></ul>
			</a>
		</li>
		<?php endforeach;?>
</ul>
<?php else:?>
<div class="pad-10"><?php echo Yii::t("wap","Updating");?></div>
<?php endif;?>