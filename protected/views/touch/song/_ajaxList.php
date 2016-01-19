<?php
if($songs):
	foreach($songs as $song):
		$artist_name = Common::makeFriendlyUrl($song->artist_name);
		$link = Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
		?>
<li class="item">
    <a href="<?php echo $link;?>">
 		<i class="vg_icon icon_song"></i>
 		<h3 class="subtext"><?php echo CHtml::encode($song->name);?></h3>
	 		<ul class="info">
            	<li class="subtext">
            	<?php
                	echo $song->artist_name;
             	?>
            	</li>
            </ul>
	</a>
</li>
		
<?php endforeach;?>
<?php else:?>
<li class="pad-10"><?php echo Yii::t("wap","Song not found");?></li>
<?php endif;?>