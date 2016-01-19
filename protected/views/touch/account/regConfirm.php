<div id="login-wifi">
	<div class="create_account"><?php echo Yii::t("wap","Đăng ký gói cước");?></div>
	<p><?php echo $msg;?></p>
	<?php if(!empty($error_msg)):?>
		<p class="error_msg"><?php echo $error_msg?></p>
	<?php endif;?>
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