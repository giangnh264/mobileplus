<?php
class NewsList extends CWidget {
	
    public $news;
    public $limit = 1000;
    public $pageTitle = 'News';
    public $option = ''; 

    public function run() {
        $this->render('newsList', array(
            'news' => $this->news,
            'limit' => $this->limit,            
            'pageTitle'=>$this->pageTitle,
            'option' => $this->option
        ));
    }
}