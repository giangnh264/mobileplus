<?php

class ProductImgModel extends BaseProductImgModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductImg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getImgByProductId($product_id){
		$cr = new CdbCriteria();
		$cr->condition = 'product_id = :PRODUCT';
		$cr->params = array(':PRODUCT'=>$product_id);
		$data = self::model()->findAll($cr);
		$res = array();
		foreach ($data as $item){
			$res[]= $item->img_id;
		}
		return $res;
	}
	public function getOneImgByProductId($product_id){
		$cr = new CdbCriteria();
		$cr->condition = 'product_id = :PRODUCT';
		$cr->params = array(':PRODUCT'=>$product_id);
		$cr->limit = 1;
		$data = self::model()->findAll($cr);
		return $data;
	}

	public function getSliderByProductId($product_id){
		$cr = new CdbCriteria();
		$cr->condition = 'product_id = :PRODUCT';
		$cr->params = array(':PRODUCT'=>$product_id);
		$data = self::model()->findAll($cr);
		$res = array();
		foreach ($data as $item){
			$res[]= $item->img_url;
		}
		return $res;
	}

}