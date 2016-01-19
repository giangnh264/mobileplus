<?php
class ListGenre extends CWidget
{
	public $type;
	public function run()
	{
		$curGenre = Yii::app()->request->getParam('id', 0);
		$genres = WebGenreModel::model()->gettreelist();
		$this->render("list",compact("genres", "curGenre"));
	}
}
