<?php

return array(


    'cms' => array(

        array(
            "url" => array("route" => "/newsEvent/index"),
            "label" => Yii::t('admin', 'Slider Show'),
            "visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
        ),
    ),
);

