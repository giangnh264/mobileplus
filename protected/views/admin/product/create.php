<?php
$this->breadcrumbs=array(
	'Product Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ProductModelIndex')),	
);
$this->pageLabel = "Create Product";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>