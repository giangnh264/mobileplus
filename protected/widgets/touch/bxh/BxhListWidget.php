<?php
class BxhListWidget extends CWidget
{
	
	public $datas = null;
	public $type= null;
	public function run()
	{
		$this->render('list', array(
				'datas'=>$this->datas,
				'type'=>$this->type,
		));
	}
}