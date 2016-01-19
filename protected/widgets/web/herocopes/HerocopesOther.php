<?php

class HerocopesOther extends CWidget {
    public $order;
    public $radioId=0;
    public $boxObj;
    
    public function run() {
        $time = time();
        $dateTimeFormat = $this->getFormatTime($time);
        $crit = new CDbCriteria();
        $crit->condition = "time_point like :time_point AND day_week like :day_week AND status=1 AND id<>:id";
        $crit->params = array(
            ':time_point'=>"%{$dateTimeFormat['TP']}%",
            ':day_week'=>"%{$dateTimeFormat['DOW']}%",
            ':id'=>$this->radioId
        );
        $crit->order = "id DESC";
        $crit->limit = 4;
        $radioList = RadioModel::model()->findAll($crit);
        $this->render("herocopesOther", array('radioList'=>$radioList));
    }
    protected function getFormatTime($timeStamp)
    {
        $data = array();
        $tempDate = date('Y-m-d', $timeStamp);
        $data['DOW'] = date('N', strtotime($tempDate));
        $timePoint = date('H:i:s', $timeStamp);
        if($timePoint>='00:00:00' && $timePoint<='12:00:00'){
            //sang
            $data['TP'] = 1;
        }elseif($timePoint>'12:00:00' && $timePoint<='19:00:00'){
            //chieu
            $data['TP'] = 2;
        }else{
            //toi
            $data['TP'] = 3;
        }
        return $data;
    }
}