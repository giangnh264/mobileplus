<?php
$this->breadcrumbs=array(
	'Admin User Models'=>array('index'),
	$model->_id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminUserModel', 'url'=>array('index')),
	array('label'=>'Create AdminUserModel', 'url'=>array('create')),
	array('label'=>'View AdminUserModel', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage AdminUserModel', 'url'=>array('admin')),
);
?>

<h1>Update AdminUserModel <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>