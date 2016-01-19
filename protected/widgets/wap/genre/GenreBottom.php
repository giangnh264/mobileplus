<?php
/**
 * class Genre
 *
 * @author : tanpv
 */
class GenreBottom extends CWidget
{
    public $genres;
    public $genrePages;
    public $type;
    public $special = null;
    public $genre_id = null;
    
    public function init()
    {
    	if(empty($this->genres)){
    		$this->genres = MainActiveRecord::getGenre();
    	}
    }

    public function run()
    {
        $this->render('GenreBottomWidget', array('genres' => $this->genres, 'genrePages' => $this->genrePages, 'type' => $this->type, 'special' => $this->special, 'genre_id'=>$this->genre_id));
    }
}
?>
