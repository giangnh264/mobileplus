<?php
class AlbumSlideBar extends CWidget
{
	public $albumList;
	public $type = "HOT";
	public $title ='Album';
	public $link = '';
	function run()
	{
		$this->render("album_slidebar");
	}
}
