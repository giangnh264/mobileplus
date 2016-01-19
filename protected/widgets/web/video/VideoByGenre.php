<?php

class VideoByGenre extends CWidget {
    public $order;
    public $videos;
    public $boxObj;
    public $limit = 1000;
    
    public function run() {
        $this->render("videoByGenre", array('videos'=>$this->videos,
                                             'boxObj' =>$this->boxObj,
                                             'limit'=>$this->limit, 
                                             'order'=>$this->order));
    }
}