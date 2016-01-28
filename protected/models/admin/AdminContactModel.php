<?php

Yii::import('application.models.db.ContactModel');

class AdminContactModel extends ContactModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}