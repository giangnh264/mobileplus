<?php
class SongSlideBar extends CWidget
{
	public $songList;
	public $type="HOT";
	public function run()
	{
		$this->render("slidebar");
	}
}