<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */

$this->breadcrumbs=array(
	'Set Price Models'=>array('index'),
	'Manage',
);
$this->menu=array(
	array('label'=>'Thêm mới', 'url'=>array('create')),
);
$this->pageLabel = "Quản lý File đầu vào";
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'copyright-input-file-model-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'file_name',
		array(
			'header' => 'Tập danh sách',
			'value' => '($data->content_type=="subscribe")?"Đăng ký":"Hủy đăng ký"',
			'type' => 'raw'
		),
		array(
			'header' => 'Người tạo',
			'value' => 'AdminAdminUserModel::model()->findByPk($data->created_by)->username',
			'type' => 'raw'
		),
		'created_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
