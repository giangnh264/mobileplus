<?php

class NewsBox extends CWidget {
    public $news;
    public $limit = 5;
    
    public function run() {
        $this->render("newsbox");
    }

}