<?php
Yii::import('application.modules.gamification.models._base.GBaseUserModel');
//Yii::import('application.models.db._base.BaseUserModel');
class GUserModel extends GBaseUserModel
{
    public $point;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /*public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->user_id = (int) $this->user_id;
            $this->point = (int) $this->point;
            return true;
        }
        else return false;
    }*/
}