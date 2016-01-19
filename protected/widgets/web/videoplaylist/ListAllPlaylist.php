<?php
class ListAllPlaylist extends CWidget
{
        public $title = 'video playlist';
        public $videoplaylists;
        public $type='hot';
        
	function run()
	{
            $this->render("list", array('videoplaylists'=>$this->videoplaylists));
	}
}
