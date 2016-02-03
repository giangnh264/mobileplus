<?php

/**
 * Lop active record danh cho cac noi dung: song, video, album, playlist, ringtone, rbt
 */
class MainContentModel extends MainActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Album the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * overwrite function beforeSave
     * @return type
     */
//    protected function beforeSave() {
//        $this->name = ucfirst($this->name);
//        return parent::beforeSave();
//    }


     /**
     * overwrite function afterSave
     * @return type
     */
    protected function beforeSave() {
        /* if(isset($this->genre_id)){
            $genre_id = $this->genre_id;

            // lay danh sach Genre cua moi Suggest
            $cri = new CDbCriteria();
            $cri->condition = "status = 1";
            $suggestLists = SuggestModel::model()->findAll($cri);

            $arr_genreId = array();
            foreach ($suggestLists as $suggest) {
                if(strpos($suggest->artist_id, $artist_id) !== false){
                    $suggestId = $suggest->id;
                    $suggest = "suggest_$suggestId";
                    $this->$suggest = 1;
                }
                else
                    $arr_genreId[$suggest->id] = MainContentModel::getGenreOfSuggest($suggest->id);
            }
            if(count($arr_genreId) > 0){
                foreach ($arr_genreId as $suggestId => $arr_genre) {
                    if(in_array($genre_id, $arr_genre)){
                        $suggest = "suggest_$suggestId";
                        $this->$suggest = 1;
                    }
                }
            }
        } */
        return parent::beforeSave();
    }



	public function __get($name)
	{
		if($name == 'url_key'){
			$str = trim(parent::__get($name),"-");
			$str = str_replace("--", "-", $str);
			if(strrpos($str, "-")===false){
				$str = Common::makeFriendlyUrl(trim($str));
			}
			return  str_replace("'", "", $str); ;
		}
		return parent::__get($name);
	}

}

?>