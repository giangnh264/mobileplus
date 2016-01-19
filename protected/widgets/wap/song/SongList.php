<?php
class SongList extends CWidget
{
    public $songs;
    public $songPages;
    public $type;
    public $defaultAvatar = false;
    public $link = null;
    // cac tham so cho phan search
    public $numFound = null;
    public $objType = null;
    public $keyword = null;
    
    // tham so cho Tich hop music gift
    public $icon_type = null;
    // tham so cho Ajax paging
    public $current_paging = null;
    
    // tham so cho collection
    public $options = array();
    public function init()
    {
    	if(empty($this->songs) && isset($this->options['songType'])){
    		$this->songs = WapSongModel::getListByCollection($this->options['songType']);
    	}
    }

    public function run()
    {
        $this->render('SongListWidget', array('songs' => $this->songs, 'current_paging' => $this->current_paging, 'link' => $this->link, 'songPages' => $this->songPages, 'type' => $this->type, 'defaultAvatar' => $this->defaultAvatar, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword, 'icon_type' => $this->icon_type, 'options' => $this->options));
    }
}
?>
