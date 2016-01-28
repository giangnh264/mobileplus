<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'content'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'project_type'); ?>
			<?php echo $form->textField($model,'project_type',array('size'=>6,'maxlength'=>6)); ?>
			<?php echo $form->error($model,'project_type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'project_name'); ?>
			<?php echo $form->textField($model,'project_name',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'project_name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'project_pirce'); ?>
			<?php echo $form->textField($model,'project_pirce',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'project_pirce'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'project_time'); ?>
			<?php echo $form->textField($model,'project_time',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'project_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'project_des'); ?>
			<?php echo $form->textArea($model,'project_des',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'project_des'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>