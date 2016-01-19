<ul class="song_list items-list">
		<?php
		$i=0;
		foreach($this->songs as $song):
		if($this->type =='search'){
			$song['artist_name'] = $song['artist'];
		}
		$artist_name = Common::makeFriendlyUrl($song->artist_name);
		$link = Yii::app()->createUrl('song/view', array('id' => $song['id'], 'url_key' => Common::makeFriendlyUrl($song['name']),'artist'=>$artist_name));
		$i++;
		?>
	 	<li class="item <?php if($i==count($this->songs) && $this->type==false) echo 'last_item';?>">
	 		<a href="<?php echo $link;?>">
		 		<i class="vg_icon icon_song"></i>
		 		<h3 class="subtext"><?php echo CHtml::encode($song['name'])?></h3>
		 		<ul class="info">
	            	<li class="subtext"><?php echo CHtml::encode($song['artist_name']);?></li>
	            </ul>
        	</a>
	    </li>
		<?php endforeach;?>
</ul>
