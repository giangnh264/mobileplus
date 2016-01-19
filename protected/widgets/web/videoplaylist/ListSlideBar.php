<?php
class ListSlideBar extends CWidget
{
	public $List;
	public $type = "HOT";
        public $title ='Video Playlist';
        public $link = '';
	function run()
	{
		$this->render("slidebar");
	}
}
