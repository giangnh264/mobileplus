<?php
/**
 * class Genre
 *
 * @author : tanpv
 */
class GenreList extends CWidget
{
    public $parentGenres;
    public $arrSubGenres;
    public $type;

    
    public function init()
    {
    }

    public function run()
    {
        $this->render('GenreListWidget', array('parentGenres' => $this->parentGenres, 'arrSubGenres' => $this->arrSubGenres, 'type' => $this->type));
    }
}
?>
