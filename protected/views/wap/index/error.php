<div class="padL10 padT10 padB10 smallText">
    <?php
    echo yii::t('chachawap', 'Không tìm thấy thông tin bạn yêu cầu') ?>
</div>
<?php
if(YII_DEBUG){
    echo "<pre>";print_r(Yii::app()->errorHandler->error); echo "</pre>";
}
?>
