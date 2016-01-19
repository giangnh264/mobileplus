<?php
Yii::import('application.modules.gamification.models.GUserModel');
class AdminGUserModel extends GUserModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function getUserInfo()
    {
        $user_phone = $this->user_phone;
        $c = array(
            'conditions'=>array(
                'user_phone'=>array('==' => $user_phone),
            ),
        );
        return self::model()->find($c);
    }
}