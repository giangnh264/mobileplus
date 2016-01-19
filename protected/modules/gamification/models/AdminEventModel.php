<?php
Yii::import('application.modules.gamification.models.EventModel');
class AdminEventModel extends EventModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}