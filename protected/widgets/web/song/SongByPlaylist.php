<?php
class SongByPlaylist extends CWidget
{
	public $songs;
	public $type = null;
	public $playlist_id = null;
	public function run()
	{
		$this->render("listByPlaylist");
	}
}
