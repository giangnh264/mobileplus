<?php

Yii::import('application.models.db.ProductImgModel');

class AdminProductImgModel extends ProductImgModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}