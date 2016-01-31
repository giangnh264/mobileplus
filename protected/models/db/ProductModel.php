<?php

class ProductModel extends BaseProductModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCoverPath($id=null, $i)
	{
		if(!isset($id)) $id = $this->id;
		$savePath = Common::storageSolutionEncode($id).DS.$id."_". $i.".jpg";
		$path = Yii::app()->params['storage']['ProductDir'].DS.$savePath;
		return $path;
	}

	public function getCoverUrl($id=null, $i)
	{
		if(!isset($id)) $id = $this->id;
		$src = Common::storageSolutionEncode($id) . $id."_". $i . ".jpg";
		return Yii::app()->params['storage']["ProductUrl"] . $src;
	}

	public function getProductByChannel($channel, $limit = 12, $offset = 0){
		if(strtoupper($channel) == 'WEB'){
			$other_channel = 'app';
		}
		$criteria = new CDbCriteria;
		$criteria->condition = 'channel <> :channel AND  status = 1';
		$criteria->params = array(':channel'=>$other_channel);
		$criteria->order = "id DESC";
		$criteria->limit = $limit;
		$criteria->offset = $offset;
		$results = self::model()->findAll($criteria);
		return $results;
	}

	public function countProductByChannel($channel){
		if(strtoupper($channel) == 'WEB'){
			$other_channel = 'app';
		}
		$criteria = new CDbCriteria;
		$criteria->condition = 'channel <> :channel AND  status = 1';
		$criteria->params = array(':channel'=>$other_channel);
		$results = self::model()->count($criteria);
		return $results;
	}



}