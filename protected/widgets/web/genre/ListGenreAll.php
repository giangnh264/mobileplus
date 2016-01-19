<?php

class ListGenreAll extends CWidget {
    public $parentIds;
    public $type = 'video';
    public $selectedGenreId = false;
    public $columPercentWidths = array(34, 33, 33);
    public $subPercentWidths = array(60,40,50,50,50,50);
    
    public function run() {
        $curGenre = Yii::app()->request->getParam('id', 0);
        $genres = array();
        $maxRow = 0;
        foreach($this->parentIds as $key=>$value)
        {
            $genreInfo = WebGenreModel::model()->getSubGenre($key, GenreModel::ACTIVE);
            $count = count($genreInfo);
            if($count > $maxRow)
                $maxRow = $count;
            if(isset($genreInfo)){
                $genres[] = array('id'=>$key, 'name'=>$value, 'data'=>$genreInfo);
            }
        }
        $this->render("listGenreAll", compact("genres", 'maxRow'));
    }

}
