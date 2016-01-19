<?php
class TestController extends TController
{
	public function actionDownload()
	{
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionSms()
	{
		
	}

	public function actionLink(){
		$this->layout = false;
		$this->render('link');
	}
	public function actionPlay(){
		$type = Yii::app()->request->getParam('type');
		if($type == 1){
			$link = 'rtsp://free.media.vt.nhac.vn/imuzik2013/media1/videos/h264_bb/0/0/11/45211.3gp';
		}else{
			$link = 'rtsp://media.vt.nhac.vn/imuzik2013/media1/videos/h264_bb/0/0/11/45211.3gp';
		}
		$this->render('play', compact('link'));
	}
	public function actionSl(){
		$userPhone = Yii::app()->user->getState('msisdn');
		echo "phone:" . $userPhone;
		echo "<br>";
		$is_3g = 0;
		if($this->is3g){
			$is_3g = 1;
		}
		echo "is_3g:" . $is_3g;
		exit;
	}
}