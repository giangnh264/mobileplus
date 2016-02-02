<?php
class SocialShares extends CWidget{
	public $url = 'metfone.com.kh';
	public $name;
	public $imgsrc;
	public $title;
	public function run(){
		$this->render("socialShare");
	}
}