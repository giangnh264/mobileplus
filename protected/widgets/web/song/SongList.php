<?php
class SongList extends CWidget
{
	public $songs;
	public $type = null;
	public function run()
	{
		$this->render("list");
	}
}
