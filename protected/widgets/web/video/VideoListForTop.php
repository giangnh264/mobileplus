<?php

class VideoListForTop extends CWidget {

    public $datas;
    public $detailId = 0;
    public $topContent;
    public $pageTitle = "List of videos";
    public $moreLink= null;
    public $artist = null;

    public function run() {
        $this->render("listForTopContent");
    }
}