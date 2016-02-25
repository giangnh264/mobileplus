<?php
$this->breadcrumbs=array(
	'Services Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ServicesModelIndex')),	
);
$this->pageLabel = "Create Services";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>