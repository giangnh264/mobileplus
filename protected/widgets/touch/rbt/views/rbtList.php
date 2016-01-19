<ul class="song_list items-list">
		<?php
		foreach($this->rbts as $rbt):
		if($this->type =='search'){
			$rbt['artist_name'] = $rbt['artist'];
		}
		$link = Yii::app()->createUrl('/ajax/getPopupRbt', array('rbt_id'=>$rbt['id']));
		?>
	 	<li class="item">
	 		<a href="<?php echo $link;?>" class="ajax_popup">
		 		<i class="vg_icon icon_song"></i>
		 		<h3><?php echo CHtml::encode($rbt['name'])?></h3>
		 		<ul class="info">
	            	<li><i class="vg_icon icon_artist"></i><?php echo CHtml::encode($rbt['artist_name'])?></li>
	            </ul>
        	</a>
	    </li>
		<?php endforeach;?>
</ul>
