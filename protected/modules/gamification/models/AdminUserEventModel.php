<?php
Yii::import('application.modules.gamification.models.UserEventModel');
class AdminUserEventModel extends UserEventModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}