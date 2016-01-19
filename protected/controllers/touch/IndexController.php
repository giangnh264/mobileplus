<?php
class IndexController extends  CController
{
	public $device;
	public $deviceOs;
	public $userPhone;
	
	public function actionError()
	{
		$this->device = DeviceManager::getInstance();
		$this->layout = 'application.views.touch.layouts.error';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', compact('error'));
		}
	}
}
