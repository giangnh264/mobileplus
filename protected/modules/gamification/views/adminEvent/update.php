<?php
$this->pageLabel = Yii::t("admin","Cập nhật sự kiện");

$this->menu=array(
	array('label'=>'Thêm mới', 'url'=>array('create')),
	array('label'=>'Chi tiết', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Danh sách', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>