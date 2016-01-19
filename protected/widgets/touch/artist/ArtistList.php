<?php
/**
 * class ArtistList
 *
 * @author : longtv
 */
class ArtistList extends CWidget
{
    public $artists;
    public $artistPages;
    // cac tham so cho phan search
    public $type = null;
    public $link = null;
    public $numFound = null;
    public $objType = null;
    public $keyword = null;
    public function init()
    {
    }

    public function run()
    {
        $this->render('ArtistListWidget', array('artists' => $this->artists, 'type' => $this->type,'link' => $this->link, 'artistPages' => $this->artistPages, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword));
    }
}
?>
