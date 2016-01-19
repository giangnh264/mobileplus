<?php
class AlbumHotMoiList extends CWidget
{
	public $albumList;
	public $type = null;
	public $district = "VN";
	public $pageTitle = null;
	function run()
	{
		$this->render("hotMoiList");
	}
}
