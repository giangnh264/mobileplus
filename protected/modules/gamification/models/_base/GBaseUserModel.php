<?php
class GBaseUserModel extends EMongoDocument
{
    public $_id;
    public $user_id;
    public $user_phone;
    public $point;
    public $created_time;
    public $updated_time;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function primaryKey()
    {
        return '_id';
    }
    public function getCollectionName()
    {
        return 'user';
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,user_phone', 'required'),
            array('user_id, user_phone, point, created_time, updated_time', 'safe'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'user_id'=>Yii::t('admin','User'),
            'point'=>Yii::t('admin','Point'),
            'user_phone'=>Yii::t('admin','Số điện thoại'),
        );
    }
}