<div class="bxh-song box-content clear">
	<ul class="song_list">
		<?php
		$i=0;
		foreach($this->songs as $song):
		if($this->type =='search'){
			$song['artist_name'] = $song['artist'];
		}
		$artist_name = Common::makeFriendlyUrl($song['artist_name']);
		$link = Yii::app()->createUrl('song/view', array('id' => $song['id'], 'url_key' => Common::makeFriendlyUrl($song['name']),'artist'=>$artist_name));
		$i++;
		?>

	 	<li class="item <?php if($i==count($this->songs)) echo 'last_item';?>">
	 		<div class="vg_number vg_number<?php echo $i;?> fll"><?php echo $i;?></div>
	 		<a href="<?php echo $link;?>">
                        <h3 class="subtext"><?php echo CHtml::encode($song['name']);?></h3>
	 		<ul class="info subtext"><li><?php echo CHtml::encode($song['artist_name']);?></li></ul>
	        </a>
	    </li>
		<?php endforeach;?>
	</ul>
</div>
