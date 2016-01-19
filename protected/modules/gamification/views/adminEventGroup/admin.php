<?php
$this->pageLabel = Yii::t("admin","Quản lý nhóm sự kiện");
$this->menu=array(
    array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('gamification-AdminEventGroupCreate')),
    //array('label'=>Yii::t('admin','Tìm kiếm'), 'url'=>'#','linkOptions'=>array('class'=>'search-button')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-event-group-model-grid', {
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
	'id'=>'admin-event-group-model-grid',
	'dataProvider'=>new EMongoDocumentDataProvider($model->search(), array(
		'sort'=>array(
			'attributes'=>array(
				'_id',
                'name',
                'description',
			),
		),
	)),
	//'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'name',
            'header'=>EventGroupModel::model()->getAttributeLabel("name"),
            'value'=>'CHtml::link($data->name,array("update","id"=>$data->_id))',
            'type'=>'raw'
        ),
        array(
            'name'=>'description',
            'header'=>EventGroupModel::model()->getAttributeLabel("description"),
        ),
        //'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>