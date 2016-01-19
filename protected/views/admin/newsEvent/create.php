<?php
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index','channel'=>isset($_SESSION['channel'])?$_SESSION['channel']:'wap'), 'visible'=>UserAccess::checkAccess('NewsEventIndex')),
);
$this->pageLabel = "Create NewsEvent";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>