<div class="padT35">
    <p style="text-align: justify">
        <?php echo $msg ?>
    </p>
    </br>
</div>
<div class="mar0_auto">

        <a class="new_login" href="<?php echo Yii::app()->createUrl('/site');?>">Bỏ Qua</a>
        
        <a class="new_login" href="<?php echo Yii::app()->createUrl('/account/login',array('back_url'=>$back_url));?>">Đăng nhập</a>
</div>