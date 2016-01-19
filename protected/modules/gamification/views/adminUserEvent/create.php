<?php
$this->pageLabel = Yii::t("admin","Create User Event");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>