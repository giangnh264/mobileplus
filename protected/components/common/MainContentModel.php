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
     * lay Danh sach Genre cua suggest
     * @param type $suggest_id
     * @return Mang genre Id cua suggest
     */
    protected static function getGenreOfSuggest($suggest_id = 1) {
        $genre_ = SuggestModel::model()->findByPk($suggest_id);
        $genre_suggest = $genre_->genre_id;
        $genre_suggest = trim($genre_suggest);
        if($genre_suggest != "0"){
            $tmp_ar = explode(",", $genre_suggest);
            $genre_arr = array();
            foreach($tmp_ar as $genre_id){
                if(!empty($genre_id)){
                    $genre_arr[] = $genre_id;
                    // lay cac the loai con
                    $cri = new CDbCriteria;
                    $cri->select = "id";
                    $cri->condition = "parent_id = $genre_id";
                    $genre_list = GenreModel::model()->findAll($cri);
                    foreach($genre_list as $genre){
                        $genre_arr[] = $genre->id;
                    }
                }
            }

            return $genre_arr;
        }
        else
            return null;
    }

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

    /**
     * gan them truy van suggest noi dung cho nguoi dung
     * @param CDbCriteria $criteria
     * @return \CDbCriteria
     */
    public static function applySuggestCriteria($className, $criteria) {
        return $criteria;
//        $host = ($_SERVER["HTTP_HOST"]);
//        $arr = explode('.',$host);
//
//        if($arr[0] == 'm')
//            return $criteria;
//        if (!$criteria)
//            $criteria = new CDbCriteria ();

        // thong tin cua nguoi dung hien tai duoc luu trong session
        $user = Yii::app()->user->getState('_user');
        // neu ton tai danh sach suggest cho nguoi dung
        if (isset($user) && (trim($user['suggested_list']) != "")) {
            $suggestCols = array();
            $suggestedIds = explode(",", $user['suggested_list']);
            $model = new $className();
            foreach ($suggestedIds as $suggestedId) {
                $colName = self::getSuggestedColNameById($suggestedId);
                if ($model->hasAttribute($colName)) {
                    $suggestCols[] = $colName;
                }
            }
            if (!empty($suggestCols)) {
                // $suggestSelect la chuoi duoc gan vao phan SQL SELECT
                // $suggestSelect co dang: SELECT (suggest_1+suggest_2) AS suggestLevel
                $suggestSelect = "(" . implode("+t.", $suggestCols) . ") AS suggestLevel";
                if ($criteria->select != "") {
                    $criteria->select .= ",$suggestSelect";
                } else {
                    $criteria->select = $suggestSelect;
                }

                // order
                $suggestOrder = "suggestLevel DESC";
                if ($criteria->order != "") {
                    $criteria->order = "$suggestOrder," . $criteria->order;
                } else {
                    $criteria->order = $suggestOrder;
                }
            }
        }

        return $criteria;
    }

    /**
     * Lay ten coloumn dung de suggest
     * @param INT $suggestedId
     * @return STRING
     */
    public static function getSuggestedColNameById($suggestedId) {
        return "suggest_$suggestedId";
    }
    /**
     * Count danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public static function countListByCollection($collectionCode, $filter_sync_status = '') {
    	$collection = Yii::app()->cache->get("COLLECTION_$collectionCode");
    	if(false===$collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set("COLLECTION_$collectionCode",$collection,Yii::app()->params['cacheTime']);
    	}

        if(!empty($collection))
            return $collection->getItems(0,1,$filter_sync_status,true);
        return null;

    }
    /**
     * Lay danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @param boolean $filter_sync_status: neu = true => chi lay item ma sync_status = 1
     * @param boolean $filterByDomain: neu = true => loc Collection tuong ung cua moi domain
     * @return \CActiveDataProvider
     */
    public static function getListByCollection($collectionCode, $page = 1, $limit = 0, $filter_sync_status = '') {
        $cache_code = "COLLECTION_{$collectionCode}_page_{$page}_limit_{$limit}";
        $collection = Yii::app()->cache->get($cache_code);
        if(false === $collection){
        	$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
        	Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
        }


        if($collection)
            return  $collection->getItems($page, $limit, $filter_sync_status);
        return null;
    }
    
    public static function getListByCollectionByDistrict($collectionCode, $district, $page = 1, $limit = 0) {
       	$cache_code = "COLLECTION_{$collectionCode}_page_{$page}_limit_{$limit}_district_{$district}";
    	$collection = Yii::app()->cache->get($cache_code);
    	if(false === $collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
    	}
    
    	if($collection)
    		return  $collection->getItemsByDistrict($page, $limit, $district);
    	return null;
    }

    /**
     * lay danh sach suggest: Nhac mien tay...
     */
    public static function getSuggestList() {
        $cri = new CDbCriteria;
        $cri->condition = "status = 1";
        $suggestLists = SuggestModel::model()->findAll($cri);

        $arrSgL = array();
        foreach ($suggestLists as $suggestList) {
            $arrSgL['suggest_' . $suggestList->id] = $suggestList->name;
        }
        return $arrSgL;
    }

    /** Hien thi thong tin Suggest
     * vi du:               suggest_Nh?c mi?n t�y    :	No
     * @param type $className
     * @param type $id
     * @return string
     */


    public static function viewSuggestList($className = __CLASS__, $id) {
        $model = parent::model($className);
        $model = $model->findByPk($id);
        $attributes = $model->getAttributes();
        $suggestLists = MainContentModel::getSuggestList();
        $result = array();

        $suggest = array(
                1 => "Yes",
                0 => "No",
            );
        foreach ($attributes as $key => $val) {

            if (empty($val))
                $val = 0;
            if (array_key_exists($key, $suggestLists)) {
                $result[] = array(
                    'label' => $suggestLists[$key],
                    'value' => $suggest[$val],
                    'type' => 'html'
                );
            }
        }
        return $result;
    }

    /**
     * Show form update suggest
     * @param type $className
     * @param type $id
     * @return string
     */
    public static function updateSuggestList($className = __CLASS__, $id = NULL) {
        $model = parent::model($className);
        if(!empty($id))
            $model = $model->findByPk($id);
        $attributes = $model->getAttributes();
        $suggestLists = MainContentModel::getSuggestList();

        $result = array();///in this format: ["suggest_1"]=> string(29) "1++suggest_Nh?c mi?n t�y"
        foreach ($attributes as $key => $val) {
            if (empty($val))
                $val = 0;
            if (array_key_exists($key, $suggestLists)) {
                $result[$key] = $val . "++" . $suggestLists[$key];
            }
        }
        return $result;
    }


    public static function getUserInfo($phone = null){
        if(!isset($phone))
            $phone = yii::app()->user->getState('msisdn');
        $cri = new CDbCriteria;
        $cri->condition = " phone = '$phone'";
        $user = UserModel::model()->find($cri);
        return $user;
    }

    public static function getListByCollectionForClient($collectionCode,$limit = 10, $offset = 0) {
        $cache_code = "COLLECTION_{$collectionCode}_page_{$offset}_limit_{$limit}";
        $collection = Yii::app()->cache->get($cache_code);
        if(false === $collection){
        	$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
        	Yii::app()->cache->set($cache_code,$collection,Yii::app()->params['cacheTime']);
        }
        if($collection)
              if($collection->mode == CollectionModel::MODE_AUTO) return $collection->_getItemsAutoClient($offset, $limit);
        else return $collection->_getItemsManualClient($offset, $limit);
//            return  $collection->_getItemsManualClient($offset, $limit);
        return null;

    }
    
    /**
     * Count danh sach noi dung theo collection
     * @param INT $page
     * @param INT $limit
     * @return \CActiveDataProvider
     */
    public static function countListByCollectionForClient($collectionCode) {
    	$collection = Yii::app()->cache->get("COLLECTION_$collectionCode");
    	if(false===$collection){
    		$collection = CollectionModel::model()->findByAttributes(array('code' => $collectionCode));
    		Yii::app()->cache->set("COLLECTION_$collectionCode",$collection,Yii::app()->params['cacheTime']);
    	}
//        if(!empty($collection))
//            return $collection->_getItemsManualClient(0,1,true);
         if($collection)
              if($collection->mode == CollectionModel::MODE_AUTO) return $collection->_getItemsAutoClient(0, 1, true);
        else return $collection->_getItemsManualClient(0,1,true);
        return null;

    }

	/* get song/video/album/playlist tu News Event id */
	public static function getNewsEventDetail($objectId, $type){
		return array();
		/* if( empty($objectId) || empty($type))
			return null;
		$itemModelName = ucfirst($type)."Model";
		if($type != 'news')
			$result = $itemModelName::model()->with($type."_statistic")->findByPk($objectId);
		else
			$result = $itemModelName::model()->findByPk($objectId);
		return $result; */
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