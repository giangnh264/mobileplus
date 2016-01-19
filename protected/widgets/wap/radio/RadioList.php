<?php
/**
 * class RadioList (for Horoscopes)
 *
 * @author : haltn
 */
class RadioList extends CWidget
{
    public $radios;    
    public $type;

    public function run()
    {
        $this->render('radioList', array('radios' => $this->radios, 'type' => $this->type));
    }
}
?>
