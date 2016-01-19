<?php
class HerocopesWidget extends CWidget {
    public $id = 211;
    public $limit = 4;
    public function run(){
        $criteria = new CDbCriteria();
        $criteria->condition = "parent_id=".$this->id . " AND status = ".RadioModel::_ACTIVE;
        $criteria->order = "ordering ASC";
        $criteria->limit = $this->limit;
        $radioList = RadioModel::model()->findAll($criteria);
        $this->render('herocopesWidget', array('radioList'=>$radioList));
    }
}