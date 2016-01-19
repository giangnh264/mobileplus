<?php

class AlbumByArtist extends CWidget {
    public $order;
    public $albums;
    public $artistName;
    public $boxObj;
    public $limit = 1000;
    
    public function run() {
        $this->render("albumByArtist", array('albums'=>$this->albums,
                                             'artistName'=>$this->artistName,
                                             'boxObj'=>$this->boxObj,
                                             'limit'=>$this->limit, 
                                             'order'=>$this->order));
    }
}