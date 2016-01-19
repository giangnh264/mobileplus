<?php
class Video extends CWidget{
    public $code='BXH_VIDEO_VN';
    public $genre=null;

    public function run()
    {
        $limit = 4;
        $data = MainContentModel::getListByCollection('VIDEO_COLLECTION', 1, $limit);
        $this->render('video', compact("data","code","limit"));
    }
}