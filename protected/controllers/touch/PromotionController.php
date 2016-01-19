<?php
class PromotionController extends TController{
    const _NUMBER_ITEM_SONG = 5;
    public function actionAbout(){
        $content = HtmlModel::model()->findByPk(25)->content;
        $this->render('about', compact('content'));

    }
    public function actionHotlist(){
        $limit = self::_NUMBER_ITEM_SONG;
        $albums = MainContentModel::getListByCollection('CTKM_ALBUM_HOT', 1, $limit);
        $videos = MainContentModel::getListByCollection('CTKM_VIDEO_HOT', 1, $limit);
        $songs = MainContentModel::getListByCollection('CTKM_SONG_HOT', 1, self::_NUMBER_ITEM_SONG);
        $this->render("hotlist", compact('albums','videos','songs'));
    }

    public function actionList(){
        $current_week = Yii::app ()->request->getParam ( 'week');
        if(empty($current_week)){
            $current_week = date('W') - 1;
            if($current_week >= 48){
                $current_week = 48;
            }
        }
        $first_week = 41;
        $week = (int) date('W');
        if($week >= 48){
            $week = 48;
        }
        $list_week = array();
        for($i = $first_week; $i<=$week;$i++){
            $list_week[] = $i;
        }
        $data = StatisticUserPointModel::model()->findUserByWeek($current_week);
        $my_phone = Yii::app()->user->getState('msisdn');
        $this->render('list', compact('current_week','list_week','data','my_phone'));
    }

    public function actionCheck(){
        $is_login = false;
        $point = 0;
        $phone = null;
        $list_week = '';
        if (Yii::app ()->user->isGuest) {
            $model = new LoginForm ();
            $errorMsg = $errorMsg_Wap = "";
            if ($msg = Yii::app()->request->getParam('msg', false)) {
                $errorMsg = $msg;
            }
            if (Yii::app()->request->isPostRequest) {
                if(empty($_POST['LoginForm']['phone'])){
                    $errorMsg_Wap = "Số điện thoại không được để trống";
                }else{
                    $model->attributes = $_POST['LoginForm'];
                    $model->phone = Formatter::formatPhone($_POST ['LoginForm']['phone']);
                    if ($model->validate() && $model->login()) {
                        MainUserIdentity::_logDetectMSISDN($_POST['LoginForm']['phone'], "F5", 'wap');
                        $back = Yii::app()->request->getParam('back', false);
                        if ($back) {
                            $this->redirect($back);
                        }
                        $this->redirect(Yii::app()->createUrl("/promotion/check"));
                    } else {
                        $errors = $model->getErrors();
                        foreach ($errors as $key => $err) {
                            $errorMsg .= "<div class='errormsg'>{$err[0]}</div>";
                        }
                    }
                }
            }
        }else{
            $is_login = true;
            $phone = Yii::app()->user->getState('msisdn');
            $current_week = Yii::app ()->request->getParam ( 'week');
            if(empty($current_week)){
                $current_week = date('W');
                if($current_week >= 48){
                    $current_week = 48;
                }
            }
            //$list_week = StatisticUserPointModel::model()->getListWeek();
            $first_week = 41;
            $week = (int) date('W');
            if($week >= 48){
                $week = 48;
            }
            $list_week = array();
            for($i = $first_week; $i<=$week;$i++){
                $list_week[] = $i;
            }
            $point = GUserModel::model()->findByAttributes(array('user_phone'=>$phone))->point;
            if(empty($point))
                $point = 0;
            $year = date('Y');
            $first_date = date("Y-m-d", Utils::getFirstDayOfWeek($year, $current_week));
            $end_date = date("Y-m-d", strtotime("+6 day", Utils::getFirstDayOfWeek($year, $current_week)));
            $count = UserEventModel::model()->countbyUserByTime($phone, $first_date, $end_date);
            $page = new CPagination($count);
            $page->pageSize = 10;
            $dataProvider = UserEventModel::model()->getbyUserByTime($phone, $count, $page->getOffset(), $first_date, $end_date);
        }
        $this->render('check', array(
            'model'         => $model,
            'errorMsg'      => $errorMsg,
            'errorMsg_Wap'  => $errorMsg_Wap,
            'dataProvider'  => $dataProvider,
            'list_week'     => $list_week,
            'point'         => $point,
            'phone'         => $phone,
            'is_login'      => $is_login,
            'current_week'  => $current_week
        ));
    }

    public function actionSong(){
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $page = (int) Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberSongPerPage'];
        $count_hot = WapSongModel::countListByCollection('CTKM_SONG_HOT');
        $songs = WapSongModel::getListByCollection('CTKM_SONG_HOT', $page, $limit);
        $pager = new CPagination($count_hot);
        $pager->setPageSize($limit);
        $callBackLink = Yii::app()->createUrl("promotion/song");
        if ($callBack) {
            $this->layout = false;
            $this->render("_songajaxList", compact('songs', 'pager', 'callBackLink', 'options'));
        } else {
            $userPlaylist = array();
            if ($this->userPhone) {
                $userPlaylist = WapPlaylistModel::model()->getPlaylistByPhone($this->userPhone, $limit, $page);
            }
            $this->render("song", compact('songs', 'pager', 'callBackLink', 'userPlaylist'));
        }
    }

    public function actionVideo(){
        $callBack =(int) Yii::app()->request->getParam('call_back', 0);
        $page = (int)Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->params ['numberPerPage'];
        $callBackLink = Yii::app()->createUrl("promotion/video");
        $options = array();
        $count = WapVideoModel::countListByCollection('CTKM_VIDEO_HOT');
        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $videos = WapVideoModel::getListByCollection('CTKM_VIDEO_HOT', $page, $limit);
        $options['headerText'] = 'Video Hot';
        if ($callBack) {
            $this->layout = false;
            $this->render("_videoajaxList", compact('videos', 'pager', 'callBackLink', 'options'));
        } else {
            $this->render('video', array(
                'videos' => $videos,
                'pager' => $pager,
                'callBackLink' => $callBackLink,
                'options'=>$options
            ));
        }
    }

    public function actionAlbum(){
        $limit = Yii::app()->params['numberPerPage'];
        $page = (int) Yii::app()->request->getParam('page', 1);
        $callBack = (int) Yii::app()->request->getParam('call_back', 0);
        $callBackLink = Yii::app()->createUrl("promotion/album");
        $count = MainContentModel::countListByCollection('CTKM_ALBUM_HOT');
        $pager = new CPagination($count);
        $pager->setPageSize($limit);
        $albums = MainContentModel::getListByCollection('CTKM_ALBUM_HOT', $page, $limit);
        $options = array('col' => 'ALBUM_NEW','headerText'=>"ALBUM MỚI");
        if ($callBack) {
            $this->layout = false;
            $this->render("_albumajaxList", compact('albums', 'pager', 'callBackLink', 'options'));
        } else {
            $this->render('album', array(
                'albums' => $albums,
                'callBackLink' => $callBackLink,
                'options' => $options,
                'pager'=>$pager
            ));
        }
    }
}