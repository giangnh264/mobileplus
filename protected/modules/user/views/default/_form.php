<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */
/* @var $form CActiveForm */
?>

<div class="content-body">
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'copyright-song-file-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <?php if($content_type == 'subscribe'):?>
        <div class="row-border">
            <div class="row_new">
                <p>Gói cước</p>
                <input type="radio" name="package_id" value="1" <?php echo ($model->package_id=='1')?'checked':'';?>>Gói cước ngày (A1)<br>
                <input type="radio" name="package_id" value="2" <?php echo ($model->package_id=='2')?'checked':'';?>>Gói cước tuần (A7)<br>
            </div>
        </div>
        <?php endif;?>
        <div class="row">
            <input type="file" name="file" id="file" />
        </div>
		Template Import mẫu <a href="media/file_mau.xls">download</a>
        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Upload' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>