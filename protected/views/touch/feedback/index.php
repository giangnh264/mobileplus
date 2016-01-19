<div class="vg_option">Gửi góp ý của bạn</div>
<div class="padB10">
<?php if (Yii::app()->user->hasState('msg')): ?>
    <p style="padding: 10px;background: #47A578;color: #FFF;">Vinaphone trân trọng cảm ơn quý khách đã góp ý cho dịch vụ. Chúng tôi sẽ liên tục cải tiến, nâng cao chất lượng để dịch vụ đáp ứng tốt hơn nhu cầu của quý khách!</p>
    <?php Yii::app()->user->setState('msg',null);?>
<?php else: ?>
    <div class="form" style="padding: 0px 10px;">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'feedback-model-form',
            'enableAjaxValidation' => false,
        	'clientOptions'=>array(
       					'validateOnSubmit'=>true,
    				),
        ));
        ?>
       
        <div class="row">
            <?php echo $form->labelEx($model, 'Số điện thoại'); ?>
            <br/>
            <?php echo $form->textField($model, 'title', array('maxlength' => 100, 'autocomplete' => 'off')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Loại'); ?>
            <br/>
            <?php echo $form->dropDownList($model, 'type', array('0' => 'Góp ý', '1' => 'Báo lỗi', '2' => 'Yêu cầu chức năng')); ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Nội dung'); ?>
            <br/>
            <?php echo $form->textArea($model, 'content', array('cols' => 30, 'rows' => 8, 'style' => 'height:100px;')); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>

        <?php echo CHtml::submitButton('Gửi góp ý', array('class'=>'button bt-actived')); ?>
        <?php $this->endWidget(); ?>
    </div>
<?php endif; ?>
<style>
.error{
	color: #E21536;
	border: 1px solid #E21536;
}
.errorMessage{
	color: #E21536;
	font-size: 12px;    
}
</style>
</div>