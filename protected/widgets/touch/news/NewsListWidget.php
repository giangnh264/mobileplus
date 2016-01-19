<?php
class NewsListWidget extends CWidget
{
	
	public $news = null;
	public function run()
	{
		$this->render('list', array(
				'news'=>$this->news
		));
	}
}