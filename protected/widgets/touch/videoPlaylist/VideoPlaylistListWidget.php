<?php
class VideoPlaylistListWidget extends CWidget
{	
	public $videoPlaylists = null;
	public $type = '';
	public $options = array();
	public function run()
	{
		$this->render('default', array('videoPlaylists'=>$this->videoPlaylists,
                                   		'options'=>  $this->options
		));
	}
}