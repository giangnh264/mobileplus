<?php

class AccountController extends TController
{
    /**
     * AES key
     * @var string
     */
    private $key = 'U8hQPJQm5hqBiiIl';
    /**
     * Sp id
     * @var string
     */
    private $spId = '054';


    /**
     *
     * @var AESBase
     */
    private $aes;
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'minLength' => 5,
                'maxLength' => 5,
                'height' => 45
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('index', 'register'),
                'users' => array('?'),
            ),
        );
    }
    public function init() {
        $this->aes = new MobifoneAES($this->key, '');

        parent::init();
    }

    public function actionWelcome()
    {
        $phone = yii::app()->user->getState('msisdn');
        if (!$phone) {
            $this->redirect(Yii::app()->createUrl('/account/login'));
            Yii::app()->end();
        } else {
            if (!$this->userSub) {
                $this->redirect(Yii::app()->createUrl('/account/package'));
                Yii::app()->end();
            }
        }
        $this->redirect(Yii::app()->createUrl('/account/view'));
        Yii::app()->end();
        exit;
    }

    public function actionGuide()
    {
        $id = yii::app()->request->getParam('id', 0);
        $guide = HtmlModel::model()->findByPk($id);
        if (!$guide) {
            throw new CHttpException(404, 'Not found');
            exit;
        }
        if ($guide->channel == 'api') {
            $this->layout = false;
        }
        $wapGuides = HtmlModel::model()->findAllByAttributes(array('type' => 'guide_wap'));
        $this->render('guide', array('guide' => $guide, 'wapGuides' => $wapGuides));
    }

    /**
     * function actionIndex
     * call to render profile index page
     */
    public function actionIndex()
    {
        $phone = yii::app()->user->getState('msisdn');
        if (!$phone) {
            $this->redirect(Yii::app()->createUrl('/account/login'));
            Yii::app()->end();
        }
        $cri = new CDbCriteria;
        $cri->condition = " user_phone = $phone AND status=1";
        $user = WapUserSubscribeModel::model()->find($cri);
        if (!$user) {
            $userSub = '';
        } else {
            $userSub = $user;//WapUserSubscribeModel::model()->getUserSubscribe($phone);
        }
        $limit = Yii::app()->params ['pageSizeSmall'];
        $offset = 0;
        // bai hat yeu thich
        $favsong = WapSongModel::model()->getFavSong($phone, $limit, $offset);
        // video yeu thich
        $favvideo = WapVideoModel::model()->getFavVideo($phone, $limit, $offset);
        // album yeu thich
        $favalbum = WapAlbumModel::model()->getFavAlbum($phone, $limit, $offset);
        ;

        // tim kiem gan day
        $cris = new CDbCriteria ();
        $cris->condition = "user_phone = $phone";
        $cris->order = "search_datetime DESC";
        $cris->limit = 5;
        $recentSearchs = SearchLogsModel::model()->findAll($cris);
        $recentSearch = array();
        foreach ($recentSearchs as $search) {
            $recentSearch [] = $search->keyword;
        }
        $this->render('index', array(
            'userSub' => $userSub,
            'favsong' => $favsong,
            'favvideo' => $favvideo,
            'favalbum' => $favalbum,
            'recentSearch' => $recentSearch,
            'type' => "homepage"
        ));
    }

    /**
     * function actionPackage
     * call to render package info page
     */
    public function actionPackage()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl("/account/login"));
            return;
        }
        $phone = yii::app()->user->getState('msisdn');
        $packages = WapPackageModel::model()->findAllByAttributes(array('status' => 1));
        $this->render('package', array('packages' => $packages));

    }

    public function actionLogout()
    {
        if (!Yii::app()->user->isGuest) {
            Yii::app()->user->logout();
        }
        $this->redirect(Yii::app()->createUrl("/site"));
    }


    public function actionChangePackage()
    {
        $this->render('index', array(
            'action' => 'changePackage'
        ));
    }

    /**
     * function actionRegister
     * call to render register page
     */
    public function actionRegister()
    {
        $this->redirect(Yii::app()->createUrl('/account/package'));
    }

    /**
     * function actionDoRegister
     * call after user click to 'register' button of a package
     */
    public function actionDoRegister()
    {
        $phone = Yii::app()->user->getState('msisdn');
        $package_id = (int) Yii::app()->request->getParam('id');
        $confirm = (int) Yii::app()->request->getParam('confirm',0);
        $userPackage = UserSubscribeModel::model()->get($phone);
        if(empty($userPackage)) {
            if (!$this->is3g || Yii::app()->user->getState('userSub')->status == PackageModel::ACTIVE) {
                if ($confirm == 0) {
                    $code = rand(1000, 9999);
                    $verify = new UserVerifyModel();
                    $verify->user_id = 0;
                    $verify->created_time = new CDbExpression("NOW()");
                    $verify->msisdn = $phone;
                    $verify->verify_code = $code;
                    $verify->action = "register_package";
                    $verify->params = json_encode(array('msisdn' => $phone, 'package' => $package_id));
                    $ret = $verify->save();
                    $sendMsg = Yii::t('wap', Yii::app()->params['subscribe']['subscribe_otp'], array(':OTP'=>$code));
                    $smsClient = new SmsClient ();
                    $smsClient->sentSmsText($phone, $sendMsg);
                    $this->redirect(Yii::app()->createUrl('account/regConfirm', array('id' => $package_id)));
                } else {
                    $msg = $this->_register($phone, $package_id);
                    $this->render('registerMsg', array('msg' => $msg));
                }
            } else {
                if (isset($_GET['link'])) {
                    $requestData = $this->aes->decrypt("{$_GET['link']}");
                    $composition = explode('&', $requestData);
                    $transactionID = $composition[0];
                    $msisdnResponse = $composition[1];
                    $confirm = $composition[2];
                    $transactionVAS = VasGateModel::model()->findByAttributes(array('transaction_id' => $transactionID));
                    $package_id = $transactionVAS->package_id;
                    if ($confirm == 1) {
                        $msg = $this->_register($phone, $package_id, true);
                    } else {
                        $this->redirect(Yii::app()->createUrl('/site'));
                    }
                    $this->render('registerMsg', array('msg' => $msg));
                } else {
                    $check_promotion = UserSubscribeModel::model()->check_promotion($phone);
                    $pDetail = PackageModel::model()->findByPk($package_id);
                    $price = $pDetail->fee; 
					$packageCode = $pDetail->code;
                    
                    if ($check_promotion) {                    	
                        $price = 0;
                        if ($package_id == 1) {
                            $fee = ' 2000 đồng/1 ngày';
                        } else {
                            $fee = ' 7000 đồng/7 ngày';
                        }
						$fee .= "|| Khuyến mại 5 ngày";
                    } else {
                        if ($package_id == 1) {
                            $fee = '1 ngày';
                        } else {
                            $fee = '7 ngày';
                        }
                    }                   
                    //$fee = preg_replace('/([^a-z0-9 ])/ie', '"&#" . ord("$1") . ";"', $fee);
                    
                    $convmap = array(0x80, 0xffff, 0, 0xffff);
                    $fee = mb_encode_numericentity($fee, $convmap, 'UTF-8');
					$fee = str_replace("&#","##",$fee);
                    
                    $vasGate = new VasGateModel();
                    $vasGate->transaction_id = time() . $phone;
                    $vasGate->package_id = $pDetail->id;
                    $vasGate->information = $pDetail->code;
                    $vasGate->price = $price;
                    $vasGate->msisdn = $phone;
                    $vasGate->created_time = date("Y-m-d H:i:s");
                    if ($vasGate->save()) {
                        $urlGen = new UrlGenerator($this->spId, $vasGate->transaction_id, $packageCode, $price, 'http://amusic.vn/account/doRegister', $fee);
                        $url = $urlGen->generateUrl($this->aes);
                        $this->redirect($url);
                    }
                    $this->redirect('/');
                }
            }
        }else{
            if($userPackage->package_id == 1){
                $msg = Yii::app()->params['subscribe_msg']['duplicate_package_a1'];
            }else{
                $msg = Yii::app()->params['subscribe_msg']['duplicate_package_a7'];
            }
            $this->render('register_duplicate', compact('msg'));
        }

    }

    public function actionLogin()
    {
        if (!Yii::app()->user->isGuest) {
            if($this->layout == 'application.views.touch.layouts.main'){
                $this->redirect($this->createUrl("/account/view"));
            }else{
                $this->redirect($this->createUrl("/account/index"));
            }
            return;
        }
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
                        //LogDetectMsisdnModel::model()->logDetect(Formatter::formatPhone($_POST['LoginForm']['phone']), $_SERVER['REMOTE_ADDR'], 'F5', 'wap' , 1, "F5", NULL, NULL, $this->userSub->package_id, NULL, NULL, $_SERVER['REQUEST_URI']);
                        $back = Yii::app()->request->getParam('back', false);
                        if ($back) {
                            $this->redirect($back);
                        }
                        $this->redirect(Yii::app()->createUrl("/site"));
                    } else {
                        $errors = $model->getErrors();
                        foreach ($errors as $key => $err) {
                            $errorMsg .= "<div class='errormsg'>{$err[0]}</div>";
                        }
                    }
            }

        }
        $this->render('login', array(
            'model' => $model,
            'errorMsg' => $errorMsg,
            'errorMsg_Wap'=>$errorMsg_Wap
        ));
    }


    public function actionUnregConfirm()
    {
        try {
            $userPackage = UserSubscribeModel::model()->get(Yii::app()->user->getState('msisdn'));
            if (empty($userPackage)) {
                $this->redirect(Yii::app()->createUrl('/account/index'));
            }
            $packageId = Yii::app()->request->getParam('id');
            $package = PackageModel::model()->findByPk($packageId);
            if ($package) {
                if ($userPackage->package_id == $packageId) {
                    $msg = Yii::app()->params['confirm_unreg'];
                    $msg = Yii::t('wap', Yii::app()->params['confirm_unreg'], array("{:PACKAGE}" => $package->code, '{:DATE}' => date('H:i:s d/m/Y', strtotime($userPackage->expired_time))));
                    Yii::app()->user->setFlash('msg', $msg);
                } else {
                    $msg = 'Bạn chưa đăng ký gói cước này';
                    Yii::app()->user->setFlash('msg', $msg);
                }
            } else {
                $msg = 'Gói cước này không tồn tại';
                Yii::app()->user->setFlash('msg', $msg);
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->render('unregConfirm', compact('userPackage', 'package'));
    }


    public function actionregConfirm()
    {
        $phone = Yii::app()->user->getState('msisdn');
        $userPackage = UserSubscribeModel::model()->get($phone);
        $packageId = Yii::app()->request->getParam('id');
        $package = PackageModel::model()->findByPk($packageId);
        $error_msg = '';
        if (!$package) {
            $msg = 'Gói cước này không tồn tại';
            Yii::app()->user->setFlash('msg', $msg);
        }
        //
        $promotion = WapUserSubscribeModel::model()->checkPromotion($phone);
        if($promotion == 1){
            if($packageId == 2){
                $msg = 'Quý khách được MIỄN PHÍ 5 ngày nghe xem tải không giới hạn (sau KM, 7000đ/tuần). Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
            }else{
                $msg = 'Quý khách được MIỄN PHÍ 5 ngày nghe xem tải không giới hạn (sau KM, 2000đ/ngày). Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
            }
        }else{
            if($packageId == 2){
                $msg = 'Quý khách đang thực hiện đăng ký gói cước A7 trên dịch vụ Amusic. Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
            }else{
                $msg = 'Quý khách đang thực hiện đăng ký gói cước A1 trên dịch vụ Amusic. Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
            }
        }
        if(isset($_POST['otp'])){
            $otp = $_POST['otp'];
            $verify = UserVerifyModel::model()->findByAttributes(array(
                'msisdn' => $phone,
                'verify_code' => $otp,
                'action' => 'register_package'
            ));
            if($verify){
                $verify->delete();
                //dang ky
                $msg = $this->_register($phone, $packageId);
                $this->render('registerMsg', array('msg' => $msg));
                exit;
            }else{
                $error_msg = 'Mã xác thực không chính xác, vui lòng nhập lại.';
            }
        }
        $this->render('regConfirm', compact('userPackage', 'package','msg','error_msg'));
    }

    /**
     * function actionUnregisterPackage
     * call to render unsubscribe page
     */
    public function actionUnregisterPackage()
    {
        $phone = Yii::app()->user->getState('msisdn');
        $package_code = Yii::app()->request->getParam('package', '');
        if(!$this->is3g){
            $msg = $this->_unregister($phone, $package_code);
            $this->render('registerMsg', array('msg' => $msg));
        }else {
            if (isset($_GET['link'])) {
                $requestData = $this->aes->decrypt("{$_GET['link']}");
                $composition = explode('&', $requestData);
                $transactionID = $composition[0];
                $msisdnResponse = $composition[1];
                $confirm = $composition[2];
                $transactionVAS = VasGateModel::model()->findByAttributes(array('transaction_id' => $transactionID));
                $package_id = $transactionVAS->package_id;
                if ($confirm == 1) {
                    $msg = $this->_unregister($phone, $package_code);
                } else {
                    $this->redirect($this->createUrl("/site"));
                }
                $this->render('registerMsg', array('msg' => $msg));
            } else {
                $pDetail = PackageModel::model()->findbyAttributes(array('code'=>$package_code));
                $price = 0;
                $vasGate = new VasGateModel();
                $vasGate->transaction_id = time() . $phone;
                $vasGate->package_id = $pDetail->id;
                $vasGate->information = $pDetail->code;
                $vasGate->price = 0;
                $vasGate->msisdn = $phone;
                $vasGate->created_time = date("Y-m-d H:i:s");
                if ($vasGate->save()) {
					if($pDetail->code=="A1"){
						$info = " 2000 đồng/ngày";
					}else{
						$info = " 7000 đồng/ngày";
					}
					$convmap = array(0x80, 0xffff, 0, 0xffff);
                    $info = mb_encode_numericentity($info, $convmap, 'UTF-8');
					$info = str_replace("&#","##",$info);
					
                    $urlGen = new UrlGenerator($this->spId, $vasGate->transaction_id, $pDetail->code, $price, 'http://amusic.vn/account/unregisterPackage', $info);
                    $url = $urlGen->generateUrl($this->aes);
                    $this->redirect($url);
                }
                $this->redirect('/');
            }
        }
    }

    /*
         * Dang ky khi user click vao banner quang cao
         * */
    public function actionSubscribe()
    {
        /*if(!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] != 'msisdn.chacha.vn'){
            $this->redirect('/site/error404');
        }*/

        $userPhone = Yii::app()->user->getState('msisdn');
        $userSub = $this->userSub;//WapUserSubscribeModel::model()->findByAttributes(array('user_phone' => $userPhone, 'status' => UserSubscribeModel::ACTIVE));

        $confirm = Yii::app()->request->getParam('confirm', 0);
        $source = Yii::app()->request->getParam('source', 'buzzcity');
        $source = strtoupper($source);
        $result = null;
        $userObj = null;
        if ($confirm == 0) {
            $write = 1;
            if (isset($_SESSION[$source])) {
                // check time giua 2 lan visit co > 15 giay hay ko
                $latest_time = $_SESSION[$source];
                $now = date("Y-m-d H:i:s");
                $diff = strtotime($now) - strtotime($latest_time);
                if (intval($diff) < 15) {
                    $write = 0;
                }
            }
            if ($write == 1) {
                // log to table log_ads_click
                $log = new LogAdsClickModel;
                $ip = $_SERVER["REMOTE_ADDR"];
                $is3G = 0;
                if (Yii::app()->user->getState('is3G')) {
                    $is3G = 1;
                }
                $log->logAdsWap($userPhone, $source, $ip, $is3G);

                // set session value
                $_SESSION[$source] = date("Y-m-d H:i:s");
            }
        }
        $destUrl = Yii::app()->request->getParam('url', Yii::app()->homeUrl);
        //$destUrl = urldecode($destUrl);
        if ($userSub) {
            $this->redirect($destUrl);
        }
        $isPromotion = WapUserSubscribeModel::model()->checkPromotion($userPhone);
        if ($isPromotion) {
            $confirm = 1;
        }
        if ($confirm == 1) {
            try {
                $phone = $userPhone;
                if (!isset($phone) || !Formatter::isVinaphoneNumber($phone)) {
                    $result = new stdClass();
                    $result->errorCode = 401;
                    $result->message = WapUserSubscribeModel::model()->getCustomMetaData('3G_TEXT');

                } else {
                    //anti flood request
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    //time_nanosleep(0, 500000000);

                    $token = Yii::app()->request->csrfToken;
                    $ssid = session_id();
                    $sql = "INSERT INTO user_phone_subscribe_unduplicate(phone,ssid,token,created_time,status)
					VALUE('$userPhone','$ssid','$token',NOW(),0)
					";
                    $connDB = VegaCommonFunctions::getConnectMysql();
                    $res1 = mysql_query($sql);
                    mysql_close($connDB);
                    if ($res1) {
                        $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
                        $client = new SoapClient($bmUrl, array('trace' => 1));
                        $params = array(
                            'phone' => $userPhone,
                            'package' => 'CHACHAFUN',
                            'source' => 'wap',
                            'promotion' => '',
                            'bundle' => 0,
                            'smsId' => null,
                            'note_event' => $source,
                        );
                        $result = $client->__soapCall('userRegister', $params);

                        $timeClear = date('Y-m-d H:i:s', time() - 60 * 5);
                        $sql = "DELETE FROM user_phone_subscribe_unduplicate WHERE created_time<='$timeClear'";
                        $res2 = Yii::app()->db->createCommand($sql)->execute();
                    } else {
                        $log = new KLogger("SUBS_DUPLICATE_EXCEPTION", KLogger::INFO);
                        $log->LogInfo("Ex:" . $userPhone, false);
                        $this->redirect($destUrl);
                        exit;
                    }
                }
                if ($result->errorCode == 0 || $result->errorCode == '0') {
                    //$userObj = WapUserSubscribeModel::model()->findByAttributes(array('user_phone' => $userPhone));
                    if ($isPromotion) {
                        Yii::app()->user->setState('DK_MA_MSG', 'Quý khách có 7 ngày vàng trải nghiệm dịch vụ: Nghe, xem, tải MIỄN PHÍ toàn bộ nội dung và miễn cước data (3G/GPRS~30.000đ/ngày).Tặng kèm gói miễn phí tải nhạc chuông và quà tặng âm nhạc. Để từ chối nhận KM Quý khách soạn HUY CHACHA gửi 9234');
                    }
                    $this->redirect($destUrl);
                }
            } catch (Exception $e) {
                $log = new KLogger("SUBS_EXCEPTION", KLogger::INFO);
                $log->LogInfo("Ex:" . $e->getMessage(), false);
                //Yii::log($e->getMessage(), "error", "exeption.BMException");
                $this->redirect($destUrl);
                exit;
            }
        } else {
            $log = new KLogger("SUBS_NOT_PROMOTION", KLogger::INFO);
            $log->LogInfo($userPhone, false);
        }
        $this->renderPartial("subscribe_adv", array(
            'userObj' => $userObj,
            'result' => $result,
            'confirm' => $confirm,
            'source' => strtolower($source),
            'isPromotion' => $isPromotion,
            'destUrl' => $destUrl,
        ));

    }


    public function actionSuccessPopup()
    {
        $userPhone = Yii::app()->user->getState('msisdn');
        $userObj = WapUserSubscribeModel::model()->findByAttributes(array('user_phone' => $userPhone));
        $this->render('successPopup', array('userObj' => $userObj));
    }

    public function actionCreate()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl("/account"));
            return;
        }
        $error = array();
        $model = new UserForm ();
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $_POST ['UserForm'];
            if ($model->validate()) {
                $post = $_POST ['UserForm'];

                $ret = $model->updateUser();
                if ($ret) {
                    Yii::app()->session ['user_phone'] = Formatter::formatPhone($post ['phone']);
                    $this->redirect(Yii::app()->createUrl('/account/ActiveOtp', array(
                        'action' => 'register'
                    )));
                } else {
                    $error [] = Yii::t("wap", "Có lỗi xảy ra, vui lòng thử lại sau");;
                }
            } else {
                $error [] = Yii::t("wap", "Có lỗi xảy ra, vui lòng thử lại sau");;
            }
        }
        $this->render('create', compact('model', 'error'));
    }

    public function actionActiveOtp()
    {
        $error = "";
        $phone = Yii::app()->session ['user_phone'];
        if (empty ($phone)) {
            $phone = Yii::app()->request->getParam('phone', '');
            if (empty ($phone)) {
                $this->redirect($this->createUrl("/account/create"));
                return;
            }
        }
        $action = Yii::app()->request->getParam('action', '');
        if (Yii::app()->request->isPostRequest) {
            if ($action == 'register') {
                $phone = Formatter::formatPhone($phone);
                $otp = Yii::app()->request->getParam('otp');
                if ($otp == '') {
                    $error = Yii::t("wap", "Authentication code can't be blank");
                } else {
                    $verify = UserVerifyModel::model()->findByAttributes(array(
                        'msisdn' => $phone,
                        'verify_code' => $otp,
                        'action' => 'register'
                    ));
                    if (!empty ($verify)) {
                        $verify->delete();
                        // active user
                        $user = WapUserModel::model()->findByAttributes(array(
                            'phone' => $phone
                        ));
                        $user->status = WapUserModel::ACTIVE;
                        $ret = $user->save();
                        if ($ret) {
                            $this->redirect($this->createUrl("/account"));
                        } else {
                            $error = Yii::t("wap", "An error occurred. Please try again later.");
                        }
                    } else {
                        $error = Yii::t("wap", "Authentication code incorrect!");
                    }
                }
            } elseif ($action == 'updatepass') {
                $phone = Formatter::formatPhone($phone);
                $otp = Yii::app()->request->getParam('otp');
                $verify = UserVerifyModel::model()->findByAttributes(array(
                    'msisdn' => $phone,
                    'verify_code' => $otp,
                    'action' => 'updatepass'
                ));
                if (!empty ($verify)) {
                    $verify->delete();
                    // active user
                    $password = Common::randomPassword();
                    $user = WapUserModel::model()->findByAttributes(array(
                        'phone' => $phone
                    ));
                    $user->password = $password["encoderPass"];
                    $ret = $user->save();
                    if ($ret) {
                        // sent sms user
                        $sendMsg = Yii::t('wap', Yii::app()->params['subscribe']['reset_password'], array('{:PHONE}'=>$phone, '{:PASSWORD}'=>$password["realPass"]));
                        /*Yii::app()->params['']['reset_password']
                        $sendMsg = 'Ban dang thuc hien viec lay lai mat khai tren dich vu amusic, mat khau moi cua ban la: %s';
                        $sendMsg = sprintf($sendMsg, $password["realPass"]);*/
                        $smsClient = new SmsClient ();
                        $smsClient->sentSmsText($phone, $sendMsg);
                        $this->redirect($this->createUrl("/account"));
                    } else {
                        $error = Yii::t("wap", "An error occurred. Please try again later.");
                    }
                } else {
                    $error = Yii::t("wap", "Authentication code incorrect!");
                }
            }
        }
        $this->render('activeotp', compact('error', 'action'));
    }

    public function actionRepassword()
    {
        $error = "";
        $phone = Yii::app()->request->getParam('phone');
        if (Yii::app()->request->isPostRequest) {
            if (!empty ($phone)) {
                $phone = Formatter::formatPhone($phone);
                if (Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))) {
                    $user = WapUserModel::model()->findByPhone($phone);
                    if (!empty ($user)) {
                        // check 3 lan trong ngay
                        $action = "updatepass";
                        $check_otp = UserVerifyModel::model()->checkOtp($phone, $action);
                        if ($check_otp) {
                            // gửi ma otp xac thuc
                            $verify_code = rand(1000, 9999);
                            $userVerify = new UserVerifyModel ();
                            $userVerify->msisdn = $phone;
                            $userVerify->created_time = new CDbExpression ('NOW()');
                            $userVerify->verify_code = $verify_code;
                            $userVerify->action = $action;
                            $userVerify->save();
                            $sentMsg = Yii::t('wap', Yii::app()->params['subscribe']['success_otp_password'], array(":OTP" => $verify_code));
                            $smsClient = new SmsClient ();
                            $smsClient->sentSmsText($phone, $sentMsg);
                            Yii::app()->session ['user_phone'] = $phone;
                            $this->redirect(Yii::app()->createUrl("/account/activeOtp", array(
                                'action' => 'updatepass'
                            )));
                        } else {
                            $error = Yii::t("wap", "You only use this feature three times a day. Thank you very much.");
                        }
                    } else {
                        $error = Yii::t("wap", "Phone number not found");
                    }
                } else {
                    $error = Yii::t("wap", "Phone number incorrect!");
                }
            } else {
                $error = Yii::t("wap", "Please put your phone number");
            }
        }
        $this->render('repassword', compact('error'));
    }

    public function actionView()
    {
        $is_3g = $this->is3g;
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl("/account/login"));
            return;
        }
        $error = $error2 = $error_success =  "";
        //$user_id = Yii::app()->user->id;
        $phone = yii::app()->user->getState('msisdn');
        $user = UserModel::model()->findByAttributes(array('phone' => $phone));
        $user_id = $user->id;
        $cri = new CDbCriteria;
        $cri->condition = " user_phone = $phone AND status=1";
        $user_sub = WapUserSubscribeModel::model()->find($cri);
        $user_extra = UserExtraModel::model()->findbyPK($user->id);
        $forcus = "";
        if (Yii::app()->request->isPostRequest) {
            if (isset ($_POST ['Profile'])) {
                $error = '';
                $forcus = '';
                $error_code = 0;
                if(empty($_POST ['Profile']['username'])){
                    $error = Yii::t("wap", "Họ tên không được để trống");
                    $forcus = "username";
                    $error_code = 1;
                }
                $playlist_name = ucwords($_POST ['Profile']['username']);
                if(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $playlist_name)){
                    $error = Yii::t("wap", "Họ tên không được chứa ký tự đặc biệt");
                    $forcus = "username";
                    $error_code = 1;
                }
                if((!empty($_POST ['Profile'] ['email']))&&  !EmailHelper::isEmailAddress($_POST ['Profile'] ['email'])){
                    $error = Yii::t("wap", "Email incorrect");
                    $forcus = "email";
                    $error_code = 1;
                }
                $birthday = implode('-', array_reverse(explode('/', $_POST ['Profile_birthday'])));
                $date = DateTime::createFromFormat("Y-m-d", $birthday);
                if (!$date && !empty($_POST ['Profile_birthday'])) {
                    $error = Yii::t("wap", "Date of birth incorrect!");
                    $forcus = "birthday";
                    $error_code = 1;
                }
                if($error_code==0){
                    if(empty($user)){
                        $password = Common::randomPassword(6);
                        $user = new UserModel();
                        $user->username = $_POST ['Profile'] ['username'];
                        $user->password = $password["encoderPass"];
                        $user->fullname = Yii::app()->user->getState('msisdn');
                        $user->phone = Yii::app()->user->getState('msisdn');
                        $user->gender = 0;
                        $user->status = UserModel::ACTIVE;
                        $user->validate_phone = 1;
                        $user->created_time = date('Y-m-d H:i:s');
                        $user->updated_time= date('Y-m-d H:i:s');
                        $user->email = $_POST ['Profile'] ['email'];
                        $user->address = $_POST ['Profile'] ['address'];
                        $user->gender = (int)$_POST ['Profile'] ['genre'];
                        $ret = $user->save();
                    }else{
                        $user->username = $_POST ['Profile'] ['username'];
                        $user->email = $_POST ['Profile'] ['email'];
                        $user->address = $_POST ['Profile'] ['address'];
                        $user->gender = (int)$_POST ['Profile'] ['genre'];
                        $ret = $user->save();
                    }
                    if ($ret) {
                            if (!empty ($user_extra)) {
                                $user_extra->birthday = !empty($birthday) ? $birthday : new CDbExpression('NULL');
                                $user_extra->save();
                            } else {
                                $user_extra = new UserExtraModel ();
                                $user_extra->user_id = $user_id;
                                $user_extra->birthday = !empty($birthday) ? $birthday : new CDbExpression('NULL');
                                $user_extra->save();
                            }

                        $error_success = "Cập nhật thành công";
                    } else {
                        $error = Yii::t("wap", "An error occurred. Please try again later.");
                    }
                }

            }

            if (isset ($_POST ['Profile2'])) {
                $post = $_POST ['Profile2'];
                if (empty($post ['password'])) {
                    $error2 = Yii::t("wap", "Please input old password");
                    $forcus = "password";
                } elseif ($user ['password'] == Common::endcoderPassword($post ['password'])) {
                    if (empty($post ['password_new'])) {
                        $error2 = Yii::t("wap", "Please input new password");
                    } elseif ($post ['password_new'] == $post ['password_new_retype']) {
                        $lengPassword = strlen($post ['password_new']);
                        if ($lengPassword < 6) {
                            $error2 = Yii::t("wap", "Password required more than 6 characters!");
                            $forcus = "password";
                        } else {
                            $user->password = Common::endcoderPassword($post ['password_new']);
                            $ret = $user->save();
                            if ($ret) {
                                Yii::app()->user->setFlash('change_pass_status', Yii::t("wap", "Your password was successfully changed"));
                                $this->redirect($this->createUrl("/account/view"));
                            } else {
                                $error2 = Yii::t("wap", "An error occurred. Please try again later.");
                            }
                        }
                    } else {
                        $error2 = Yii::t("wap", "Repassword not match");
                        $forcus = "password_new_retype";
                    }
                } else {
                    $error2 = Yii::t("wap", "Old password not match");
                    $forcus = "password_new";
                }
            }
        }

        $this->render('view', compact('user', 'user_sub', 'user_extra', 'error', 'error2', 'forcus','error_success','is_3g'));
    }

    private function _register($phone, $package_id, $is_vas = false){
        try {
            if (!isset($phone)) {
                $this->redirect(Yii::app()->createUrl('account/login', array('back' => Yii::app()->createUrl('/account/package'))));
            }
            $package = PackageModel::model()->findByPk($package_id);
            $packageCode = $package->code;
            if (isset(Yii::app()->session['source']) && !empty(Yii::app()->session['source'])) {
                $source = Yii::app()->session['source'];
            } else {
                $source = '';
            }
            if($is_vas){
                $source = $source . '|VASGATE';
            }
            $res1 = true;
            if ($res1) {
                $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
                $client = new SoapClient($bmUrl, array('trace' => 1));
                $params = array(
                    'phone' => yii::app()->user->getState('msisdn'),
                    'package' => $packageCode,
                    'source' => 'wap',
                    'promotion' => 0,
                    'bundle' => 0,
                    'smsId' => null,
                    'note_event' => $source,
                );
                $result = $client->__soapCall('userRegister', $params);
            } else {
                $this->redirect(Yii::app()->createUrl("account/index"));
                exit();
            }
            $return_msg = false;
            if (strrpos(strtolower($result->message), "success") !== false) {
                $return_msg = true;
            }
            $smswap = array(
                'success_am' => 'success_msg_am',
                'success_km_am' => 'success_msg_km_am',
                'success_am7' => 'success_msg_am7',
                'success_km_am7' => 'success_msg_km_am7'
            );
            if (array_key_exists($result->message, $smswap)) {
                $result->message = $smswap[$result->message];
            }

            if ($return_msg || $result->message == 'success_a1' || $result->message == 'success_a7') { // success
                //display success page
                $msg = Yii::app()->params['subscribe_msg'][$result->message];
                $userSub = UserSubscribeModel::model()->get(yii::app()->user->getState('msisdn'));
                Yii::app()->user->setState('userSub', $userSub);
                /*Yii::app()->user->setFlash('msg', $msg);
                $this->redirect(Yii::app()->createUrl("account/index", array('reloadPackage' => 1)));*/
            } else {
                //display error page
                if (isset(Yii::app()->params['subscribe_msg'][$result->message])) {
                    $msg = Yii::app()->params['subscribe_msg'][$result->message];
                    if (strpos($msg, ':EXPIRED') !== false) {
                        $userSub = $this->userSub;//WapUserSubscribeModel::model()->getUserSubscribe(yii::app()->user->getState('msisdn'));
                        $msg = Yii::t('wap', Yii::app()->params['subcsriber_wap'][$result->message], array(':EXPIRED' => date("H:i:s d/m/Y", strtotime($userSub->expired_time))));
                    }
                } else {
                    $msg = Yii::app()->params['subscribe_msg']['default'];
                }
                Yii::app()->user->setFlash('msg', $msg);
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage(), "error", "exeption.BMException");
            //$msg = $e->getMessage();
            $msg = 'Có lỗi xảy ra, quý khách vui lòng thử lại sau.';
        }
        return $msg;
    }

    private function _unregister($phone, $package){
//        try {
            $packageCode = ($package) ? $package : Yii::app()->user->getState('package');
            $packageCode = trim($packageCode);
            if (isset(Yii::app()->session['source']) && !empty(Yii::app()->session['source'])) {
                $source = Yii::app()->session['source'];
            } else {
                $source = '';
            }
            $params = array(
                'user_id' => 0,
                'user_phone' => $phone,
                'package' => $packageCode, //tam thoi fix ma goi cuoc o day
                'source' => 'wap',
            );
            $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
            $client = new SoapClient($bmUrl, array('trace' => 1));
            $result = $client->__soapCall('userUnRegister', $params);
            if ($result->errorCode == 0) { // success
                //display success page
                $msg = $result->message . '_msg';
//                $msg = Yii::app()->params['unsubscribe'][$msg];
                $msg = Yii::app()->params['unsubscribe_msg'][$msg];
                /*Yii::app()->user->setFlash('msg', $msg);
                $this->redirect(Yii::app()->createUrl('/account/index'));*/
            } else {
                //display error page
                if (isset(Yii::app()->params['unsubscribe_msg'][$result->message])) {
                    $msg = Yii::app()->params['unsubscribe_msg'][$result->message];
                } else {
                    $msg = Yii::app()->params['unsubscribe_msg']['default'];
                }
            }
       /* } catch (Exception $e) {
            Yii::log($e->getMessage(), "error", "exception.BMException");
            $msg = $e->getMessage();
        }*/
        return $msg;
    }

    /**
     * bai hat yeu thich
     */
    public function actionFavSong() {
        $phone = yii::app()->user->getState('msisdn');

        $cri = new CDbCriteria ();
        $cri->condition = " phone = $phone";
        $user = UserModel::model()->find($cri);
        $uid = $user->id;

        $limit = Yii::app()->params ['pageSize'];
        $pageSize = Yii::app()->params ['pageSize'];
        $page = Yii::app()->request->getParam('page', 1);
        $offset = ($page - 1) * $limit;

        $countSong = WapSongModel::model()->countFavSong($uid);
        $songPages = new CPagination($countSong);
        $songPages->setPageSize($pageSize);

        $favsong = WapSongModel::model()->getFavSong($phone, $limit, $offset);

        $headerText = Yii::t('chachawap', 'Bài hát yêu thích');
        $link = Yii::app()->createUrl("/account/favsong");
        $this->render('songlist', array(
            'songs' => $favsong,
            'link' => $link,
            'type' => "list",
            'headerText' => $headerText,
            'songPages' => $songPages
        ));
    }

    /**
     * Video yeu thich
     */
    public function actionFavVideo() {
        $phone = yii::app()->user->getState('msisdn');

        $cri = new CDbCriteria ();
        $cri->condition = " phone = $phone";
        $user = UserModel::model()->find($cri);
        $uid = $user->id;

        $limit = Yii::app()->params ['pageSize'];
        $pageSize = Yii::app()->params ['pageSize'];
        $page = Yii::app()->request->getParam('page', 1);
        $offset = ($page - 1) * $limit;

        $countVideo = WapVideoModel::model()->countFavVideo($uid);
        $videoPages = new CPagination($countVideo);
        $videoPages->setPageSize($pageSize);

        $favvideo = WapVideoModel::model()->getFavVideo($phone, $limit, $offset);

        $headerText = Yii::t('chachawap', 'Video yêu thích');
        $link = $link = Yii::app()->createUrl("/account/favvideo");
        $this->render('videolist', array(
            'videos' => $favvideo,
            'link' => $link,
            'type' => "list",
            'headerText' => $headerText,
            'videoPages' => $videoPages
        ));
    }

    /**
     * bai hat yeu thich
     */
    public function actionFavAlbum() {
        $phone = yii::app()->user->getState('msisdn');

        $cri = new CDbCriteria ();
        $cri->condition = " phone = $phone";
        $user = UserModel::model()->find($cri);
        $uid = $user->id;

        $limit = Yii::app()->params ['pageSize'];
        $pageSize = Yii::app()->params ['pageSize'];
        $page = Yii::app()->request->getParam('page', 1);
        $offset = ($page - 1) * $limit;

        $countAlbum = WapAlbumModel::model()->countFavAlbum($uid);
        $albumPages = new CPagination($countAlbum);
        $albumPages->setPageSize($pageSize);

        $favalbum = WapAlbumModel::model()->getFavAlbum($phone, $limit, $offset);

        $headerText = Yii::t('chachawap', 'Album yêu thích');
        $link = $link = Yii::app()->createUrl("/account/favalbum");
        $this->render('albumlist', array(
            'albums' => $favalbum,
            'link' => $link,
            'type' => "list",
            'headerText' => $headerText,
            'albumPages' => $albumPages
        ));
    }
    function ascii_to_dec($str)
    {
        for ($i = 0, $j = strlen($str); $i < $j; $i++) {
            $dec_array[] = ord($str{$i});
        }
        return $dec_array;
    }

    public function actionConfirmRegister(){
        $msisdn = Yii::app()->user->getState('msisdn');
        $package_id = 1;
        $code = rand(1000,9999);
        $verify = new UserVerifyModel();
        $verify->user_id = 0;
        $verify->created_time = new CDbExpression("NOW()");
        $verify->msisdn = $msisdn;
        $verify->verify_code = $code;
        $verify->action = "register_package";
        $verify->params = json_encode(array('msisdn'=>$msisdn,'package'=>$package_id));
        $ret = $verify->save();
        if($ret){
            $sendMsg = Yii::t('wap', Yii::app()->params['subscribe']['subscribe_otp'], array(':OTP'=>$code));
            $smsClient = new SmsClient ();
            $smsClient->sentSmsText($msisdn, $sendMsg);
            $result['error'] = 0;
            $promotion = UserSubscribeModel::model()->checkPromotion($msisdn);
            if($promotion == 1){
                if($package_id == 2){
                    $msg = 'Quý khách được MIỄN PHÍ 5 ngày nghe xem tải không giới hạn (sau KM, 7000đ/tuần). Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
                }else{
                    $msg = 'Quý khách được MIỄN PHÍ 5 ngày nghe xem tải không giới hạn (sau KM, 2000đ/ngày). Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
                }
            }else{
                if($package_id == 2){
                    $msg = 'Quý khách đang thực hiện đăng ký gói cước A7 trên dịch vụ Amusic. Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
                }else{
                    $msg = 'Quý khách đang thực hiện đăng ký gói cước A1 trên dịch vụ Amusic. Mã xác thực đã được gửi về điện thoại của Quý khách. Xin vui lòng nhập mã OTP để đăng ký dịch vụ.';
                }
            }
        }else{
            $msg = 'Có lỗi xảy ra, vui lòng thử lại sau!';
        }
        $this->render('confirm_register',compact('msg'));
    }

    public function actionLanding(){
        $package_id = (int) Yii::app()->request->getParam('id');
        $phone = Yii::app()->user->getState('msisdn');
        $phone = Formatter::formatPhone($phone);
        //check xem đã đk chưa
        $check_user_sub = UserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone,'status'=>UserSubscribeModel::ACTIVE));
        if(empty($check_user_sub)){
            if (isset($_GET['link'])) {
                $requestData = $this->aes->decrypt("{$_GET['link']}");
                $composition = explode('&', $requestData);
                $transactionID = $composition[0];
                $msisdnResponse = $composition[1];
                $confirm = $composition[2];
                $transactionVAS = VasGateModel::model()->findByAttributes(array('transaction_id' => $transactionID));
                $package_id = $transactionVAS->package_id;
                if ($confirm == 1) {
                    $msg = $this->_register($phone, $package_id,true);
                }
            } else {
                $check_promotion = UserSubscribeModel::model()->check_promotion($phone);
                $pDetail = PackageModel::model()->findByPk($package_id);
                $price = $pDetail->fee;
                $packageCode = $pDetail->code;

                if ($check_promotion) {
                    $price = 0;
                    if ($package_id == 1) {
                        $fee = ' 2000 đồng/1 ngày';
                    } else {
                        $fee = ' 7000 đồng/7 ngày';
                    }
                    $fee .= "|| Khuyến mại 5 ngày";
                } else {
                    if ($package_id == 1) {
                        $fee = '1 ngày';
                    } else {
                        $fee = '7 ngày';
                    }
                }
                $convmap = array(0x80, 0xffff, 0, 0xffff);
                $fee = mb_encode_numericentity($fee, $convmap, 'UTF-8');
                $fee = str_replace("&#","##",$fee);
                $vasGate = new VasGateModel();
                $vasGate->transaction_id = time() . $phone;
                $vasGate->package_id = $pDetail->id;
                $vasGate->information = $pDetail->code;
                $vasGate->price = $price;
                $vasGate->msisdn = $phone;
                $vasGate->created_time = date("Y-m-d H:i:s");
                if ($vasGate->save()) {
                    $urlGen = new UrlGenerator($this->spId, $vasGate->transaction_id, $packageCode, $price, 'http://amusic.vn/account/landing', $fee);
                    $url = $urlGen->generateUrl($this->aes);
                    $this->redirect($url);
                }
            }
        }
        $this->redirect(Yii::app()->createUrl('/site'));
    }

    public function actionVasRegister(){
        $package_id = Yii::app()->request->getParam('package');
        $phone = yii::app()->user->getState('msisdn');
        $back_link = Yii::app()->request->getParam('back_link','');
        if($back_link != ''){
            Yii::app()->session['back_link'] = $back_link;
        }
        if(isset($_GET['link'])) {

            $requestData = $this->aes->decrypt("{$_GET['link']}");
            $composition = explode('&', $requestData);
            $transactionID = $composition[0];
            $msisdnResponse = $composition[1];
            $confirm = $composition[2];
            $transactionVAS = VasGateModel::model()->findByAttributes(array('transaction_id'=>$transactionID));
            $package_id = $transactionVAS->package_id;
            if ($confirm == 1) {
                if(Formatter::formatPhone($phone) == Formatter::formatPhone($msisdnResponse)){
                    $this->_register($phone, $package_id, true);
                    $this->redirect(Yii::app()->session['back_link']);
                }

            }else{
                $this->redirect ( $this->createUrl ( "/site" ) );
            }
        }else{
            $check_promotion = $this->check_promotion($phone);
            $pDetail = PackageModel::model()->findByPk($package_id);
            $price = $pDetail->fee;
            $packageCode = $pDetail->code;
            /*if($check_promotion){
                $price = 0;
            }*/
            if ($check_promotion) {
                $price = 0;
                if ($package_id == 1) {
                    $fee = ' 2000 đồng/1 ngày';
                } else {
                    $fee = ' 7000 đồng/7 ngày';
                }
                $fee .= "|| Khuyến mại 5 ngày";
            } else {
                if ($package_id == 1) {
                    $fee = '1 ngày';
                } else {
                    $fee = '7 ngày';
                }
            }
            $convmap = array(0x80, 0xffff, 0, 0xffff);
            $fee = mb_encode_numericentity($fee, $convmap, 'UTF-8');
            $fee = str_replace("&#","##",$fee);
            $vasGate = new VasGateModel();
            $vasGate->transaction_id = time().$phone;
            $vasGate->package_id = $pDetail->id;
            $vasGate->information = $pDetail->code;
            $vasGate->price = $price;
            if($vasGate->save()) {
                $urlGen = new UrlGenerator($this->spId, $vasGate->transaction_id, $packageCode, $price, 'http://amusic.vn/account/vasRegister', $fee);
                $url = $urlGen->generateUrl($this->aes);
                $this->redirect($url);
            }
            $this->redirect('/');
        }
    }
    private function check_promotion($phone) {
        $sql = "SELECT *
	        	FROM user_subscribe_km
	        	WHERE phone = '{$phone}'
        		AND (type = 0 OR (type = 1 AND created_time >= date_sub(NOW(), interval 2160 hour)))
        		";

        $subscribe = Yii::app()->db->createCommand($sql)->queryAll();
        if (!empty($subscribe)) {
            return false;
        }
        return true;
    }

}
