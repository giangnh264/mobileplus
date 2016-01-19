<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */

$this->breadcrumbs=array(
	'Copyright Song File Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index')),
);
 if($content_type == 'subscribe'){
	 $this->pageLabel = "Đăng ký theo danh sách";
 } else{
	 $this->pageLabel = "Hủy theo danh sách";
 }
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,  'content_type'=>$content_type)); ?>