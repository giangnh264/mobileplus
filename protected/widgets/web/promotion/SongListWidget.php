<?php

class SongListWidget extends CWidget {

    public $songList;
    public $type = 'hot';
    public $page = 'home';
    public $title = 'Hot songs';
    public $class = 'song_hot_home';
    public $playall = false;
    public $playall_url = '';
    public $genre = null;
    public $show_type = false;
    public $link = '';

    public function run() {
        if (strtolower($this->type) == 'new' && $this->page=='home') {
            $this->class = 'song_new_home';
        }
        $currPage = Yii::app()->request->getParam('page', 1);
        $this->render("list_widget", compact('currPage'));
    }

}
