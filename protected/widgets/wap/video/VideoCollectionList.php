<?php
/**
 * class VideoList
 *
 * @author : longtv
 */
class VideoCollectionList extends CWidget
{
    public $videos;
    public $excludeId;
    public $src;
    public $playlist;
    public function init()
    {
    }

    public function run()
    {
        $this->render('VideoCollectionListWidget', array('videos' => $this->videos, 
        												'excludeId' => $this->excludeId, 
        												'src' => $this->src,
        												'playlist' => $this->playlist,
        		
        ));
    }
}
?>
