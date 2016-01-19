<div class="vg_option">
	<a href="#" class="opt_genre"><span class="fll"><?php echo Yii::t('wap','not found');?> <?php echo $error['code']?></span></a>
</div>
<div class="padB10">
<?php   echo yii::t('chachawap', 'Không tìm thấy thông tin bạn yêu cầu') ?>
</div>
<?php
if(YII_DEBUG){
    echo "<pre>";print_r(Yii::app()->errorHandler->error); echo "</pre>";
}
?>
