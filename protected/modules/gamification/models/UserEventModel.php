<?php
Yii::import('application.modules.gamification.models._base.BaseUserEventModel');
class UserEventModel extends BaseUserEventModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->point = (int) $this->point;
            $this->user_id = (int) $this->user_id;
            return true;
        }
        else return false;
    }
    public function wLogEvent($user_id,$user_phone,$eventId,$source,$contentId='',$contentName='',$transaction='',$transactionId=0, $transaction_name, $log_point)
    {
        try {
        $log = new KLogger('log_event_users_transaction', KLogger::INFO);
        $event = EventModel::model()->findByPk(new MongoId($eventId));
            $point = $event->point;
        if($log_point == 0){
            $point = 0;
        }
        $log->LogInfo("$transaction|$user_phone|$contentId|$point", false);
        $userSubscribe = true;
        switch($transaction)
            {
                case 'play_song':
                    $transactionValid = $this->isContent24h($contentId,$eventId,$user_phone,$transaction);
                    $point = $this->getPoint($contentId,$transaction, $point);
                    $pointValid = $this->isPoint24h($point, $user_phone);
                    break;
                case 'play_video':
                    $transactionValid = $this->isContent24h($contentId,$eventId,$user_phone,$transaction);
                    $point = $this->getPoint($contentId,$transaction, $point);
                    $pointValid = $this->isPoint24h($point, $user_phone);
                    break;
                case 'play_album':
                    $transactionValid = $this->isContent24h($contentId,$eventId,$user_phone,$transaction);
                    $point = $this->getPoint($contentId,$transaction, $point);
                    $pointValid = $this->isPoint24h($point, $user_phone);
                    $userSubscribe = UserSubscribeModel::model()->get($user_phone);
                    break;
                default:
                    $transactionValid = true;
                    $pointValid = true;
                    break;
            }
            if($transactionValid && $pointValid && $userSubscribe) {
                if ($event && (!empty($user_id) || !empty($user_phone))) {
                    $eventName = $event->name;
                    $groupEventId = $event->group_id;
                    $groupEventName = $event->group_name;
                    $model = new self();
                    $model->user_id = (int) $user_id;
                    $model->user_phone = !empty($user_phone)?$user_phone:0;
                    $model->event_id = $eventId;
                    $model->event_name = $eventName;
                    $model->group_id = $groupEventId;
                    $model->group_name = $groupEventName;
                    $model->content_id = $contentId;
                    $model->content_name = $contentName;
                    $model->transaction = $transaction;
                    $model->transaction_name = $transaction_name;
                    $model->transaction_id = (string) $transactionId;
                    $model->point = (int) $point;
                    $model->method = $source;
                    $model->created_time = date('Y-m-d H:i:s');
                    $model->updated_time = date('Y-m-d H:i:s');
                    $res = $model->save();
                    $log->LogInfo('write log '.$transaction.' | '.$user_phone.'|'.$transaction.'|event:'.$eventId.'|'.json_encode($res), false);
                    if(!$res){
                        $errors = $model->getErrors();
                        $log->LogInfo('update log new:'.json_encode($errors), false);
                    }else{
                        $updatePoint = self::model()->updatePoint($user_id,$user_phone,$point, $event->reset);
                        $log->LogInfo('update point|'.$user_id.'|'.json_encode($user_phone).':'.json_encode($updatePoint), false);
                        return $updatePoint;
                    }
                    //return $res;
                }
            }
        }catch (Exception $e)
        {
            //$e->getMessage();
            $log->LogInfo('update log exception:'.$e->getMessage());
            return false;
        }
        return false;
    }
    /**
     * check is the first log
     */
    public function checkIsFirstEvent($user_phone,$eventId,$onDay=false){
        $c = array(
            'conditions'=>array(
                'user_phone'=>array('=='=>$user_phone),
                'event_id'=>array('=='=>$eventId)
            ),
            'limit'=>1
        );
        if($onDay){
            $dateNow = date('Y-m-d');
            $c['conditions']['created_time'] = array('>='=>$dateNow.' 00:00:00','<='=>$dateNow.' 23:59:59');
        }
        $res = self::model()->find($c);
        return $res?false:true;
    }
    /**
     * check log sau 30 phut or chua ton tai
     */
    public static function checkIsLogAfterTime($userPhone,$contentId,$eventId,$time=1800)
    {
        $c = array(
            'conditions'=>array(
                'content_id'=>array('=='=>(string) $contentId),
                'event_id'=>array('=='=>$eventId),
                'user_phone'=>array('=='=>$userPhone)
            ),
            'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
            'limit'=>1
        );
        $result = UserEventModel::model()->find($c);
        if($result){
            $lastestLogTime = $result->created_time;
            if(time()-strtotime($lastestLogTime)<$time){
                return false;
            }
        }
        return true;
    }
    /**
     * get max id transaction
     */
    public function getMaxIdTransaction($transaction){
        $c = array(
            'conditions'=>array(
                'transaction'=>array('=='=>(string) $transaction)
            ),
            'sort'=>array('transaction_id'=>EMongoCriteria::SORT_DESC),
            'limit'=>1
        );
        $res = self::model()->findAll($c);
        if($res){
            $tsIdMax = false;
            foreach($res as $value){
                $tsIdMax = $value->transaction_id;
            }
            return $tsIdMax;
        }
        return false;
    }
    /**
     * add point to user_extra
     */
    public function updatePoint($userId, $user_phone, $point,$reset=0)
    {
        $log = new KLogger('log_update_point', KLogger::INFO);
        $log->LogInfo('write log user:'.$userId.' | '.$user_phone.'|'.$point.'', false);
        $user = GUserModel::model()->findByAttributes(array('user_phone'=>$user_phone));
        if($user){
            //update point
            $totalPoint = (int)($user->point + $point);
            $user->point = $totalPoint;
            $user->updated_time = date('Y-m-d H:i:s');
        }else{
            $user = new GUserModel();
            $user->user_phone = $user_phone;
            $user->user_id = $userId;
            $user->point = (int) $point;
            $user->created_time = date('Y-m-d H:i:s');
            $user->updated_time = date('Y-m-d H:i:s');
        }
        if($user->save()){
            return true;
        }else {
            $log->LogInfo('res:'. json_encode($user->getErrors()), false);
            return false;
        }

    }
    /**
     *
     */
    private function IsOnlyOneEvent($contentId,$eventId,$userPhone,$isPhone=true)
    {
        $c = array(
            'conditions'=>array(
                'event_id'=>array('=='=>(string) $eventId),
                'content_id'=>array('=='=>(string) $contentId),
            ),
            'limit'=>1
        );
        if($isPhone==false){
            $c['conditions']['user_id'] = array('=='=>(int) $userPhone);
        }else{
            $c['conditions']['user_phone'] = array('=='=>$userPhone);
        }
        $res = UserEventModel::model()->find($c);
        return ($res)?false:true;
    }
    /**
     * check action in 24h
     */
    private function isContent24h($contentId,$eventId,$userPhone,$transaction)
    {
        $today = date('Y-m-d');
        $c = array(
            'conditions'=>array(
                'content_id'=>array('=='=>(string) $contentId),
                'user_phone'=>array('=='=>$userPhone),
                'transaction'=>array('=='=>$transaction),
                'created_time'=>array('>='=>$today.' 00:00:00', '<='=>$today.' 23:59:59')
            ),
            'limit'=>1,
        );
        $res = UserEventModel::model()->find($c);
        return $res?false:true;
    }

    /**
     * check point in 24H
     */
    private function isPoint24h($point, $user_phone)
    {
        $log = new KLogger('log_point_24h', KLogger::INFO);
        $log->LogInfo('write log user:'.$user_phone.' |'.$point.'', false);
        $today = date('Y-m-d');
        $result = UserEventModel::model()->aggregate('user_event', array(
            array('$match'=>array(
                'transaction'=>array(
                    '$in'=>array('play_song', 'play_video', 'play_album')
                ),
                'created_time'=>array('$gte'=>$today.' 00:00:00', '$lte'=>$today.' 23:59:59'),
                'user_phone'=>array('$eq'=>$user_phone),
            )
            ),
            array(
                '$group'=>array('_id'=>null, 'total'=>array('$sum'=>'$point')),
            )
        ));
        if(isset($result['result'])){
            $current_point =  $result['result'][0]['total'];
            $log->LogInfo('current_point:'.$current_point.'', false);
            $total_point = $current_point + $point;
            $log->LogInfo('total_point:'.$total_point.'', false);
            if($total_point <= 10000)
            {
                return true;
            }
            else return false;
        }else return false;

    }

    public function getbyUser($user_phone, $limit, $offset){
        $criteria = new EMongoCriteria;
        $criteria = array(
            'conditions'=>array(
                'user_phone'=>array('==' => $user_phone),
                'point'=>array('>'=>0),
            ),
            'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
            'limit'=>$limit,
            'offset'=>$offset,
        );
        return  UserEventModel::model()->findAll($criteria);
    }

    public function getbyUserByTime($user_phone, $limit, $offset, $first_date, $end_date){
            $criteria = new EMongoCriteria;
            $criteria = array(
                'conditions'=>array(
                    'user_phone'=>array('==' => $user_phone),
                    'created_time'=>array('>='=>$first_date.' 00:00:00', '<='=>$end_date.' 23:59:59'),
                    'point'=>array('>'=>0),
                ),
                'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
                'limit'=>$limit,
                'offset'=>$offset,
            );
            return  UserEventModel::model()->findAll($criteria);

    }

    public function countbyUser($user_phone){
        $criteria = new EMongoCriteria;
        $criteria = array(
            'conditions'=>array(
                'user_phone'=>array('==' => $user_phone),
                'point'=>array('>'=>0),
            ),
        );
        return  UserEventModel::model()->count($criteria);
    }

    public function countbyUserByTime($user_phone, $first_date, $end_date){
        $criteria = new EMongoCriteria;
        $criteria = array(
            'conditions'=>array(
                'user_phone'=>array('==' => $user_phone),
                'created_time'=>array('>='=>$first_date.' 00:00:00', '<='=>$end_date.' 23:59:59'),
                'point'=>array('>'=>0),
            ),
        );
        return  UserEventModel::model()->count($criteria);
    }
    /**
     * get point in hot list
     */
    public function getPoint($content_id, $transaction, $point){
        $log = new KLogger('get_point', KLogger::INFO);
        $log->LogInfo('data:'.$content_id.'||' . $transaction . '||'. $point, false);

        if($transaction == 'play_song'){
            $id = Yii::app()->params['ctkm']['id_collection_song_hot'];
        }
        if($transaction == 'play_video'){
            $id = Yii::app()->params['ctkm']['id_collection_video_hot'];
        }
        if($transaction == 'play_album'){
            $id = Yii::app()->params['ctkm']['id_collection_album_hot'];
        }
//        $dependency = new CDbCacheDependency("SELECT MAX(created_time) FROM collection_item WHERE collect_id = $id");
//        $collection_item = CollectionItemModel::model()->cache(21600, $dependency)->findAllByAttributes(array('collect_id'=>$id));
        $collection_item = CollectionItemModel::model()->findAllByAttributes(array('collect_id'=>$id));
        $data = array();
        foreach ($collection_item as $item){
            $data[] = $item->item_id;
        }
       if(in_array($content_id, $data)){
            $point = 1000;
        }
        return $point;
    }



}