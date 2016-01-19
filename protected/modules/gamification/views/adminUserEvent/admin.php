<?php
$this->pageLabel = Yii::t("admin","Manage Admin User Event");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('admin')),
    array('label'=>Yii::t('admin','Tìm kiếm'), 'url'=>'#','linkOptions'=>array('class'=>'search-button')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-user-event-model-grid', {
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
	'id'=>'admin-user-event-model-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'user_id',
            'header'=>UserEventModel::model()->getAttributeLabel("user_id"),
        ),
        array(
            'name'=>'user_phone',
            'header'=>UserEventModel::model()->getAttributeLabel("user_phone"),
        ),
        array(
            'name'=>'event_id',
            'header'=>UserEventModel::model()->getAttributeLabel("event_id"),
            'value'=>'AdminEventModel::model()->findByPk(new MongoId($data->event_id))->name'
        ),
        array(
            'name'=>'content_id',
            'header'=>UserEventModel::model()->getAttributeLabel("content_id"),
        ),
        array(
            'name'=>'content_name',
            'header'=>UserEventModel::model()->getAttributeLabel("content_name"),
        ),
        array(
            'name'=>'point',
            'header'=>UserEventModel::model()->getAttributeLabel("point"),
        ),
        array(
            'name'=>'method',
            'header'=>UserEventModel::model()->getAttributeLabel("method"),
        ),
		'created_time',
		//'updated_time',
        //'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>