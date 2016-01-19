<?php
$this->pageLabel = Yii::t("admin","View User");

$this->menu=array(
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>Yii::t('admin','Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'user_id',
		'point',
		'created_time',
		'updated_time',
	),
)); ?>