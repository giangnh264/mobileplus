<?php

class AlbumByGenre extends CWidget {
    public $order;
    public $albums;
    public $boxObj;
    public $limit = 1000;
    
    public function run() {
        $this->render("albumByGenre", array('albums'=>$this->albums,
                                             'boxObj' =>$this->boxObj,
                                             'limit'=>$this->limit, 
                                             'order'=>$this->order));
    }
}