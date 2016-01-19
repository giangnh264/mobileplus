<?php
$submenu = include '_submenu.php';

return  array(


		
        CMap::mergeArray(
        array(
        "url"=>array("route"=>"/news"),
        "label"=>Yii::t('admin','CMS'),
        "visible"=>UserAccess::checkAccess("CMSMenuView", Yii::app()->user->Id),
        ),$submenu['cms']),




);
