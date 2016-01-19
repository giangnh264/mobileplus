<?php
class VideoList extends CWidget
{
	public $videos;
	public $type = '';
        public $options = array();
	public function run()
	{
		$this->render("videoLists",array('options' => $this->options));
	}
}
