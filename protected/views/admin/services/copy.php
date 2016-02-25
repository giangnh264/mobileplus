<?php
$this->breadcrumbs=array(
	'Services Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ServicesModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ServicesModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ServicesModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Services")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>