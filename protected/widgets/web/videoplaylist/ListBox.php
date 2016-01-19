<?php

class ListBox extends CWidget {
    public $title = 'video playlist';
    public $limit = 1000;
    public $id = null;

    public function run() {
        if($this->id){
            $datas = VideoPlaylistModel::model()->getVideoRelate($this->id, 0, $this->limit, 0);
        }else{
            $datas = VideoPlaylistModel::model()->getList(0, $this->limit, 0);
        }

        $this->render("box", array('videoplaylists'=>$datas,
                                    'title' =>$this->title,
                                    'limit'=>$this->limit));
    }
}