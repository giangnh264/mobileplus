<div id='body'>
	<div id="bigPic">
		<?php
		$j = 1;
		foreach ($this->contents as $content):
			$link = WebTopContentModel::model()->getTopContentLink($content);//NewsEventModel::model()->getEventLink($event);
			//$link =  $link. "?" . http_build_query(array('src'=>'HOME_SLIDESHOW'));
		?>
			<a href="<?php echo $link?>" title="<?php echo ucfirst(CHtml::encode($content['name'])) ?>" rel = "<?php echo http_build_query(array("a"=>CHtml::encode($content['artist_name']))); ?>" ><img alt="<?php echo ucfirst(CHtml::encode($content['name'])) ?>" title="<?php echo CHtml::encode($content['artist_name']); ?>" src="<?php echo TopContentModel::model()->getAvatarUrl($content['id'])?>" style="height: 296px; width: 690px;" /></a>
		<?php
			$j++;
			endforeach;
		?>
		<div id="panel-overlay">
			<div style="width: 490px;">
				<h2><a class="slideshow_title" href="#"></a></h2>
				<h3><a class="slideshow_artist" href='#'></a></h3>
			</div>
		</div>
		<div id="slide-overlay">
		</div>		
	</div>
	<ul id="thumbs" class="slide_thumbs">
	  <?php $i=1; foreach ($this->contents as $content):
		  $sufix = "";
		  if($i==1) $sufix = "class='active'";
		  ?>
		    <li <?php echo $sufix?> title='<?php echo $i ?>'><?php echo $i;?></li>
		  <?php $i++;
	  endforeach;
	  ?>
	</ul>
</div>