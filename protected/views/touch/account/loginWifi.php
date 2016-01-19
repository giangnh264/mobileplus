<div class="vg_option">
	<a href="#" class="opt_genre"><span class="fll">Đăng nhập</span></a>
</div>
<style>
    .login-wifi label{
        width: 200px;
    }
    #login-wifi{
        padding: 20px;
    }
</style>
<div id="login-wifi">
	<div style="padding-bottom: 10px;">Cảm ơn Quý Khách đã sử dụng dịch vụ Chacha. Mời Quý Khách nhập số điện thoại để đăng nhập.</div>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <div class="row login-wifi" style="margin-bottom: 10px;">
            <div style="float: left; width: 85px; clear: both;"><?php echo $form->labelEx($model, 'phone'); ?></div>
            <?php echo $form->textField($model, 'phone'); ?>
            <div style="clear: both; margin-left: 100px;">
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
		<!-- 
        <div class="row login-wifi">
            <div style="float: left; width: 85px; clear: both; line-height: 40px;"><?php echo $form->labelEx($model, 'verifyCode'); ?></div>
            <?php //echo $form->textField($model, 'verifyCode', array('class' => 'text w50', 'size' => 4, 'style' => 'width:60px;margin-right:5px;float: left;margin-top: 10px;')); ?>
            <?php //$this->widget('CCaptcha', array('showRefreshButton' => false)); ?>
            <div style="clear: both; margin-left: 100px;">
            <?php //echo $form->error($model, 'verifyCode'); ?>
            </div>
        </div>
        -->
        <?php if ($return['error'] == 1): ?>
            <div class="error">
                <?php echo $return['msg']; ?>
            </div>
        <?php endif; ?>
        <div class="clb"></div>
        <div class="row submit">
            <?php echo CHtml::submitButton('Đăng nhập', array('class'=>'button bt-actived')); ?>
            <a href="/" class="button">Bỏ qua</a>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>