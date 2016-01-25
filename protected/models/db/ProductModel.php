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

}