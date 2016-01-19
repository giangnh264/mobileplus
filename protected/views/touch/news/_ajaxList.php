<?php foreach ($news as $new):
 	$link = Yii::app()->createUrl('news/detail', array('id' => $new->id, 'url_key' => Common::makeFriendlyUrl($new->title)));
?>
<li class="item">
	<a href="<?php echo $link;?>" title=" <?php echo CHtml::encode($new->title) ?>">
		<?php
                $avatarImage = CHtml::image(WapNewsModel::model()->getThumbnailUrl('s4', $new->id), 'avatar', array('class' => 'news-avatar', 'align' => 'left', 'title'=>CHtml::encode($new->title), 'width'=>'120', 'height'=>'80'));
                echo $avatarImage;
                ?>
		<h3><?php echo CHtml::encode(Formatter::smartCut($new->title,25));?></h3>
		<p><?php echo CHtml::encode(Formatter::smartCut($new->intro,45));?></p>
	</a>
</li>
<?php endforeach;?>
