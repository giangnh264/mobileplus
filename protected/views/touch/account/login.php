<div class='box-info'>
	<?php if(Yii::app()->request->getParam('wrr')):?>
	<p class="c_red center"><?php echo Yii::t("wap","Quý khách vui lòng đăng nhập và đăng ký dịch vụ để tải miễn phí nội dung.");?></p>
	<?php else:?>
    <p class='create_account'><?php echo Yii::t("wap","Login");?></p>
    <?php endif;?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
    		'id' => 'login-form',
            'action'=>Yii::app()->createUrl('/account/login'),
    		'enableAjaxValidation' => false,
    ));
    ?>
        <?php echo $form->textField($model, 'phone',array("placeholder"=>Yii::t("wap","Phone number"), "class"=>"getpass")); ?>
        <div style="clear: both; text-align: center;">
                <?php echo $form->error($model, 'phone'); ?>
        </div>
        <?php echo $form->passwordField($model, 'password',array("placeholder"=>Yii::t("wap","Password"), "class"=>"otp")); ?>
        <div style="clear: both; text-align: center;">
                <?php echo $form->error($model, 'password'); ?>
        </div>
        <br />
        <div class="row submit">
            <?php echo CHtml::link(Yii::t("wap", "Login"), "#", array("submit" => '#',  'class' => 'button-dark btn-submit width100')); ?>
        </div>
    <?php $this->endWidget(); ?>
    <p class="login-opt">
        <a class="txtPurple" href="<?php echo Yii::app()->createUrl('account/create');?>">Tạo tài khoản</a>
        |
        <a class="txtPurple" href="<?php echo Yii::app()->createUrl('account/repassword');?>"">Quên mật khẩu?</a>
    </p>
    <div class="ot-action pad_20" style="text-align: center;">
        <span><?php echo Yii::t("wap","Vui lòng soạn MK gửi 9166 (0đ) để nhận lại mật khẩu, hệ thống sẽ gửi mật khẩu cho Quý khách qua SMS.");?></span>
    </div>
</div><!-- End .box-info-->
