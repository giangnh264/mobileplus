<?php
class BaseEventModel extends EMongoDocument
{
    public $_id;
    public $name;
    public $description;
    public $group_id;
    public $group_name;
    public $point;
    public $created_time;
    public $updated_time;
    public $created_by;
    public $updated_by;
    public $reset;
    public $status;
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
        return 'event';
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name ,description,group_id,point,created_time,updated_time ,created_by ,updated_by ,reset ,status', 'safe'),
            array('name, reset, group_id, status', 'safe', 'on'=>'search'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'name'=>Yii::t('admin','Tên sự kiện'),
            'description'=>Yii::t('admin','Mô tả'),
            'group_id'=>Yii::t('admin','Nhóm sự kiện'),
            'point'=>Yii::t('admin','Điểm'),
            'status'=>Yii::t('admin','Trạng thái'),
        );
    }
}