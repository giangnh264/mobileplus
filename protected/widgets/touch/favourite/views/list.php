<?php if(!empty($datas)): ?>
<div class="box-content clear">
	<ul data-role="listview" data-inset="true" class="items-list">
		<?php 
		$i=0;
		foreach ($datas as $key => $data):
		$artist_name = WapArtistModel::model()->findByPk($data->artist_id)?WapArtistModel::model()->findByPk($data->artist_id)->name:'';
			$i++;
			if ($type == "ALBUM")
			{
			$link = yii::app()->createUrl('album/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name),"artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
			if ($data->id) {
				$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(100, $data->id), 'avatar', array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
			}
			}
			elseif ($type =="VIDEO")
			{
				$link = yii::app()->createUrl('video/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name), "artist"=>Common::makeFriendlyUrl(trim($data->artist_name))));
				if ($data->id) {
					$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $data->id), 'avatar', array('class' => 'avatar'));
				} else {
					$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
				}
			}
			else
			{
				$artist_name = Common::makeFriendlyUrl($song->artist_name);
				$link = yii::app()->createUrl('song/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name), 'artist'=>$artist_name));
				if ($data->id) {
					$avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(100, $data->artist_id), 'avatar', array('class' => 'avatar'));
				} else {
					$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
				}
			}
		?>
		<li>
		
			<a href="<?php echo $link ?>" class="i-list-favourite">
				<span class="i-thumb-favourite album-thumb">
					<?php echo $avatarImage;?>
				</span>
				<p><?php echo WapCommonFunctions::substring($data->name, ' ', 6);?></p>
				<span class="i-artist"><?php echo WapCommonFunctions::substring($artist_name, ' ', 6) ?></span>
				</a>
		</li>
		
		<li class="row-more" onclick="showtoolbar(this)">
			<div class="toolbar" style="display: none;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle">
							<a href="#playsong"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/icon_bar_play.png" /></a>
						</td>
						<td align="center" valign="middle">
							<a href="#playsong"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/icon_bar_play.png" /></a>
						</td>
						<td align="center" valign="middle"></td>
					</tr>
				</table>
			</div>
	    </li>
		<?php endforeach;?>
	</ul>
	<div class="load-more-page"><img src="<?php echo Yii::app()->theme->baseUrl?>/images/ajax_loading.gif" width="30px" /></div>
</div>
<?php else:?>
<div><?php echo Yii::t('wap','Updating')?></div>
<?php endif;?>