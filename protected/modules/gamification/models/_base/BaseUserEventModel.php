<?php
class BaseUserEventModel extends EMongoDocument
{
    public $_id;
    public $user_id;
    public $user_phone;
    public $event_id;
    public $event_name;
    public $group_id;
    public $group_name;
    public $content_id;
    public $content_name;
    public $transaction_id;
    public $transaction_name;
    public $transaction;
    public $point;
    public $created_time;
    public $updated_time;
    public $method;

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
        return 'user_event';
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,user_phone,event_id', 'required'),
            array('user_id,user_phone ,event_id,event_name,group_id,group_name,content_id,content_name,transaction,transaction_name,transaction_id,point ,created_time ,updated_time ,method', 'safe'),
            array('user_id,user_phone ,event_id,event_name,group_id,group_name,content_id,transaction,transaction_id,transaction_name,point ,created_time ,updated_time ,method', 'safe','on'=>'search'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'user_id'=>Yii::t('admin','User Id'),
            'user_phone'=>Yii::t('admin','User Phone'),
            'event_id'=>Yii::t('admin','Sự kiện'),
            'group_id'=>Yii::t('admin','Nhóm sự kiện'),
            'point'=>Yii::t('admin','Điểm'),
            'method'=>Yii::t('admin','Nguồn'),
            'content_id'=>Yii::t('admin','Content Id'),
            'content_name'=>Yii::t('admin','Content Name'),
        );
    }


}