<?php
Yii::import('application.modules.gamification.models._base.BaseEventGroupModel');
class EventGroupModel extends BaseEventGroupModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}