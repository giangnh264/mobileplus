<ul class="song_list items-list">
		<?php
		$i=0;
		foreach($this->songs as $song):
		if($this->type =='search'){
			$song['artist_name'] = $song['artist'];
		}
		$link = Yii::app()->createUrl('/song/msGift', array('id' => $song['id']));
		$i++;
		?>
	 	<li class="item">
	 		<a href="<?php echo $link;?>">
		 		<i class="vg_icon icon_song"></i>
		 		<h3><?php echo CHtml::encode($song['name'])?></h3>
		 		<ul class="info">
	            	<li><i class="vg_icon icon_artist"></i><?php echo Formatter::smartCut($song['artist_name'], Yii::app()->params['limit_substring'], 0);?></li>
	            </ul>
        	</a>
	    </li>
		<?php endforeach;?>
</ul>
