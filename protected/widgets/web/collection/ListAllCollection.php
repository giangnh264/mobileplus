<?php

class ListAllCollection extends CWidget {
    public $title = 'Thế giới có gì?';
    public $limit = 10;
    
    public function run() {
        $collectionCode = 'VIDEO_HOT';
        $collection = WebCollectionModel::model()->findByAttributes(array('code'=>$collectionCode));
        $videos = MainContentModel::getListByCollection($collectionCode, 1, 3);
        
        $this->render("list", array('videos'=>$videos,
                                    'title' =>$this->title,
                                    'limit'=>$this->limit,
        							'collection'=>$collection
        ));
    }
}