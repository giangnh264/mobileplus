<?php
$this->pageLabel = Yii::t("admin","Update User Event:");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('admin')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Chi tiết'), 'url'=>array('view', 'id'=>$model->_id)),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>