<?php
$this->pageLabel = Yii::t("admin","Thêm mới nhóm sự kiện");
$this->menu=array(
    array('label'=>'Danh sách', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>