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
        if($this->district!=''){
            if ($this->type == 'HOT'){
                $this->videoList = MainContentModel::getListByCollectionByDistrict('VIDEO_HOT', $this->district, 1, 16);
            } else {
                $this->videoList = MainContentModel::getListByCollectionByDistrict('VIDEO_NEW', $this->district, 1, 16);
            }
        }
		$this->render("slidebar");
	}
}
