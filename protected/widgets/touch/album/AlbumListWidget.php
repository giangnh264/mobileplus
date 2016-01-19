<?php
class AlbumListWidget extends CWidget
{
	
	public $albums = null;
	public $type = '';
        public $options = array();
        public function run()
	{
		$this->render('default', array(
				'albums'=>$this->albums,
                                'options'=>  $this->options
		));
	}
}