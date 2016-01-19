<div id="login-wifi">
    <div class="create_account"><?php echo Yii::t("wap","Register member");?></div>
    <p><?php echo $msg;?></p>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="row input_s1 input_pass">
            <input type="text" id="LoginForm_password" name="otp"
                   placeholder="<?php echo Yii::t("wap","Nhập mã xác thực");?>">
        </div>
        <div class="clb"></div>
        <div class="row submit">
            <?php echo CHtml::link(Yii::t("wap", "Done"), "#", array("submit" => '#',  'class' => 'button-dark btn-submit width100')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>