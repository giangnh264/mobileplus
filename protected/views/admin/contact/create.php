<?php
$this->breadcrumbs=array(
	'Contact Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ContactModelIndex')),	
);
$this->pageLabel = "Create Contact";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>