<?php
$this->breadcrumbs=array(
	'Admin Event Models',
);

$this->menu=array(
	array('label'=>'Create AdminEventModel', 'url'=>array('create')),
	array('label'=>'Manage AdminEventModel', 'url'=>array('admin')),
);
?>

<h1>Admin Event Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>