<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property string $des_link
 * @property string $description
 * @property string $url_key
 * @property string $channel
 * @property integer $wp
 * @property integer $ios
 * @property integer $android
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 * @property integer $view_count
 * @property integer $sorder
 */
class BaseProductModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, url_key', 'required'),
			array('wp, ios, android, status, view_count, sorder', 'numerical', 'integerOnly'=>true),
			array('name, url_key', 'length', 'max'=>255),
			array('channel', 'length', 'max'=>20),
			array('des_link, created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, des_link, description, url_key, channel, wp, ios, android, created_time, updated_time, status, view_count, sorder', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return Common::loadMessages("db");
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('des_link',$this->des_link,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('wp',$this->wp);
		$criteria->compare('ios',$this->ios);
		$criteria->compare('android',$this->android);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('view_count',$this->view_count);
		$criteria->compare('sorder',$this->sorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}