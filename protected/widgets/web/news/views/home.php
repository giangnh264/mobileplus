<?php
$headLine = $news[0];
$linkHead = Yii::app()->createUrl("news/view",array("id"=>$headLine->id,"title"=>Common::makeFriendlyUrl($headLine->title)));
?>

	<div class="box_title">
		<h2 class="name"><a href="<?php echo Yii::app()->createUrl("/news");?>"><?php echo Yii::t('web', 'News') ?></a></h2>
	</div>
	<div class="box_content">
		<div class="news_left">
			<a class="new_top_link" href="<?php echo $linkHead ?>" title="<?php echo CHtml::encode($headLine->title) ?>">
				<img class="news_top" src="<?php echo AvatarHelper::getAvatar("news", $headLine->id,"s0")?>" alt="<?php echo CHtml::encode($headLine->title) ?>" /></a>
			<h3 class="news_tt">
				<a href="<?php echo $linkHead ?>" class="news_title" title="<?php echo CHtml::encode($headLine->title) ?>"><?php echo Formatter::substring(CHtml::encode($headLine->title), " ", 30, 120)?></a>
			</h3>
			<p class="news_desc"><?php echo Formatter::substring(CHtml::encode($headLine->intro), " ", 52, 210);?></p>
		</div>
		<div class="news_right">
			<ul class="list_news">
			<?php
			$i=0;
			foreach($news as $item):
			$i++;
			if($i==1) continue;
			$link = Yii::app()->createUrl("news/view",array("id"=>$item->id,"title"=>Common::makeFriendlyUrl($item->title)))
			?>
				<li>
					<a class="thumb-img" href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("news", $item->id,"150")?>" alt="news"/></a>
					<p><strong>
						<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->title)?>"><?php echo Formatter::substring($item->title, " ", 21, 65)?></a>
						</strong></p>
					<p><?php echo Formatter::formatDayOfWeek($item->created_time); ?></p></li>
			<?php  endforeach;?>
			</ul>
		</div>
	</div>


