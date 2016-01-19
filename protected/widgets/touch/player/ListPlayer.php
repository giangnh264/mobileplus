<?php
class ListPlayer extends CWidget
{
	public $album;
	public $songs;
	public $type='album';
	public $like = null;

	public function run()
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/touch/css/player.css');
		$this->render("listPlayer");
	}
}
