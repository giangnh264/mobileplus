<?php
class RbtList extends CWidget
{
	public $rbts = array();
	public $viewMore=false;
	public $type=false;
	public function run(){
		$phone = Yii::app()->user->getState('msisdn');
		$this->render('rbtList',array(
				'phone'=>$phone
		));

	}

}
