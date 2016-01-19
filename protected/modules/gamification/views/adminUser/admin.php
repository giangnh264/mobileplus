<?php
$this->pageLabel = Yii::t("admin","Manage Admin User");
$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
    array('label'=>Yii::t('admin','Tìm kiếm'), 'url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-user-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-user-model-grid',
	'dataProvider'=>new EMongoDocumentDataProvider($model->search(), array(
		'sort'=>array(
			'attributes'=>array(
				'_id',
				'user_id',
				'point',
				'created_time',
				'updated_time',
			),
		),
	)),
	'filter'=>$model,
	'columns'=>array(
		'_id',
		'user_id',
		'point',
		'created_time',
		'updated_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>