<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<!--<div class="row">
		<?php /*echo $form->label($model,'_id'); */?>
		<?php /*echo $form->textField($model,'_id'); */?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_id'); ?>
        <?php
        $eventGroup = AdminEventGroupModel::model()->findAll();
        $eventGroupData = array();
        foreach($eventGroup as $event){
            $eventGroupData["{$event->_id}"] = $event->name;
        }
        echo $form->dropDownList($model,'group_id',$eventGroupData, array('prompt'=>'--Tất cả--'));
        ?>
	</div>

	<!--<div class="row">
		<?php /*echo $form->label($model,'created_time'); */?>
		<?php /*echo $form->textField($model,'created_time'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model,'updated_time'); */?>
		<?php /*echo $form->textField($model,'updated_time'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model,'created_by'); */?>
		<?php /*echo $form->textField($model,'created_by'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model,'updated_by'); */?>
		<?php /*echo $form->textField($model,'updated_by'); */?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'reset'); ?>
        <?php
        $reset = array(
        '0'=>'No',
        '1'=>'Yes'
        );
        echo $form->dropDownList($model,'reset',$reset, array('prompt'=>'--All--'))
        ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
        <?php
        $method = array(
            '0'=>'deactive',
            '1'=>'active'
        );
        echo $form->dropDownList($model,'status',$method, array('prompt'=>'--All--'))
        ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->