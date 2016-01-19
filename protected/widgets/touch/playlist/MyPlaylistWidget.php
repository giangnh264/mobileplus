<?php
class MyPlaylistWidget extends CWidget
{
	public $playlist = null;
	public function run()
	{
		$this->render('MyPlaylist', array(
				'playlists'=>$this->playlist
		));
	}
}