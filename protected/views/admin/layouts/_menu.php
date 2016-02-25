<?php
$submenu = include '_submenu.php';

return  array(
            array(
                "url" => array("route" => "/newsEvent/index"),
                "label" => Yii::t('admin', 'Slider Show'),
                "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
            ),
            array(
                "url" => array("route" => "/product/index"),
                "label" => Yii::t('admin', 'Sản phẩm'),
                "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
            ),
        array(
            "url" => array("route" => "/Html"),
            "label" => Yii::t('admin', 'Giới thiệu'),
            "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
        ),
    array(
        "url" => array("route" => "/Contact"),
        "label" => Yii::t('admin', 'Liên hệ'),
        "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
    ),
    array(
        "url" => array("route" => "/Services"),
        "label" => Yii::t('admin', 'Dịch vụ'),
        "visible" => UserAccess::checkAccess("ServicesIndex", Yii::app()->user->Id)
    )
);
