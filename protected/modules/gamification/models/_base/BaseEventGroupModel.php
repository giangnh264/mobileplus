<?php
class BaseEventGroupModel extends EMongoDocument
{
    public $_id;
    public $name;
    public $description;
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
        return 'event_group';
    }
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name ,description', 'safe'),
        );
    }
    public function attributeLabels()
    {
        return array(
            'name'=>Yii::t('admin','Tên nhóm sự kiện'),
            'description'=>Yii::t('admin','Mô tả'),
        );
    }
}