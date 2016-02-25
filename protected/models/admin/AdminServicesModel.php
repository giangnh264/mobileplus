<?php

Yii::import('application.models.db.ServicesModel');

class AdminServicesModel extends ServicesModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}