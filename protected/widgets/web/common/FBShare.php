<?php

class FBShare extends CWidget {

    public $url = "metfone.com.kh";
    public $title = "metfone.com.kh";
    public $imgsrc = "metfone.com.kh";
    public $desc = "metfone.com.kh";
    public $name = "metfone.com.kh";

    public function init() {}

    public function run() {
        $this->render("FBShare", array(
            "url" => $this->url,
            "title" => $this->title,
            "imgsrc" => $this->imgsrc,
            "desc" => $this->desc,
            "name" => $this->name
        ));
    }
}
?>