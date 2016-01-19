<?php if ($news): ?>
<div class="box_title">
	<h2 class="name"><?php echo Yii::t("web", "Related news"); ?></h2>
</div>
<div class="content_box">
	<ul class="list_song">
		<?php foreach($news as $item):
		$link = Yii::app()->createUrl("news/view",array("id"=>$item->id,"title"=>Common::makeFriendlyUrl($item->title)))
		?>
		<li class='news_list_item'>
			<h3><a href="<?php echo $link; ?>" class="name"><?php echo CHtml::encode($item->title)?></a></h3>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
