<?php if(!empty($videoPlaylists)): ?>
<ul class="album_list items-list">
		<?php
		$i=0;
		foreach ($videoPlaylists as $key => $videoPlaylist):
			$artist_name = ArtistHelper::ArtistNamesByVideoPlaylist($videoPlaylist['id']);
			$i++;
			$videoPlaylistLink = yii::app()->createUrl('videoplaylist/view', array('id' => $videoPlaylist['id'], 'url_key' => Common::makeFriendlyUrl($videoPlaylist['name'])));
                        if(isset($options['col'])&&$options['col']){
                            $videoPlaylistLink = yii::app()->createUrl('videoplaylist/view', array('id' => $videoPlaylist['id'], 'url_key' => Common::makeFriendlyUrl($videoPlaylist['name'])));
                        }
			if ($videoPlaylist['id']) {
				$avatarImage = CHtml::image(WapVideoPlaylistModel::model()->getThumbnailUrl(100, $videoPlaylist['id']), 'avatar', array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/images/icon/clip-50.png', '', array('class' => 'avatar',));
			}
		?>
		<li class="item">
			<a href="<?php echo $videoPlaylistLink ?>">
				<?php echo $avatarImage;?>
                            <h3 class="subtext"><?php echo CHtml::encode($videoPlaylist['name']);?></h3>
    			<ul class="info subtext"><li><?php echo CHtml::encode($videoPlaylist['artist_name']);?></li></ul>
			</a>
		</li>
		<?php endforeach;?>
</ul>
<?php else:?>
<div><?php echo Yii::t('wap','Updating')?></div>
<?php endif;?>