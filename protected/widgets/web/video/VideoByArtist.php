<?php

class VideoByArtist extends CWidget {
    public $order;
    public $videos;
    public $artistName;
    public $boxObj;
    public $limit = 1000;
    
    public function run() {
        $this->render("videoByArtist", array('videos'=>$this->videos,
                                             'artistName'=>$this->artistName,
                                             'boxObj'=>$this->boxObj,
                                             'limit'=>$this->limit, 
                                             'order'=>$this->order));
    }
}