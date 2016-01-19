<div class="m-carousel m-fluid m-carousel-photos">
  <div class="m-carousel-inner">			    
    <?php
    $i = 1;
    foreach ($slideVideos as $video) : 
    $link = Yii::app()->createUrl('video/view', array('id' => $video['object_id'], 'url_key' => Common::makeFriendlyUrl($video['name']), "artist"=>Common::makeFriendlyUrl(trim($video['artist_name']))));
    ?>
		<a href="<?php echo $link;?>">
		<div class="m-item <?php echo ($i == 1) ? 'm-active' : ''; ?> ">
	      	<img src="<?php echo AvatarHelper::getAvatar('newsEvent', $video['id'], 's1');?>" />
	    </div>
	    </a>
		<?php
		$i++; 
	endforeach;?>								  
  </div>
  <!-- the controls -->
  <div class="m-carousel-controls m-carousel-bulleted">
  	<?php if(count($slideVideos)>0):?>
  		<?php for ($i=1; $i<=count($slideVideos); $i++){?>
	   		<a href="#" data-slide="<?php echo $i;?>" <?php if($i==1){ echo 'class="m-active"';}?>><?php echo $i;?></a>
	   	<?php }?>
	<?php endif;?>
  </div>
</div>
