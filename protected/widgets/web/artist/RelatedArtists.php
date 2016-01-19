<?php

class RelatedArtists extends CWidget {
    public $artists;
    public $limit = 4;
    
    public function run() {
        $this->render("relatedArtists");
    }

}