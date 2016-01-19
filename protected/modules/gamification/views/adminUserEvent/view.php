<?php
$this->pageLabel = Yii::t("admin","Chi tiết");

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'user_id',
		'user_phone',
		'event_id',
		'event_name',
		'group_id',
		'group_name',
		'content_id',
		'content_name',
		'transaction',
		'transaction_id',
		'point',
		'created_time',
		'updated_time',
		'method',
	),
)); ?>