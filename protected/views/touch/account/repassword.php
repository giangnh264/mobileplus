<div id="login-wifi">
	<div class="create_account"><?php echo Yii::t("wap","Lấy lại mật khẩu");?></div>
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
			<input type="text" id="LoginForm_phone" name="phone"
				   placeholder="Số điện thoại"/>
		</div>
		<div class="clb"></div>
		<div class="row submit">
			<?php echo CHtml::link(Yii::t("wap", "Done"), "#", array("submit" => '#',  'class' => 'button-dark btn-submit width100')); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>