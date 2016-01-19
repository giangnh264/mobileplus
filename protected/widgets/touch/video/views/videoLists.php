<div class="ct_list_box">
	<ul class="video_list items-list">
		<?php
		$i=0;
		foreach($this->videos as $video):
			if((!isset($this->options['excludeId'])) || (isset($this->options['excludeId']) && $this->options['excludeId'] != $video['id'] )) :
				$link = Yii::app()->createUrl('video/view', array('id' => $video['id'], 'url_key' => Common::makeFriendlyUrl($video['name']),"artist"=>Common::makeFriendlyUrl(trim($video['artist_name']))));
		                if(isset($this->type) && ($this->type == 'VIDEO_COLLECTION')){
		                	$link = Yii::app()->createUrl('video/view', array('id' => $video['id'], 'url_key' => Common::makeFriendlyUrl($video['name']), "artist"=>Common::makeFriendlyUrl(trim($video['artist_name']))));
		                }   
		                if(isset($this->type) && ($this->type == 'VIDEO_PLAYLIST')){
		                	
		                	$playlistId = (isset($this->options) && isset($this->options['playlist'])) ? $this->options['playlist'] : 0;
		                	$link = Yii::app()->createUrl('video/view', array('id' => $video['id'], 'url_key' => Common::makeFriendlyUrl($video['name']), "artist"=>Common::makeFriendlyUrl(trim($video['artist_name'])), 'playlist'=>$playlistId));
		                }
				$i++;
				$name = explode("-", $video['name']);
				?>
		
			 	<li class="item <?php if($i==count($this->videos)) echo 'last_item';?>">
			 	<?php
			 	$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video['id']), 'avatar', array('class' => 'video-avatar','align'=>'left'));
			 	?>
			 		<a href="<?php echo $link;?>">
				 		<?php echo $avatarImage;?>
				 		<h3 class="subtext"><?php echo CHtml::encode($video['name'])?></h3>
				        <ul class="info subtext"><li><?php echo CHtml::encode($video['artist_name']);?></li></ul>
		        	</a>
			    </li>
		<?php 
		endif;
		endforeach;
		?>
	</ul>
</div>
