<div id="login-wifi">
	<div class="create_account"><?php echo Yii::t("wap","Nhập OTP");?></div>
	<div class="form">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'login-form',
			'enableAjaxValidation' => false,
		));
		?>
		<?php if($error != ""):?>
			<div style="clear: both; text-align: center;">
				<div class="errorMessage"><?php echo $error;?></div>
			</div>
		<?php endif?>
		<div class="row input_s1 input_pass">
			<input type="text" id="LoginForm_password" name="otp"
				   placeholder="<?php echo Yii::t("wap","Enter OTP");?>">
		</div>
		<div class="clb"></div>
		<div class="row submit">
			<?php echo CHtml::link(Yii::t("wap", "Done"), "#", array("submit" => '#',  'class' => 'button-dark btn-submit width100')); ?>
			<input type="hidden" value="<?php echo $action?>" name="action" />
		</div>
		<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>