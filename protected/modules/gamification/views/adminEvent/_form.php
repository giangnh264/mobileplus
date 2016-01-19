<div class="content-body">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-event-model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
        <?php
        $eventGroup = AdminEventGroupModel::model()->findAll();
        $eventGroupData = array();
        foreach($eventGroup as $event){
            $eventGroupData["{$event->_id}"] = $event->name;
        }
        echo $form->dropDownList($model,'group_id',$eventGroupData, array('prompt'=>'--Select Event--'));
        ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'point'); ?>
		<?php echo $form->textField($model,'point'); ?>
		<?php echo $form->error($model,'point'); ?>
	</div>

	<!--<div class="row">
		<?php /*echo $form->labelEx($model,'created_time'); */?>
		<?php /*echo $form->textField($model,'created_time'); */?>
		<?php /*echo $form->error($model,'created_time'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->labelEx($model,'updated_time'); */?>
		<?php /*echo $form->textField($model,'updated_time'); */?>
		<?php /*echo $form->error($model,'updated_time'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->labelEx($model,'created_by'); */?>
		<?php /*echo $form->textField($model,'created_by'); */?>
		<?php /*echo $form->error($model,'created_by'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->labelEx($model,'updated_by'); */?>
		<?php /*echo $form->textField($model,'updated_by'); */?>
		<?php /*echo $form->error($model,'updated_by'); */?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'reset'); ?>
        <?php echo $form->checkbox($model,'reset');?>
        <span class="tips">Xóa toàn bộ điểm của khách hàng hay ko</span>
		<?php echo $form->error($model,'reset'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->checkbox($model,'status');?>
        <span class="tips">Sự kiện này còn hiệu lực ko</span>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>