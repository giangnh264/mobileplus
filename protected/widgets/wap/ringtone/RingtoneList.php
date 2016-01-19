<?php

/**
 * class RingtoneList
 *
 * @author : longtv
 */
class RingtoneList extends CWidget {

    public $ringtones;
    public $ringtonePages;  
    public $type = null;
    // cac tham so cho phan search
    public $link = null;
    public $numFound = null;
    public $objType = null;
    public $keyword = null;
    public function init() {
        
    }

    public function run() {
        $this->render('RingtoneListWidget', array('ringtones' => $this->ringtones, 'link' => $this->link, 'type' => $this->type, 'ringtonePages' => $this->ringtonePages, 'numFound' => $this->numFound, 'objType' => $this->objType, 'keyword' => $this->keyword));
    }

}

?>
