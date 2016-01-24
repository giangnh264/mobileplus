<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'product-model-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype'=>'multipart/form-data')
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
			<?php $id = 1?>
			<div class="thumbnail">
				<input type="hidden" value="<?php echo $id?>" id="thumb_hidden_id">
				<div class="row">
					<label class="control-label">Ảnh</label>
					<div style="height: 200px; position: relative;">
						<img class="thumb-slider" id="thumb-change-<?php echo $id?>" src="">
						<label class="thumb-slider-change-text" for="clip-thumbnail">Upload ảnh</label>
						<input class="hidden" type="file" name="clip_thumbnail_<?php echo $id?>" id="clip-thumbnail" value="image" onchange="onFileSelected(event, <?php echo $id?>);"/>
					</div>
				</div>
			</div>
			<div class="row">
				<input type="hidden" value="<?php echo $id?>" id="id_load_more" name="number">
			</div>
			<a onclick="addmore();">Upload thêm ảnh</a>
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'class' => 'txtchange')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255,'class' => 'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'wp'); ?>
			<?php
			$data = array(
				1=>Yii::t('admin','Đang hỗ trợ'),
				0=>Yii::t('admin','Không hỗ trợ'),
			);
			echo CHtml::dropDownList("ProductModel[wp]", $model->android, $data ) ?>
			<?php echo $form->error($model,'wp'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'ios'); ?>
			<?php
			$data = array(
				1=>Yii::t('admin','Đang hỗ trợ'),
				0=>Yii::t('admin','Không hỗ trợ'),
			);
			echo CHtml::dropDownList("ProductModel[ios]", $model->android, $data ) ?>
			<?php echo $form->error($model,'ios'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'android'); ?>
			<?php
			$data = array(
				1=>Yii::t('admin','Đang hỗ trợ'),
				0=>Yii::t('admin','Không hỗ trợ'),
			);
			echo CHtml::dropDownList("ProductModel[android]", $model->android, $data ) ?>
			<?php echo $form->error($model,'android'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php
			$data = array(
				1=>Yii::t('admin','Đang kích hoạt'),
				0=>Yii::t('admin','Không kích hoạt'),
			);
			echo CHtml::dropDownList("ProductModel[status]", $model->status, $data ) ?>
			<?php echo $form->error($model,'status'); ?>
			<div class="row">
				<input type="hidden" value="1"/>
			</div>
		</div>
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
<script type="text/javascript">

	function onFileSelected(event){
		var id = parseInt($('#thumb_hidden_id').val());
		var selectedFile = event.target.files[0];
		var reader = new FileReader();
		reader.onload = function (event) {
			$('#thumb-change-' + id).attr('src', event.target.result);
		};
		reader.readAsDataURL(selectedFile);
	}
	function addmore(){
		var id = parseInt($('#id_load_more').val());
		var url = '/admin.php?r=product/Loadmore';
		$.ajax({
			type: 'post',
			url: url,
			data: {'id':id},
			success: function (data) {
				var div = $(data);
				div.insertAfter($('.thumbnail div:last'));
				$('#id_load_more').val(id + 1)
				$('#thumb_hidden_id').val(id + 1)
			}
		});
	}

</script>