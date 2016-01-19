<?php
$this->pageLabel = Yii::t("admin","Quản lý Sự Kiện");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('admin')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Tìm kiếm'), 'url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-event-model-grid', {
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
	'id'=>'admin-event-model-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'name',
            'header'=>EventModel::model()->getAttributeLabel("name"),
            'value'=>'CHtml::link($data->name,array("update","id"=>$data->_id))',
            'type'=>'raw'
        ),
        array(
            'name'=>'description',
            'header'=>EventModel::model()->getAttributeLabel("description"),
        ),
        array(
            'name'=>'group_id',
            'header'=>EventModel::model()->getAttributeLabel("group_id"),
            'value'=>'AdminEventGroupModel::model()->findByPk(new MongoId($data->group_id))->name',
            'type'=>'raw'
        ),
        array(
            'name'=>'point',
            'header'=>EventModel::model()->getAttributeLabel("point"),
        ),
		//'created_time',
		/*
		'updated_time',
		'created_by',
		'updated_by',
		'reset',
		'status',
		*/
        'reset',
        array(
            'name'=>'status',
            'header'=>EventModel::model()->getAttributeLabel("status"),
            'value'=>'($data->status==1)?"<span class=\"s_label s_1\">Actived</span>":"<span class=\"s_label s_2\">Not Active</span>"',
            'type'=>'raw'
        ),
        //'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>