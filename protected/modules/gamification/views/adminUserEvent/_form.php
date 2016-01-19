<div class="content-body">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-user-event-model-form',
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
		<?php echo $form->labelEx($model,'event_id'); ?>
		<?php echo $form->textField($model,'event_id'); ?>
		<?php echo $form->error($model,'event_id'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'event_name'); ?>
        <?php echo $form->textField($model,'event_name'); ?>
        <?php echo $form->error($model,'event_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'group_id'); ?>
        <?php echo $form->textField($model,'group_id'); ?>
        <?php echo $form->error($model,'group_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'group_name'); ?>
        <?php echo $form->textField($model,'group_name'); ?>
        <?php echo $form->error($model,'group_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'content_id'); ?>
        <?php echo $form->textField($model,'content_id'); ?>
        <?php echo $form->error($model,'content_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'content_name'); ?>
        <?php echo $form->textField($model,'content_name'); ?>
        <?php echo $form->error($model,'content_name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'transaction'); ?>
        <?php echo $form->textField($model,'transaction'); ?>
        <?php echo $form->error($model,'transaction'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'point'); ?>
		<?php echo $form->textField($model,'point'); ?>
		<?php echo $form->error($model,'point'); ?>
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
		<?php echo $form->labelEx($model,'method'); ?>
		<?php echo $form->textField($model,'method'); ?>
		<?php echo $form->error($model,'method'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
    </div>