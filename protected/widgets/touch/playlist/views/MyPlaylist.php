<?php if(!empty($playlists)): ?>
<div class="box-content clear">
	<ul class="album_list items-list">
		<?php 
		$i=0;
		foreach ($playlists as $key => $playlist):
		$user = isset($playlist->msisdn)?$playlist->msisdn: $playlist->username;
			$i++;
			$playlistLink = yii::app()->createUrl('playlist/view', array('id' => $playlist->id, 'url_key' => Common::makeFriendlyUrl($playlist->name)));
			if ($playlist->id) {
				$avatarImage = CHtml::image(WapPlaylistModel::model()->getThumbnailUrl(100, $playlist->id), '', array('class' => 'avatar'));
				if(!file_exists(WapPlaylistModel::model()->getThumbnailUrl(100, $playlist->id))){
					$avatarImage = CHtml::image('/touch/images/playlist_default.png', '', array('class' => 'avatar'));
				}
			} else {
				$avatarImage = CHtml::image('/touch/images/playlist_default.png', '', array('class' => 'avatar'));
			}
		?>
		<li class="item" id="idpl-<?php echo $playlist->id; ?>">
			<a href="<?php echo $playlistLink ?>">
				<?php echo $avatarImage;?>
				<h3><?php echo Formatter::smartCut(CHtml::encode($playlist->name), 10, 0);?></h3>
    			<ul class="info"><li><?php echo Formatter::smartCut($user, Yii::app()->params['limit_substring'], 0) ?></li></ul>
			</a>
			<a class="rm-pl" href="#" onclick="VegaCoreJs.deletePl('<?php echo $playlist->id ?>','<?php echo Yii::app()->createUrl('/playlist/Del', array('id'=>$playlist->id));?>')"><img class= "delpl" alt="deletepl" src="<?php echo Yii::app()->params['base_url'] .'/touch/images/bt_delete_myplaylist_press.PNG';?> "></a>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php else:?>
<div><?php echo Yii::t('wap','Updating')?></div>
<?php endif;?>