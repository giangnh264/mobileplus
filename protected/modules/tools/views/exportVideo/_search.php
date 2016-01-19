<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl" style="width: 50%;">
	    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php 
        	$name = isset($_GET['AdminVideoModel']['name'])?$_GET['AdminVideoModel']['name']:"";
        	echo CHtml::textField('AdminVideoModel[name]', $name);
        ?>
	    </div>
		<div class="row">
			<label>Nhạc sỹ</label>
	    	<select name="is_composer" id="is_composer">
	    		<option value=""  <?php if($is_composer=='') echo 'selected';?>>Tất cả</option>
	    		<option value="1" <?php if($is_composer=='1') echo 'selected';?>>Có</option>
	    		<option value="2" <?php if($is_composer=='2') echo 'selected';?>>Không</option>
	    	</select>
		</div>
		<div class="row">
			<?php echo $form->label($model,'max_bitrate'); ?>
			<?php
			 	$bitrate = array('720'=>'720');
			 	$max_bitrate = isset($_GET['AdminVideoModel']['max_bitrate'])?$_GET['AdminVideoModel']['max_bitrate']:"";
			 	echo CHtml::dropDownList('AdminVideoModel[max_bitrate]', $max_bitrate, $bitrate, array('prompt'=>'Tất cả'));
			?>
		</div>

	    <div class="row">
	        <?php echo $form->label($model,'artist_name'); ?>
	        <?php
	        	$artist_name = isset($_GET['AdminVideoModel']['artist_name'])?$_GET['AdminVideoModel']['artist_name']:"";
	        	echo CHtml::textField('AdminVideoModel[artist_name]', $artist_name);
	        ?>
	    </div>

    </div>
    <div class="fl" style="width: 50%;">
	    <div class="row">
	        <?php echo $form->label($model,'cp_id'); ?>
	        <?php
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
				$cp_id = isset($_GET['AdminVideoModel']['cp_id'])?$_GET['AdminVideoModel']['cp_id']:"";
                echo CHtml::dropDownList("AdminVideoModel[cp_id]", $cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id'); ?>
	        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
				$genre_id = isset($_GET['AdminVideoModel']['genre_id'])?$_GET['AdminVideoModel']['genre_id']:"";
                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $genre_id, $category )
            ?>
	    </div>

		<div class="row">
            <?php echo $form->label($model,'created_time'); ?>
            <div class="fl">
            <?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'AdminVideoModel[created_time]',
		       		'value'=>isset($_GET['AdminVideoModel']['created_time'])?$_GET['AdminVideoModel']['created_time']:'',
		        ));
		     ?>
		     </div>
        </div>

		<div class="row">
			<label>Lyric</label>
			<select name="is_lyric" id="is_lyric">
				<option value=""  <?php if($is_lyric=='') echo 'selected';?>>Tất cả</option>
				<option value="1" <?php if($is_lyric=='1') echo 'selected';?>>Có</option>
				<option value="2" <?php if($is_lyric=='2') echo 'selected';?>>Không</option>
			</select>
		</div>

    </div>
	<div class="clb"></div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->