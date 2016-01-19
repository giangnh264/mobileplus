<?php
/**
 * class videoPlaylistList
 *
 * @author : longtv
 */
class Video_playlistList extends CWidget
{
    public $videoPlaylists;
    public $videoPlaylistPages;
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
    public $exclude = null;
    
    public function init()
    {
    }

    public function run()
    {
        $this->render('VideoPlaylistListWidget', array('videoPlaylists' => $this->videoPlaylists, 'current_paging' => $this->current_paging, 'link' => $this->link,
        			'videoPlaylistPages' => $this->videoPlaylistPages, 'type' => $this->type, 'numFound' => $this->numFound, 'objType' => $this->objType, 
        			'keyword' => $this->keyword, 'options' => $this->options,
        			'exclude' => $this->exclude,
        ));
    }
}
?>
