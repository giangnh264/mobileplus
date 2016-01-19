<?php
class SongGift extends CWidget
{
	public $songs = array();
	public $viewMore=false;
	public $type=false;
        public $options=array();
        public function run(){
		$phone = yii::app()->user->getState('msisdn');
		$this->render('songGift',array(
				'phone'=>$phone,
                                'options' => $this->options
		));

	}

}
