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

	public function getProductByChannel($channel, $limit = 12, $offset = 0, $order){

		$criteria = new CDbCriteria;
		$criteria->condition = 'channel <> :channel AND  status = 1';
		$criteria->params = array(':channel'=>$channel);
		$criteria->limit = $limit;
		$criteria->offset = $offset;
		$criteria->order = "id DESC";
		if($order == 0){
			$criteria->order = "id DESC";
		}

		$results = self::model()->findAll($criteria);
		return $results;
	}

	public function countProductByChannel($channel){
		$criteria = new CDbCriteria;
		$criteria->condition = 'channel <> :channel AND  status = 1';
		$criteria->params = array(':channel'=>$channel);
		$results = self::model()->count($criteria);
		return $results;
	}

	public function searchProduct($channel, $keyword,$order, $limit = 12, $offset = 0){
		if(strtolower($channel) == 'web'){
			$other_channel = 'app';
		}else{
			$other_channel = 'web';
		}
		$criteria = new CDbCriteria();
		$criteria->condition = 'channel <> :channel';
		$criteria->params = array(':channel'=>$other_channel);
		$criteria->addSearchCondition('name', $keyword);
		$criteria->limit = $limit;
		$criteria->offset = $offset;
		$criteria->order = 'id desc';
		$product = ProductModel::model()->findAll($criteria);
		return $product;

	}

	public function countsearchProduct($channel, $keyword){
		if(strtolower($channel) == 'web'){
			$other_channel = 'app';
		}
		$criteria = new CDbCriteria();
		$criteria->condition = 'channel = :channel';
		$criteria->params = array(':channel'=>$other_channel);
		$criteria->addSearchCondition('name', $keyword);
		$count = ProductModel::model()->count($criteria);
		return $count;

	}
	public function getProductRelate($product_id, $channel,  $limit){
		if(strtolower($channel) == 'web'){
			$other_channel = 'app';
		}
		$criteria = new CDbCriteria();
		$criteria->condition = 'channel = :channel and id <> :id';
		$criteria->params = array(':channel'=>$other_channel, 'id'=>$product_id);
		$criteria->limit = $limit;
		$product = ProductModel::model()->findAll($criteria);
		return $product;
	}



}