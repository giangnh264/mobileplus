<ul class="news_list items-list">
 <?php 
 	$i=0;
 	foreach ($news as $new):
 	$i++;
 	$link = Yii::app()->createUrl('news/detail', array('id' => $new->id, 'url_key' => Common::makeFriendlyUrl($new->title)));
 ?>
	<li class="item <?php if($i==count($news)) echo 'last_item';?>">
		<a href="<?php echo $link;?>" title=" <?php echo CHtml::encode($new->title) ?>">
			<?php
                $avatarImage = CHtml::image(WapNewsModel::model()->getThumbnailUrl('s3', $new->id), 'avatar', array('class' => 'news-avatar', 'align' => 'left', 'title'=>CHtml::encode($new->title), 'width'=>'120', 'height'=>'80'));
                echo $avatarImage;
                ?>
                    <h3 class="subtext"><?php echo $new->title, 25;?></h3>
			<p><?php echo CHtml::encode(Formatter::smartCut($new->intro,30));?></p>
		</a>
	</li>
	<?php endforeach;?>
</ul>