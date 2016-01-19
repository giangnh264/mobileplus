<?php if(!empty($albums)): ?>
<div class="box-content clear">
	<ul class="album_list">
		<?php
		$i=0;
		foreach ($albums as $key => $album):
		//$artist_name = WapArtistModel::model()->findByPk($album->artist_id)->name;
			$i++;
			$albumLink = yii::app()->createUrl('album/view', array('id' => $album->id, 'url_key' => Common::makeFriendlyUrl($album->name)));
                        if(isset($options['col'])&&$options['col']){
                            $albumLink = yii::app()->createUrl('album/view', array('id' => $album->id, 'url_key' => Common::makeFriendlyUrl($album->name), 'src'=>$options['col']));
                        }
			if ($album->id) {
				$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl('s4', $album->id), 'avatar', array('class' => 'avatar', 'width'=>'85px','height'=>'85px'));
			} else {
				$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
			}
		?>
		<li class="item <?php if($i==count($albums)) echo 'last_item';?>">
	 		<div class="vg_number vg_number<?php echo $i;?> fll"><?php echo $i;?></div>
			<a href="<?php echo $albumLink;?>">
	 		<?php echo $avatarImage;?>
                            <h3 class="subtext"><?php echo CHtml::encode($album->name);?></h3>
                            <ul class="info subtext">
                                <li class="subtext"><?php echo CHtml::encode($album->artist_name); ?></li>
                            </ul>
                        </a>
	    </li>
		<?php endforeach;?>
	</ul>
</div>
<?php else:?>
<div><?php echo Yii::t("wap","Updating");?></div>
<?php endif;?>