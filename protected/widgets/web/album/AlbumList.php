<?php

class AlbumList extends CWidget {

    public $albums;
    public $itemInRow = 5;
    public $option = "";
    public $pageTitle = "List of albums";
    public $moreLink = "#";
    public $artist = null;

    public function run() {
    	if ($this->option == 'BXH') {
    		$this->render("bxh");
    	} else {
	    	$sufix = "";
	    	if($this->option=='search') $sufix="_search";
	        $this->render("list".$sufix);
    	}
    }
}