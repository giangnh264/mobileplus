<?php

class TopContent extends CWidget
{
    public $data = null;
    public $title = 'Chủ đề âm nhạc';
    public $link = '';

    public function run()
    {
        $topContent = $this->data;
        $title = $this->title;
        $this->render("topContent", compact('topContent', 'title'));
    }
}