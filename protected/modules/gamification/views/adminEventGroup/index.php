<?php
$this->breadcrumbs=array(
	'Admin Event Group Models',
);

$this->menu=array(
	array('label'=>'Create AdminEventGroupModel', 'url'=>array('create')),
	array('label'=>'Manage AdminEventGroupModel', 'url'=>array('admin')),
);
?>

<h1>Admin Event Group Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>