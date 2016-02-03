<?php

Yii::import('application.models.db.StatisticProductModel');

class AdminStatisticProductModel extends StatisticProductModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}