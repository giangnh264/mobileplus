<?php

class ServicesModel extends BaseServicesModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Services the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCoverPath($id=null)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).DS.$id.".jpg";
		$path = Yii::app()->params['storage']['ServicesDir'].DS.$savePath;
		return $path;
	}

	public function getCoverUrl($id=null)
	{
		if(!isset($id)) $id = $this->id;
		$src = Common::storageSolutionEncode($id) . $id . ".jpg";
		return Yii::app()->params['storage']["ServicesUrl"] . $src;
	}

	public function getByHome(){
		$cr = new CdbCriteria();
		$cr->condition = 'status = 1';
		$cr->limit = 3;
		$cr->order = 'sorder ASC, id desc';
		return self::model()->findAll($cr);
	}
}