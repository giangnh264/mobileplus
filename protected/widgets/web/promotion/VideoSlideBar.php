<?php
class VideoSlideBar extends CWidget
{
    public $videoList;
    public $type = "HOT";
    public $district = "";
    public $title = 'Video';
    public $link = '';
    public function init()
    {
        parent::init();
    }
	function run()
	{
		$this->render("video_slidebar");
	}
}
