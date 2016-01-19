<?php
$this->breadcrumbs=array(
	'Product Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ProductModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ProductModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ProductModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Product")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>