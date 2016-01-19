<div class="padT35">
    <p style="text-align: justify; color: red; font-weight:bold;">
        <?php echo $msg ?>
    </p>
    </br>
</div>
<div class="mar0_auto">
        <a class="new_login" href="<?php echo Yii::app()->createUrl("account/UnregisterPackage", array('id'=>$id));?>">Hủy</a>
                <a class="new_login" href="<?php echo Yii::app()->createUrl('site/index');?>">Bỏ qua</a>

</div>