<div class="header_box mart0">
	<h1 class="title"><?php echo $pageTitle; ?></h1>
</div>
<div class="content_box">	
	<?php foreach($news as $item):
	$link = Yii::app()->createUrl("news/view",array("id"=>$item->id,"title"=>Common::makeFriendlyUrl($item->title)))
	?>
	<div class="clb padb30">
		<div class="list_news_thumb">
			<a href="<?php echo $link ?>">
				<img src="<?php echo AvatarHelper::getAvatar("news", $item->id,"150")?>" alt="<?php echo CHtml::encode($item->title) ?>" />
			</a>
		</div>
		<div class="list_news_info" style="<?php echo ($option=='box')? 'width: 510px;':'';?>">
			<h3>
				<a href="<?php echo $link ?>" class="news_title"><?php echo CHtml::encode($item->title) ?></a>
			</h3>
			<p class="news_date fs11"><?php echo date("d/m/Y H:i", strtotime($item->created_time)); ?></p>
			<p class="news_desc"><?php echo $item->intro?></p>
		</div>
		<div class="clb"></div>
	</div>
	<?php endforeach; ?>

</div>