<?php if(!empty($videoPlaylists)): ?>
<ul class="album_list items-list">
		<?php 
		$i=0;
		foreach ($videoPlaylists as $key => $videoPlaylist):
			$i++;
			$videoPlaylistLink = yii::app()->createUrl('videoPlaylist/view', array('id' => $videoPlaylist->id, 'url_key' => Common::makeFriendlyUrl($videoPlaylist->name)));
			if ($videoPlaylist->id) {
				$img = WapVideoPlaylistModel::model()->getThumbnailUrl("s1", $videoPlaylist->id);
				$avatarImage = CHtml::image($img);
				if(!file_exists($img)){
					$avatarImage = CHtml::image('/touch/images/video_default.jpg', 'avatar', array('class' => 'avatar'));
				}
			} else {
				$avatarImage = CHtml::image('/touch/images/video_default.jpg', 'avatar', array('class' => 'avatar'));
			}
		?>
		<li class="item">
			<a href="<?php echo $videoPlaylistLink ?>">
				<?php echo $avatarImage;?>
                <h3 class="subtext"><?php echo CHtml::encode($videoPlaylist->name);?></h3>
    			<ul class="info subtext"><li><?php echo CHtml::encode($videoPlaylist->artist_name) ?></li></ul>
			</a>
		</li>
		<?php endforeach;?>
</ul>
<?php else:?>
<div><?php echo Yii::t('wap','Updating')?></div>
<?php endif;?>