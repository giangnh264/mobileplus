<?php
class RbtController extends TController
{
	public function actionGetinfo($id)
	{
		
		header("Content-type: application/json");
		$rbt = WapRbtModel::model()->findByPk($id);
		$rbt = json_decode(CJSON::encode($rbt));
		$rbt->mp3Url = IStreamingHelper::getRbtUrl($rbt->id);
		echo json_encode($rbt);
		Yii::app()->end();
	}
}