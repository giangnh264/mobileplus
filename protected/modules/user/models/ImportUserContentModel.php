<?php

class ImportUserContentModel extends BaseImportUserContentModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImportUserContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCount($file_id){
		$sql = "SELECT count(*) AS total
                            FROM import_user_content
                            WHERE file_id=:FID
                            ";
		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $file_id, PDO::PARAM_INT);
		$data =  $dataCmd->queryRow();
		return empty($data)?0:$data["total"];
	}

	public function getList($file_id, $limit, $offset){
		$sql = "SELECT *
				FROM import_user_content
				WHERE file_id=:FID
				ORDER BY id ASC
				LIMIT :LIMIT
				OFFSET :OFFSET
				";
		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $file_id, PDO::PARAM_INT);
		$dataCmd->bindParam(":LIMIT", $limit, PDO::PARAM_INT);
		$dataCmd->bindParam(":OFFSET", $offset, PDO::PARAM_INT);
		return $dataCmd->queryAll();
	}
}