<?php
class ListGenreByParent extends CWidget
{
	public $type;
	public $tag;
	public function run()
	{
		$curGenre = Yii::app()->request->getParam('id', 0);
		$type = $this->type;
		$this->render("listGenreByParent",compact( "curGenre", "type"));
	}
}
