<div class="content-body">
	<div class="form">

	<?php
    $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-news-event-model-form',
		'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data')

    )); ?>


		<p class="note">Fields with <span class="required">*</span> are required.</p>
        <div class="row">
            <div class="thumbnail"">
                <div class="row">
                    <label class="control-label">Ảnh</label>
                    <div style="height: 400px; position: relative;">
                        <img class="thumb-slider_new_event" id="thumb-change-slider" src="<?php echo ProductModel::model()->getCoverUrl($model->id)?>">
                        <label class="thumb-slider-change-text" for="clip_thumbnail_slider">Upload ảnh</label>
                        <input class="hidden" type="file" name="clip_thumbnail_slider" id="clip_thumbnail_slider" value="image" onchange="onFileSelected(event);"/>
                    </div>
                </div>
            </div>
        </div>
		<?php echo $form->errorSummary($model); ?>
        <?php
            $fileTmp = 0;
            if (isset($_POST['source_image_path'])) {
                $fileTmp = $_POST['source_image_path'];
            }
            echo CHtml::hiddenField("source_image_path", $fileTmp);
        ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php
				$data = array(
							'product'=>'product',
						);
				echo CHtml::dropDownList("AdminNewsEventModel[type]", $model->type, $data)
			?>
			<?php echo $form->error($model,'type'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'object_id'); ?>
			<?php echo $form->textField($model,'object_id'); ?>
			<?php echo $form->error($model,'object_id'); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'custom_link'); ?>
			<?php echo $form->textField($model,'custom_link',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'custom_link'); ?>
		</div>

        <div class="row" style="display: none;">
			<?php echo $form->labelEx($model,'channel'); ?>
			<?php
			$chanelList = (!$model->isNewRecord)?$model->channel:$_SESSION['channel'];
			$data = Yii::app()->params['eventChannel'];
            $arr_option = explode(',',$chanelList);
            echo '<select id="channels" name="channels[]" multiple="multiple">';
            foreach($data as $key=>$val){
                $selected = (in_array($val,$arr_option))? 'selected="selected"':'';
                echo '<option value="'.$val.'" '.$selected.'>'.$key.'</option>';
            }
            echo '</select>';
            echo $form->error($model,'channel'); ?>
		</div>
        <?php if(isset($_SESSION['channel']) && $_SESSION['channel'] != 'wap'):?>
        <div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textArea($model,'content',array('style'=>'width:360px;height:100px;','maxlength'=>500)); ?>
			<?php echo $form->error($model,'content'); ?>
        </div>
        <div class="row">
            <label for=""><b>Chú ý</b></label>
            <p style="line-height: 17px;">Trường Content(là thông tin mô tả về bài hát, video, album, playlist, news) không được để trống</p>
        </div>
        <?php endif;?>
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
            $('#thumb-change-slider').attr('src', event.target.result);
        };
        reader.readAsDataURL(selectedFile);
    }

</script>