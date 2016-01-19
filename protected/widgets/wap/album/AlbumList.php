<?php
/**
 * class AlbumList
 *
 * @author : longtv
 */
class AlbumList extends CWidget
{
    public $albums;
    public $albumPages;
    public $type;
    public $link = null;
    // cac tham so cho phan search
    public $numFound = null;
    public $objType = null;
    public $keyword = null;

    // tham so cho Ajax paging
    public $current_paging = null;
    // tham so cho collection
    public $options = array();
    
    public function init()
    {
    }

    public function run()
    {
        $this->render('AlbumListWidget', array('albums' => $this->albums, 'current_paging' => $this->current_paging, 'link' => $this->link,'albumPages' => $this->albumPages, 'type' => $this->type, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword, 'options' => $this->options));
    }
}
?>
