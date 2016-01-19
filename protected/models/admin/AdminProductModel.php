<?php

Yii::import('application.models.db.ProductModel');

class AdminProductModel extends ProductModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}