<?php
class SongPlayer extends CWidget
{
	public $song;
	public function run()
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/touch/css/player.css');
		$this->render('song');
	}
}
