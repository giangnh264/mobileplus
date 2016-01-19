<?php
/**
 * class VideoList
 *
 * @author : longtv
 */
class VideoList extends CWidget
{
    public $videos;
    public $videoPages;
    public $type;
    public $link = null;
    // cac tham so cho phan search
    public $numFound = null;
    public $objType = null;
    public $keyword = null;
    
    // tham so cho Ajax paging
    public $current_paging = null;
    
    // tham so cho collection
    public $options = array();
    public function init()
    {
    }

    public function run()
    {
        $this->render('VideoListWidget', array('videos' => $this->videos, 'current_paging' => $this->current_paging, 'link' => $this->link, 'videoPages' => $this->videoPages, 'type' => $this->type, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword, 'options' => $this->options));
    }
}
?>
