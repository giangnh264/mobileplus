<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Product Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ProductModelCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách sản phẩm");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">'. Yii::t("admin","Chọn trang này").'('.$model->search()->getItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="all-item">'.  Yii::t("admin","Chọn tất cả").' ('.$model->count().')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">'.  Yii::t("admin","Bỏ chọn tất cả").'</a></li>
        </ul>
    </div>
';

if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','1'=>'Update'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';
echo $html_exp;

if(Yii::app()->user->hasFlash('Product')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Product').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   	=>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
		'id',
		'name',
		'description',
		'url_key',
		array(
			'class'=>'CLinkColumn',
			'header'=>'WP',
			'labelExpression'=>'($data->wp==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
			'urlExpression'=>'($data->wp==1)?Yii::app()->createUrl("product/unsetwp",array("cid[]"=>$data->id)):Yii::app()->createUrl("prodcut/setwp",array("cid[]"=>$data->id))',
			'linkHtmlOptions'=>array(
			),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>'IOS',
			'labelExpression'=>'($data->ios==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
			'urlExpression'=>'($data->ios==1)?Yii::app()->createUrl("product/unsetios",array("cid[]"=>$data->id)):Yii::app()->createUrl("prodcut/setios",array("cid[]"=>$data->id))',
			'linkHtmlOptions'=>array(
			),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>'Android',
			'labelExpression'=>'($data->android==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
			'urlExpression'=>'($data->android==1)?Yii::app()->createUrl("product/unsetandroid",array("cid[]"=>$data->id)):Yii::app()->createUrl("prodcut/setandroid",array("cid[]"=>$data->id))',
			'linkHtmlOptions'=>array(
			),
		),
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
				  'onchange'=>"$.fn.yiiGridView.update('product-model-grid',{ data:{pageSize: $(this).val() }})",
				)),
		),
	),
));
$this->endWidget();

?>
