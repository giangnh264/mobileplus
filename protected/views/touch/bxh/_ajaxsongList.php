<?php
	$i = $limit * $pager->getCurrentPage();
	foreach($topWeek as $song):
		$i++;
		$artist_name = Common::makeFriendlyUrl($song->artist_name);
		$link = Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
		?>
	    <li class="item">
	 		<div class="vg_number vg_number<?php echo $i;?> fll"><?php echo $i;?></div>
	    	<a href="<?php echo $link;?>">
	 			<i class="vg_icon icon_song"></i>
                                <h3 class="subtext"><?php echo CHtml::encode($song->name)?></h3>
	 			<ul class="info subtext"><li><?php echo CHtml::encode($song->artist_name)?></li></ul>
	        </a>
	    </li>
<?php endforeach;?>