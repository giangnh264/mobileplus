<?php
/**
 * class RingbacktoneList
 * @author : HiepnNQ
 * 07-08-2012
 */
class RingbacktoneList extends CWidget
{
    public $ringbacktones;
    public $ringbacktonePages;
    public $catname;
    public $rbtCat;
    public $type;
   // cac tham so cho phan search
    public $link = null;
    public $numFound = null;
    public $objType = null;
    public $keyword = null;
    // tham so cho collection
    public $options = array();
    public function init(){}

    public function run(){
        $this->render('RingbacktoneListWidget', array(
            'ringbacktones' => $this->ringbacktones,
            'ringbacktonePages' => $this->ringbacktonePages,
            'catname' => $this->catname,
            'type' => $this->type,            
            'rbtCat' => $this->rbtCat, 'link' => $this->link, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword));
    }
}
?>
