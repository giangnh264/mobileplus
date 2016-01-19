<?php
class ListHome extends CWidget
{
	public function run()
	{
		$c = new CDbCriteria();
		$c->limit = 5;
		$c->order = "id DESC";
		$news = WebNewsModel::model()->published()->findAll($c);
		$this->render("home",compact("news"));
	}
}