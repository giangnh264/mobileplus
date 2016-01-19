<?php
$this->pageLabel = Yii::t("admin","Chi tiết: ".$model->name);

$this->menu=array(
    array('label'=>'Thêm mới sự kiện', 'url'=>array('create')),
    array('label'=>'Sửa', 'url'=>array('update', 'id'=>$model->_id)),
    array('label'=>'Xóa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Danh sách', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'name',
		'description',
	),
)); ?>