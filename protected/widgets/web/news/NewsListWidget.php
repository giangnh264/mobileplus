<?php
class NewsListWidget extends CWidget {
	
    public $news;
    public $title = Null;

    public function run() {
        $currPage = Yii::app()->request->getParam('page',1);
        $this->render('newsListWidget', array(
            'news' => $this->news,
            'title'=>$this->title,
            compact('currPage')
        ));
    }
}
