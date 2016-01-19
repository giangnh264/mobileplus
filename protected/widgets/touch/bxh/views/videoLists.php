<div class="box-content clear">
	<ul class="video_list">
		<?php
		$i=0;
		foreach($this->videos as $video):
		$link = Yii::app()->createUrl('video/view', array('id' => $video['id'], 'url_key' => Common::makeFriendlyUrl($video['name']),"artist"=>Common::makeFriendlyUrl(trim($video['artist_name']))));
		$i++;
		$name = explode("-", $video['name']);
		?>
		<li class="item <?php if($i==count($this->videos)) echo 'last_item';?>">
	 		<div class="vg_number vg_number<?php echo $i;?> fll"><?php echo $i;?></div>
		 	<?php
		 	$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video['id']), 'avatar', array('class' => 'video-avatar-bxh','align'=>'left'));
		 	?>
	    	<a href="<?php echo $link;?>">
	    		<?php echo $avatarImage;?>
                    <h3 class="subtext"><?php echo CHtml::encode($video['name']);?></h3>
                        <ul class="info subtext"><li><?php echo CHtml::encode($video['artist_name']);?></li></ul>
	        </a>
	    </li>
		<?php endforeach;?>
	</ul>
</div>
