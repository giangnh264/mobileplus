<?php
$this->breadcrumbs=array(
	'Contact Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ContactModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ContactModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ContactModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Contact")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>