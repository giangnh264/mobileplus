<?php

$this->menu=array(
	array('label'=>'Danh sách File', 'url'=>array('index')),
);
$this->pageLabel = "Danh sách file \"".$model->file_name."\"";
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'file_name',
		'file_path',
		array(
			'label'=>yii::t('admin','Gói cước'),
			'value'=> PackageModel::model()->findbyPk($model->package_id)->code,//($model->created_by && $model->user)?$model->user->username:yii::t('admin','Unknow'),
		),
		array(
			'label'=>yii::t('admin','Created By'),
			'value'=> AdminAdminUserModel::model()->findbyPk($model->created_by)->username,//($model->created_by && $model->user)?$model->user->username:yii::t('admin','Unknow'),
		 ),
             
		'created_time',
                'content_type',
	),
)); ?>
<div class="submenu  title-box">
	<div class="page-title">Danh sách thuê bao</div>
	<ul class="operations menu-toolbar">
		<?php if($content_type == 'subscribe'):?>
            <li><a href="#" id="update-content">Đăng ký</a></li>
		<?php else:?>
			<li><a href="#" id="update-content">Hủy đăng ký</a></li>
		<?php endif?>
            <li><a href="#" id="delete-content">Xóa</a></li>
            <!-- <li><a href="#" id="map-content">Map nội dung</a></li> -->
            <li><a href="#" id="export-xls-not-mapped" title="Export danh sách bài không map được">Export xls</a></li>
	</ul>
</div>
<div id="mapping-zone" style="height: 250px;overflow-y:auto; width: 90%;border: 1px solid #DDD; margin: 10px auto;display: none;">
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl("/setprice/default/set"),
		'method' => 'post',
		'htmlOptions' => array('class' => 'adminform','id'=>'cpr_form'),
));
echo CHtml::hiddenField("fileId",$model->id);
echo CHtml::hiddenField("page",isset($_GET["page"])?$_GET["page"]:1);


$this->widget('application.widgets.admin.grid.GGridView', array(
	'id'=>'copyright-song-file-model-grid',
	'treeData'=>$songs,
	'enablePagination' => false,
	'columns'=>array(

			array(
					'class' => 'CCheckBoxColumn',
					'selectableRows' => 2,
					'checkBoxHtmlOptions' => array('name' => 'cid[]','class'=>'clb'),
					'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
					'id' => 'cid',
					'checked' => 'false',
					'value'=>'$data["id"]'
			),

		array(
				'name' => 'Số điện thoại',
				'value' => '$data["msisdn"]',
				'type' => 'raw',
				'htmlOptions'=>array("style"=>"width:270px")
		),

		array(
				'name' => 'File Id',
				'value' => '$data["file_id"]',
				'type' => 'raw',
		),
		array(
				'name' => 'Trạng thái',
				'value' => '$data["status"]>=1?$data["status"]==1?"<span class=\"s_label s_{$data["status"]}\">Thành công</span>":"<span class=\"s_label s_{$data["status"]}\">Lỗi</span>":"<span class=\"s_label s_{$data["status"]}\">Chưa đăng ký</span>"',
				'type' => 'raw',
		),

		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItem",array("id"=>$data["id"],"fileId"=>$data["file_id"]))'
		),
	),
));
$this->endWidget();

echo '<div class="pager p10">';
$this->widget ( "CLinkPager", array (
		"pages" => $page,
		"maxButtonCount" => 10,
		"header" => "",
		"htmlOptions" => array ()
) );
echo '</div>';
?>

<script type="text/javascript">
//<!--
	$("#update-content").live("click",function(){

		/* if($("input.clb:checked").length==0){
			alert("Chưa chọn bản ghi nào")
			return false;
		} */
                    $("#cpr_form").attr("action","<?php echo Yii::app()->createUrl("/user/default/set")?>")
		$("#cpr_form").submit();
		return false;
	})
        
        $("#export-xls-not-mapped").live("click",function(){
            $("#cpr_form").attr("action","<?php echo Yii::app()->createUrl("/user/default/exportXlsNotMapped")?>")
            $("#cpr_form").submit();
            return false;
	})
//-->
</script>
