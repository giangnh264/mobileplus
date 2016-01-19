<?php if ($videos) :?>
<div class="header_box marb0">
	<h2 class="title">Video liên quan</h2>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo Yii::app()->createUrl("artist/view",array("id"=>$videos[0]->video_artist[0]->artist_id))?>" class="fs11">Xem thêm <i class="icon icon_mt"></i></a>
</div>
<div class="content_box">
	<ul class="list_bxh ovh">
	<?php foreach ($videos as $video):
	$link = Yii::app()->createUrl("video/detail",array("id"=>$video->id,"title"=>trim($video->url_key,"-")))
	?>
		<li><span class="fll"><h3>
					<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($video->name)?>">
					<?php echo Formatter::smartCut(CHtml::encode($video->name),22)?></a>
				</h3></span> <h4 class="flr gray_color"><?php echo Formatter::smartCut($video->video_artist[0]->artist_name,12)?></h4></li>
	<?php endforeach;?>
	</ul>
</div>
<?php endif; ?>