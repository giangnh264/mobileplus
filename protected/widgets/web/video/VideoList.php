<?php

class VideoList extends CWidget {

    public $videos;
    public $option = "box";
    public $pageTitle = "List of videos";
    public $moreLink= null;
    public $artist = null;
    public $mvDetailId = 0;
    public $playlistId = 0;
    public $limit = 0;

    public function run() {
    	if ($this->option == 'BXH') {
        	$this->render("bxh");
    	} else {
    		$this->render("list");
    	}
    }
}