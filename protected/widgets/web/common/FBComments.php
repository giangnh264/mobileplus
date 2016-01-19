<?php
class FBComments extends CWidget{
	public $url = "http://amusic.vn";
	
	public function init(){}
	public function run(){
		echo '';
		 $this->render("fbComments", array(
			"url"	=> $this->url
		));
	}
}