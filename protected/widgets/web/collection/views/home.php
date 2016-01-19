<h2><?php echo Yii::t('web','Topic'); ?></h2>
<ul>
<?php foreach($collection as $collection):
$link = Yii::app()->createUrl("collection/view",array("id"=>$collection->id,"title"=>Common::makeFriendlyUrl(CHtml::encode($collection->name))));
?>
	<li><h3>
			<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($collection->name) ?>">
			<?php echo Formatter::smartCut(CHtml::encode($collection->name),30)  ?> <i class="icon icon_mt"></i></a>
		</h3></li>
<?php endforeach;?>
</ul>