<?php
class SongList extends CWidget
{
	public $songs = array();
	public $viewMore=false;
	public $type=false;
        public $options = array();
	public function run(){
		$phone = yii::app()->user->getState('msisdn');
		$this->render('songList',array(
				'phone'=>$phone,
                                'options' => $this->options
		));

	}

}
