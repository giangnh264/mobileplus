<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'services-model-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype'=>'multipart/form-data')

	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
		<div class="thumbnail">
			<input type="hidden" id="thumb_hidden_id">
			<div class="row">
				<label class="control-label">?nh</label>
				<div style="position: relative; width: 360px; height: 210px;left: 125px;">
					<img class="thumb-slider-services" id="thumb-change" src="<?php echo ServicesModel::model()->getCoverUrl($model->id)?>">
					<label class="thumb-slider-change-text" for="clip_thumbnail">Upload ?nh</label>
					<input class="hidden" type="file" name="clip_thumbnail" id="clip_thumbnail" value="image" onchange="onFileSelected(event);"/>
				</div>
			</div>
		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,  'class' => 'txtchange')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255, 'class' => 'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	

	
		<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
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
	<script type="text/javascript">

		function onFileSelected(event){
			var selectedFile = event.target.files[0];
			var reader = new FileReader();
			reader.onload = function (event) {
				$('#thumb-change').attr('src', event.target.result);
			};
			reader.readAsDataURL(selectedFile);
		}
		</script>