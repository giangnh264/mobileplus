<div id="login-wifi">
<div class="create_account"><?php echo Yii::t("wap","Register member");?></div>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableAjaxValidation' => false,
                ));
        ?>
        <div class="row input_s1 input_phone">
            <?php echo $form->textField($model, 'phone',array("placeholder"=>Yii::t("wap","Phone number"))); ?>
        </div>
         <div style="clear: both; text-align: center;">
                <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="row input_s1 input_pass">
            <?php echo $form->passwordField($model, 'password',array("placeholder"=>Yii::t("wap","Password"))); ?>
            
        </div>
        <div style="clear: both; text-align: center;">
                <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="row input_s1 input_pass">
            <?php echo $form->passwordField($model, 'repassword',array("placeholder"=>Yii::t("wap","Retype password"))); ?>
            
        </div>
         <div style="clear: both; text-align: center;">
                <?php echo $form->error($model, 'repassword'); ?>
        </div>
        <div class="clb"></div>
        <div class="row submit">
            <?php echo CHtml::link(Yii::t("wap", "Tạo tài khoản"), "#", array("submit" => '#',  'class' => 'button-dark btn-submit width100')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>