<?php
if($playlist):
		foreach ($playlist as $key => $playlist):
		$user = isset($playlist->msisdn)?$playlist->msisdn: $playlist->username;
			$playlistLink = yii::app()->createUrl('playlist/view', array('id' => $playlist->id, 'url_key' => Common::makeFriendlyUrl($playlist->name)));
			if ($playlist->id) {
				$avatarImage = CHtml::image(WapPlaylistModel::model()->getThumbnailUrl(100, $playlist->id), '', array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', '', array('class' => 'avatar'));
			}
		?>
		<li class="item" id="idpl-<?php echo $playlist->id; ?>">
			<a href="<?php echo $playlistLink ?>">
				<?php echo $avatarImage;?>
				<h3><?php echo WapCommonFunctions::substring($playlist->name, ' ', 6);?></h3>
    			<ul class="info"><li><?php echo WapCommonFunctions::substring($user, ' ', 6) ?></li></ul>
			</a>
			<a class="rm-pl" href="#" onclick="VegaCoreJs.deletePl('<?php echo $playlist->id ?>','<?php echo Yii::app()->createUrl('/playlist/Del', array('id'=>$playlist->id));?>')"><img style="width:32px ;height:32px" class= "delpl" alt="deletepl" src="/images/bt_delete_myplaylist_press.PNG"></a>
		</li>
		
		<?php endforeach;?>


<?php endif;?>