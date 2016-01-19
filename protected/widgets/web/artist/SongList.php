<?php

class SongList extends CWidget {
    public $order;
    public $songs;
    public $limit = 10;
    public $pageTitle = 'Song';
    public $moreLink = '#';
    public $artist;
    
    public function init() {
        
    }

    public function run() {
        $this->render("songlist");
    }
}