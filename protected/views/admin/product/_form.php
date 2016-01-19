<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'product-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'wp'); ?>
			<?php echo $form->textField($model,'wp'); ?>
			<?php echo $form->error($model,'wp'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ios'); ?>
			<?php echo $form->textField($model,'ios'); ?>
			<?php echo $form->error($model,'ios'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'android'); ?>
			<?php echo $form->textField($model,'android'); ?>
			<?php echo $form->error($model,'android'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'updated_time'); ?>
			<?php echo $form->textField($model,'updated_time'); ?>
			<?php echo $form->error($model,'updated_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>