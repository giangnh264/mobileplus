<?php

class ListRelated extends CWidget {
    public $title;
    public $limit = 12;
    public $topContent;
    public $type = null;
    
    public function run() {
        $topContents = WebTopContentModel::model()->getContentsByType($this->topContent->id, $this->type, $this->limit);

        $this->render("related", array('topContents'=>$topContents,
                                        'title'=>$this->title,
                                        'limit'=>$this->limit,
                                        'topContent'=>$this->topContent));
    }
}