<?php
$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
    'id' => "dialog",
    'options' => array (
        'title' => Yii::t ( 'web', 'Kích hoạt dự án của bạn' ),
        'autoOpen' => true,
        'modal' => 'true',
        'width' => '580px',
        'dialogClass'=> 'dialog-login-top',
        //'height' => 'auto',
        'height' => '520px',
        'resizable'=>false,
        'buttons' => array (),
        'position' => array(
            'my'=>"top",
            'at'=>'top+30%',
        )
    )
) );

$cs = Yii::app ()->getClientScript ();
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/web/css/popup.css" );
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/rangeslider.css?v=".time());
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/rangeslider.min.js");


$form = $this->beginWidget ( 'CActiveForm', array (
    'action' => "",
    'method' => 'post',
    'htmlOptions' => array (
        'class' => 'popupform'
    )
) );
?>
<div class="account-box box-white">
    <div class="form">
        <div id="popup-loading" ></div>
        <div id="login-message" style="color: #FF0000"></div>

        <div class="row">
            <?php echo CHtml::label(Yii::t('web','Loại dự án'),"")?>
            <?php echo CHtml::dropdownlist('project_type', '<selected value>', array('mobile'=>'Mobile', 'web'=>'Web'),  array( 'class'=>'selectbox'));?>

        </div>

        <div class="row">
            <?php echo CHtml::label(Yii::t('web','Tên dự án'),"")?>
            <?php echo CHtml::textField("project_name","",array("class"=>"input-text"),  array( 'class'=>'selectbox'))?>
        </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('web','Thời gian làm việc'),"")?>
            <input id="price" type="range" min="1" max="12" value="1"   style="float: left; width: 275px; padding-left: 18px; padding-top: 16px;" name="project_time"/>
            <p id="result" style="float: left; padding-left: 16px; padding-top: 5px;">1 tháng</p>
        </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('web','Khoảng giá'),"")?>
            <?php echo CHtml::dropdownlist('project_price', '<selected value>',
                array(
                    '1.000.000 - 5.000.000'     =>'1.000.000  - 5.000.000',
                    '5.000.000 - 10.000.000'    =>'5.000.000  - 10.000.000',
                    '10.000.000 - 15.000.000'   =>'10.000.000 - 15.000.000',
                    '15.000.000 - 20.000.000'   =>'15.000.000 - 20.000.000',
                    '25.000.000 - 30.000.000'   =>'25.000.000 - 30.000.000',
                    '35.000.000 - 40.000.000'   =>'35.000.000 - 40.000.000',
                    '45.000.000 - 50.000.000'   =>'45.000.000 - 50.000.000',
                    'Trên 50.000.000'           =>'Trên 50.000.000',

                ),
                array( 'class'=>'selectbox'));?>

        </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('web','Mô tả dự án'),"")?>
            <?php echo CHtml::textarea('project_des','',array("style"=>"float: right; height: 150px; width: 50%; margin-right: 15%; font-weight: normal ! important; font-size: 16px;",'placeholder'=>'Nhập những thông tin mô tả của dự án tại đây')); ?>

        </div>
        <div class="clb"></div>
        <div class="row submit">
            <?php
            echo CHtml::ajaxSubmitButton(Yii::t('web','Bắt đầu'),CHtml::normalizeUrl(array('contact/project','render'=>false)),
                array(
                    'success'=>'js: function(data) {
                        $("#dialog").dialog("close");
					}'
                ),
                array('id'=>'close-dialog','live' =>false,'class'=>'button-sub'));

            ?>
        </div>
    </div>
    <!-- form -->
</div>

<?php
$this->endWidget ();

$this->endWidget ( 'zii.widgets.jui.CJuiDialog' );

?>
<?php
Yii::app()->clientScript->registerScript('search', '

var p = document.getElementById("price"),
    res = document.getElementById("result");

p.addEventListener("input", function() {
    res.innerHTML = p.value + " tháng";
}, false);
');
?>
