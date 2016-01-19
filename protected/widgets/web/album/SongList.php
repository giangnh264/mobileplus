<?php

class SongList extends CWidget {
    public $order;
    public $album;
    public $songs;
    public $limit = 1000;
    public $option = 'album';
    public $playerType = 'flash';
	public $showPlayer = true;
	public $classScroll='';
    public function init() {
        
    }

    public function run() {
    	if($this->playerType == "html5"){
    		$this->render("songlist", array(
    				"order" => $this->order,
    				"songs" => $this->songs,
    				"limit" => $this->limit,
    				"option" => $this->option,
    		));
    	}else{
		if(count($this->songs)>0) {
			$cs = Yii::app()->clientScript;
			$cs->registerScript('play_album_add_scroll', "
			var escroll = $('.album_song_list').jScrollPane();
			var api = escroll.data('jsp');
			function scrollToY(index){
				api.scrollToY(index*50,'slow');
			}
			", CClientScript::POS_END);
			//$this->classScroll = 'album_song_list';
			}
    		$this->render("songlist_flash", array(
    				"order" => $this->order,
    				"songs" => $this->songs,
    				"limit" => $this->limit,
    				"option" => $this->option,
    		));
    	}
        
    }

}