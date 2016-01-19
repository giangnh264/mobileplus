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
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>
    <div class="row">
        <?php echo $form->label($model,'user_phone'); ?>
        <?php echo $form->textField($model,'user_phone'); ?>
    </div>
	<div class="row">
		<?php echo $form->label($model,'event_id'); ?>
        <?php
        $c = array(
            'conditions'=>array(
                'status'=>array('=='=>EventModel::_ACTIVE)
            )
        );
        $eventGroup = AdminEventModel::model()->findAll($c);
        $eventGroupData = array();
        foreach($eventGroup as $event){
            $eventGroupData["{$event->_id}"] = $event->name;
        }
        echo $form->dropDownList($model,'event_id',$eventGroupData, array('prompt'=>'--Tất cả--'));
        ?>
		<?php //echo $form->textField($model,'event_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'point'); ?>
		<?php echo $form->textField($model,'point'); ?>
	</div>

	<!--<div class="row">
		<?php /*echo $form->label($model,'created_time'); */?>
		<?php /*echo $form->textField($model,'created_time'); */?>
	</div>

	<div class="row">
		<?php /*echo $form->label($model,'updated_time'); */?>
		<?php /*echo $form->textField($model,'updated_time'); */?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'method'); ?>
        <?php
            $method = array(
                'wap'=>'wap',
                'web'=>'web',
                'api-android'=>'api-android',
                'api-ios'=>'api-ios',
                'vinaphone'=>'vinaphone'
            );
        echo $form->dropDownList($model,'method',$method, array('prompt'=>'--Tất cả--'))
        ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->