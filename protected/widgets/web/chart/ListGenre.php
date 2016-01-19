<?php
class ListGenre extends CWidget
{
	public $type;
	public $genre;
	public function run()
	{		
		$this->render("list");
	}
}
