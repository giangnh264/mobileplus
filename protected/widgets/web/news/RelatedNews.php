<?php
class RelatedNews extends CWidget {
	
    public $news;    

    public function run() {
        $this->render('relatedNews', array(
            'news' => $this->news,            
        ));
    }
}