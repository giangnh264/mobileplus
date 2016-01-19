<div class="padT35">
    <p style="text-align: justify">
        <?php echo $msg ?>
    </p>
    </br>
</div>
<div class="mar0_auto">
        <a class="new_login" href="<?php echo Yii::app()->createUrl('/account/register');?>">Đăng ký</a>
        <a class="new_login" href="<?php echo Yii::app()->createUrl("/$type/view", array('id'=>$content_id, 'download'=>1, 'confirm'=>'success'));?>">Tải</a>
</div>