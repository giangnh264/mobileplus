<?php if(!empty($albums)): ?>
<ul class="album_list items-list">
		<?php
		$i=0;
		foreach ($albums as $key => $album):
			$artist_name = ArtistHelper::ArtistNamesByAlbum($album['id']);
			$i++;
			$albumLink = yii::app()->createUrl('album/view', array('id' => $album['id'], 'url_key' => Common::makeFriendlyUrl($album['name']),"artist"=>Common::makeFriendlyUrl(trim($album['artist_name']))));
			if ($album['id']) {
				$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(100, $album['id']), 'avatar', array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/images/icon/clip-50.png', '', array('class' => 'avatar',));
			}
		?>
		<li class="item <?php if($i==count($albums)) echo 'last_item';?>">
			<a href="<?php echo $albumLink ?>">
				<?php echo $avatarImage;?>
                            <h3 class="subtext padT10"><?php echo CHtml::encode($album['name']);?></h3>
                            <ul class="info"><li><?php echo CHtml::encode($album['artist_name']);?></li></ul>
			</a>
		</li>
		<?php endforeach;?>
</ul>
<?php else:?>
<div class="pad-10"><?php echo Yii::t('wap','Không tìm thấy album nào')?></div>
<?php endif;?>