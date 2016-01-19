<?php
class PlaylistsList extends CWidget {
	
    public $playlists;    
    public $pageTitle = '';
    public $option = '';
    public $userId = '';
    public $view = 'list';
    public $link = '';

    public function run() {
        $this->render($this->view, array(
            'playlists' => $this->playlists,
            'pageTitle'=>$this->pageTitle,
            'option' => $this->option,
        	'userId' => $this->userId
        ));
    }
}