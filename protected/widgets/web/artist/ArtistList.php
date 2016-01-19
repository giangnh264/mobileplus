<?php

class ArtistList extends CWidget {

    public $artists;
    public $option = '';
    public $pageTitle = "List of artists";
    public $artistIds = '';
    public $moreLink = null;
    public $exclusion = null;
    public $keyword = null;
    public $type = null;

    public function init(){
        foreach($this->artists as $artist)
        {
            $this->artistIds .= $artist->id . ',';
        }
        if(!empty($this->artistIds))
            $this->artistIds = substr($this->artistIds, 0, -1);
    }
    
    public function run() {
        $this->render("list");
    }
}