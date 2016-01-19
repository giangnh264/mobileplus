<?php
class VideoSlideBarByGenre extends CWidget
{
	public $genreIds;
	public $type = 'hot';
    public $title = 'video';
    public $showHotNew = true;
    public $videos;
    public $topLink = '#';
    public $district = '';
    public $playlistId = 0;
        
    function run()
	{
        if(!isset($this->videos)){
            if ($this->type == 'hot'){
                $videos = MainContentModel::getListByCollectionByDistrict('VIDEO_HOT', $this->district, 1, 8);
            } else {
                $videos = MainContentModel::getListByCollectionByDistrict('VIDEO_NEW', $this->district, 1, 8);
            }
        }else
            $videos = $this->videos;
        $this->render("slidebarByGenre", array('videoList'=>$videos));
	}
}
