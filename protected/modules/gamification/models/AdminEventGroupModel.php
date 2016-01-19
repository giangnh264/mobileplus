<?php
Yii::import('application.modules.gamification.models.EventGroupModel');
class AdminEventGroupModel extends EventGroupModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}