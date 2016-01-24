<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="language" content="<?php echo Yii::app()->language?>" />
    <meta name="robots" content="follow, index" />
    <link rel="canonical" href="<?php echo Yii::app()->request->getHostInfo().Yii::app()->request->url;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if IE]>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style-ie.css" type="text/css" rel="stylesheet">
    <![endif]-->
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->request->getHostInfo(). '/img/fav.png';?>">
    <?php //echo $this->headMeta;?>
    <?php Yii::app()->SEO->renderMeta();?>
    <title><?php echo Yii::t('web',$this->htmlTitle);?></title>

<?php

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/bootstrap.css?v=".time());
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/style.css?v=".time());
$cs->registerCssFile(Yii::app()->request->baseUrl.'/web/css/responsive.css?v='.time());
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/main.css?v=".time());
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/jquery-ui.min.css?v=".time());


$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');

$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_slidebar.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/common.js");

?>
</head>