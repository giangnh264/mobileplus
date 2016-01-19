<?php if(!empty($datas)): ?>
<div class="box-content clear">
	<ul data-role="listview" data-inset="true" class="items-list">
		<?php 
		$i=0;
		foreach ($datas as $key => $data):
		$artist_name = WapArtistModel::model()->findByPk($data->artist_id)->name;
			$i++;
			if ($type == "ALBUM")
			{
			$link = yii::app()->createUrl('album/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name),"artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
			if ($data->id) {
				$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(100, $data->id), 'avatar', array('class' => 'avatar'));
			} else {
				$avatarImage = CHtml::image('/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
			}
			}
			elseif ($type =="VIDEO")
			{
				$link = yii::app()->createUrl('video/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name), "artist"=>Common::makeFriendlyUrl(trim($data->artist_name))));
				if ($data->id) {
					$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $data->id), 'avatar', array('class' => 'avatar'));
				} else {
					$avatarImage = CHtml::image('/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
				}
			}
			else
			{
				$artist_name = Common::makeFriendlyUrl($data->artist_name);
				$link = yii::app()->createUrl('song/view', array('id' => $data->id, 'url_key' => Common::makeFriendlyUrl($data->name),'artist'=>$artist_name));
				if ($data->id) {
					$avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(100, $data->artist_id), 'avatar', array('class' => 'avatar'));
				} else {
					$avatarImage = CHtml::image('/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
				}
			}
		?>
		<li>
			<a href="<?php echo $link ?>" class="i-list-bxh">
			<span class= "xbh-count index<?php echo ($i<4)? $i:"";?>"><?php echo $i;?></span>
				<span class="i-thumb-bxh album-thumb">
					<?php echo $avatarImage;?>
				</span>
                        <p class="subtext"><?php echo CHtml::encode($data->name);?></p>
                            <span class="i-artist subtext"><?php echo CHtml::encode($artist_name) ?></span>
				</a>
		</li>
		<?php endforeach;?>
	</ul>
	<div class="load-more-page"><img src="<?php echo Yii::app()->request->baseUrl?>/images/ajax_loading.gif" width="30px" /></div>
</div>
<?php else:?>
<div><?php echo Yii::t("wap","Updating");?></div>
<?php endif;?>