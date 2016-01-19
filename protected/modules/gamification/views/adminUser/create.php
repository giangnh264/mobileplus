<?php
$this->pageLabel = Yii::t("admin","Create User");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>