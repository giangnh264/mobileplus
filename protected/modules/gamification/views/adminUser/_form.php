<div class="content-body">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-user-model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'user_phone'); ?>
        <?php echo $form->textField($model,'user_phone'); ?>
        <?php echo $form->error($model,'user_phone'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'point'); ?>
		<?php echo $form->textField($model,'point'); ?>
		<?php echo $form->error($model,'point'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
    </div>