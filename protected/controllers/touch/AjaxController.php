<?php
class AjaxController extends CController{
	public function init(){
		if(!Yii::app()->request->isAjaxRequest){
			//die('Your request is not valid!');
		}
		//load config streaming
		if(!$this->isRequestFromVina()){
			$localConfig = require(Yii::getPathOfAlias('application.config').'/local.php');
			Yii::app()->params['storage'] = $localConfig['params']['storage'];
		}
		$this->layout=false;
	}
	public function actionSetCookies()
	{
		$type = Yii::app()->request->getParam('type');
		$day = Yii::app()->request->getParam('day',1);
		if($type=='popup_km'){
			$_SESSION['already_popupkm'] = 1;
			$cookie = new CHttpCookie('showPopupKm', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopupKm'] = $cookie;
			}elseif($type=='popup_not_km'){
			$_SESSION['already_popup'] = 1;
			$cookie = new CHttpCookie('showPopup', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopup'] = $cookie;
		}elseif($type=='popup_ctkm'){
			$_SESSION['already_popup_ctkm'] = 1;
			$cookie = new CHttpCookie('showPopupCTKm', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopupCTKm'] = $cookie;
		}
	}
	public function actionGetPopup()
	{
		$this->layout=false;
		$view = 'default';
		$type=Yii::app()->request->getParam('type', 'genre');
		$route=Yii::app()->request->getParam('route', '/song/list');
		$name = CHtml::encode(Yii::app()->request->getParam('name',Yii::t('wap','Tất cả thể loại')));

		if($type=='genre'){
			$genres = MainActiveRecord::getGenre();
			$genresAll = WapGenreModel::model()->cache(1000,null)->findAll('status=1');
			$genreRoot = array();
			foreach ($genresAll as $key => $value){
				if($value->parent_id==0)
					$genreRoot[] = $value;
			}
			$view = 'genre';
			$params = array(
					'genreRoot' => 	$genreRoot,
					'genresAll' => 	$genresAll,
					'genres'    => $genres,
					'route'     =>$route
			);
		}elseif($type=='status'){
			$view = 'status';
			$c = Yii::app()->request->getParam('c', 0);
			$params = array(
					'route'		=>	$route,
					'c'			=>	$c,
					'name'		=> $name
			);
		}elseif($type=='bxh'){
			$view = 'bxh';
			$c = Yii::app()->request->getParam('c', 0);
			$s = Yii::app()->request->getParam('s', 'Bài hát');
			$params = array(
					'route'		=>	$route,
                                        'c'			=>	$c,
                                        's'			=>	$s
			);
		}elseif($type=='bxh_status'){
			$view = 'bxh_status';
			$c = Yii::app()->request->getParam('c', 0);
			$s = Yii::app()->request->getParam('s', 'Mới');
			$params = array(
					'route'		=>	$route,
					'c'			=>	$c,
					's'			=>	$s
			);
		}
		$this->render($view, $params);
	}
	public function actionGetPopupFilterSearch()
	{
		$keyword=Yii::app()->request->getParam('keyword','');
		$this->render('filter_search', array(
				'keyword'=>$keyword
		));
	}
	public function actionGetPopupPlaylist()
	{
		$this->layout=false;
		$phone = Yii::app()->request->getParam('phone','');
		$songId = Yii::app()->request->getParam('song_id',0);
		$playlist = array();
		/* if(!empty($phone))
			$playlist = WapPlaylistModel::model()->getPlaylistByPhone($phone); */
		
		$user = UserModel::model()->find("phone=".$phone);
		if($user){
			$userId = $user->id;
			$playlist = WapPlaylistModel::model()->getPlaylistByUser($userId,$phone,100,0);
		}else{
			$userId = null;
			$playlist = WapPlaylistModel::model()->getPlaylistByPhone($phone,100,0);
		}
		
		$this->render('playlist', array(
				'playlist'=> $playlist,
				'songId'=>$songId,
				'phone'=>$phone
		));

	}
	public function actionGetPopupRbt()
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/player.css');
		$rbtId = Yii::app()->request->getParam('rbt_id','');
		$rbt = WapRbtModel::model()->findByPk($rbtId);

		$mp3Url = RbtModel::model()->getAudioFileUrl($rbtId);

		//$mp3Url ='http://audio1.imuzik.com.vn/imuzik2013/media1/songs/web_128/0/0/54/221338.mp3';
		$this->render('rbt_setup', array(
				'mp3Url'=>$mp3Url,
				'rbtCode'=>$rbt->code,
				'rbtName'=>$rbt->name,
				'rbtPrice'=>$rbt->price,
		));
	}
	
	public function actionLimitPlayWifi()
	{
		$this->render("limitPlayWifi");
	}
	
	public function actionLogPlayWifi()
	{
		$type = Yii::app()->request->getParam('type');
		$id = Yii::app()->request->getParam('id'); 
		
		$params = array(
				'content_id'=>$id,
				'type'=>$type,
		);
		FreeContentOnDayModel::model()->add($params);
		echo "success";
		Yii::app()->end();
	}
	
	public function actionCheckPlayWifi()
	{
		$ret = new stdClass();
		$count_free_in_day = FreeContentOnDayModel::model()->Check_Free_On_Day();
		if($count_free_in_day >= 5){
			$ret->error = 1;
			$ret->count = $count_free_in_day;
			$ret->message = "Thiết bị đã nghe xem $count_free_in_day nội dung trong ngày";
			
		}else{
			$ret->error = 0;
			$ret->count = $count_free_in_day;
			$ret->message = "Success";
		}
		header("Content-type: application/json");
		echo json_encode($ret);
		Yii::app()->end();
	}
	
	public function actionConfirmDownload()
	{
		$type = Yii::app()->request->getParam('type','song');
		$id = Yii::app()->request->getParam('id',null);
		$code = Yii::app()->request->getParam('code',null);
		$nosub = Yii::app()->request->getParam('nosub',0);
		
		if($type=="song"){
			$obj = SongModel::model()->findByPk($id);
		}else{
			$obj = VideoModel::model()->findByPk($id);
		}
		
		
		$this->render("confirmDownload",compact("obj","type","id","code","nosub"));
	}
	
	public function actionCheckPlayNoSub()
	{
		$ret = new stdClass();
		$userPhone = Yii::app()->user->getState('msisdn');
		$userPhone = Formatter::formatPhone($userPhone);
		$countPlayInDay = UserTransactionModel::model()->getNumTransContentPlay($userPhone);
		$count_free_in_day = FreeContentOnDayModel::model()->Check_Free_On_Day(); // Nghe wifi
		$total_play = ($countPlayInDay+$count_free_in_day);
		
		if($total_play >= 5){
			$ret->error = 1;
			$ret->count = $total_play;
			$ret->message = "Thiết bị đã nghe xem $total_play nội dung trong ngày";
		}else{
			$ret->error = 0;
			$ret->count = $total_play;
			$ret->message = "Success";
		}
		header("Content-type: application/json");
		echo json_encode($ret);
		Yii::app()->end();
	}
	
	public function actionGetContentPrice()
	{
		$id = Yii::app()->request->getParam('id');
		$action = Yii::app()->request->getParam('action','play_song');
		$phone = Yii::app()->user->getState('msisdn');
		$phone = Formatter::formatPhone($phone);
		$checkCharg24h = WapUserTransactionModel::model()->checkCharging24h($phone, $phone, $id, $action);
		$error = 99;
		$chargPrice = -1;
		if ($checkCharg24h) {
			$chargPrice = 0;
			$error = 0;
		}else{
			switch ($action){
				case "play_song":
					$obj = SongModel::model()->findByPk($id);
					if(!empty($obj)){
                                            	$chargPrice = Yii::app()->params['promotion.song.play.unsub'];
						//$chargPrice = $obj->listen_price;
						$error = 0;
					}
					break;
				case "download_song":
					$obj = SongModel::model()->findByPk($id);
					if(!empty($obj)){
						$chargPrice = Yii::app()->params['promotion.song.download.unsub'];
						$error = 0;
					}
					break;
				case "play_video":
					$obj = VideoModel::model()->findByPk($id);
					if(!empty($obj)){
						$chargPrice = Yii::app()->params['promotion.video.play.unsub'];
						$error = 0;
					}
					break;
				case "download_video":
					$obj = VideoModel::model()->findByPk($id);
					if(!empty($obj)){
						$chargPrice = Yii::app()->params['promotion.video.download.unsub'];
						$error = 0;
					}
					break;
			}
		}
		
		$return = new stdClass();
		$return->errorCode = $error;
		$return->message = "";
		$return->data = array("price"=>$chargPrice);
		
		header("Content-type: application/json");
		echo json_encode($return);
		Yii::app()->end();
		
		
	}
	
	private function isRequestFromVina() {
		// F5: 10.x.y.z
		$F5IPPattern = "/^10(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/";
		// WAPGW: 172.16.30.[11-12], 113.185.0.16
		$WAPGWIPPattern = "/^(172\.16\.30\.1[1-2]|113\.185\.0\.16)$/";
		// Dai ip 113.185.[1-31].0/24 thuoc F5
		$OtherIpPattern = "/^113\.185\.([1-9]|1[0-9]|2[0-9]|3[0-1])\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/";
		$remoteIp = rtrim(ltrim($_SERVER['REMOTE_ADDR']));
		if(preg_match($WAPGWIPPattern, $remoteIp) || preg_match($F5IPPattern, $remoteIp) || preg_match($OtherIpPattern, $remoteIp)) {
			return true;
		}
		return false;
	}

	public function actionLimit(){
		$session = isset(Yii::app()->session['free'])? Yii::app()->session['free'] : 0;
		Yii::app()->session['free']  = Yii::app()->session['free'] + 1;
		header("Content-type: application/json");
		echo json_encode($session);
		Yii::app()->end();
	}
	
	public function actionDownloadRbt()
	{
		$flag = true;
		$userPhone = false;
		if(!Yii::app()->user->isGuest){
			$userPhone = Yii::app()->user->getState('msisdn');
		}
		
		if (Yii::app ()->getRequest ()->ispostRequest && isset($_POST['rbt_code'])) {
			$flag = false;
			$toPhone = Yii::app()->request->getParam('to_phone');
			$code = Yii::app()->request->getParam('rbt_code');
			$result = new stdClass();
			if(!Formatter::isMobiPhoneNumber($userPhone)){
				$result->errorCode = 1;
				$result->message = "Chức năng nhạc chờ chỉ áp dụng cho các tài khoản là thuê bao Mobifone";
				echo json_encode($result);
				Yii::app()->end();
			}
			if(!Formatter::isMobiPhoneNumber($toPhone)){
				$result->errorCode = 1;
				$result->message = "Số điện thoại người nhận không phải là thuê bao Mobifone";
				echo json_encode($result);
				Yii::app()->end();
			}
		
			$flagCRBT = false;
			$msisdn = Formatter::removePrefixPhone($userPhone);
			$msisdn = substr($msisdn,1);
			$funringStatus = FunringHelper::getInstance()->checkStatus($msisdn);
				
			if($funringStatus==-1){
				$result->errorCode = -1;
				$result->message = "Không kết nối được đến hệ thống CRBT";
				echo json_encode($result);
				Yii::app()->end();
			}
				
			if($funringStatus==4){
				// Chua dang ky => thuc hien dang ky cho TB
				$retRegister = FunringHelper::getInstance()->register($msisdn);
				if($retRegister!=0){
					$result->errorCode = -1;
					$result->message = "Không kết nối được đến hệ thống CRBT";
					echo json_encode($result);
					Yii::app()->end();
				}
			}
				
			if($userPhone==$toPhone){
				$ret =  FunringHelper::getInstance()->orderTone($msisdn, $code);
				if($ret==0){
					$error = "Bạn đã tải nhạc chờ thành công!";					
				}else{
					$error = "Bạn tải nhạc chờ chưa thành công. Vui lòng kiểm tra và thao tác lại.";
				}
			}else{
				$toPhone = Formatter::removePrefixPhone($toPhone);
				$toPhone = substr($toPhone,1);
				
				$ret =  FunringHelper::getInstance()->giftTone($msisdn, $code, $toPhone);
				if($ret==0){
					$error = "Bạn đã tặng nhạc chờ thành công cho số thuê bao 0{$toPhone}.";					
				}else{
					$error = "Bạn tặng nhạc chờ cho số thuê bao 0{$toPhone} chưa thành công. Vui lòng kiểm tra và thao tác lại.";
				}
			}
		
			$result->errorCode = $ret;
			$result->message = $error;
			echo json_encode($result);
		}
		
		if ($flag) {
			$rbts = array();
			$id = Yii::app()->request->getParam('id');
			$song = SongModel::model()->findByPk($id);
			if($song->rbt_codes!=""){
				$code = explode(",", trim($song->rbt_codes));
				$rbts = RbtModel::model()->getByCodes($code);
			}
		
			$this->renderPartial ( '_popupRbt', compact("song","rbts","userPhone"), false, true );
		}		
	}
	public function actionIsAuthenticate()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$fa = Yii::app()->request->getParam('fa');
			$urlReturn = Yii::app()->request->getParam('url_return');
			if(!empty($fa)){
				Yii::app()->user->setState('last_action',$fa);
			}
			if(!empty($urlReturn)){
				Yii::app()->user->setState('last_url',$urlReturn);
			}
			$result = array();
			if(Yii::app()->user->isGuest){
				$result['errorCode'] = 1;
			}else {
				$result['errorCode'] = 0;
			}
			$result['msg'] = '';
			echo CJSON::encode($result);
		}
	}

	public function actionLimitCtkm(){
		$userPhone = Yii::app()->user->getState('msisdn');
		$userPhone = Formatter::formatPhone($userPhone);
        $user_sub = UserSubscribeModel::model()->get($userPhone);
        if(!$user_sub) {
            $promotion = 0;
            $check_promotion = UserSubscribeModel::model()->check_promotion($userPhone);
            if ($check_promotion) {
                $promotion = 1;
            }
            $session = isset(Yii::app()->session['free_ctkm']) ? Yii::app()->session['free_ctkm'] : 1;
            Yii::app()->session['free_ctkm'] = Yii::app()->session['free_ctkm'] + 1;
            $data = array(
                'session' => $session,
                'promotion' => $promotion,
            );
            header("Content-type: application/json");
            echo json_encode($data);
        }else{
                echo json_encode(new stdClass());
            }
            Yii::app()->end();

	}

	public function actionLogAlbum() {
		$id = Yii::app()->request->getParam('id');
		$album = AlbumModel::model()->findByPk($id);
		if(!Yii::app()->user->isGuest){
			$activity = new UserActivityModel();
			$activity->channel='wap';
			$activity->user_id = Yii::app()->user->getId();
			$activity->user_phone = Yii::app()->user->getState('phone');
			$activity->loged_time = date('Y-m-d H:i:s');
			$activity->activity = 'play_album';
			$activity->obj1_id=$album->id;
			$activity->obj1_name=$album->name;
			$activity->obj1_url_key=$album->url_key;
			$activity->obj2_id=$album->artist_id;
			$activity->obj2_name=$album->artist_name;
			$ret= $activity->save();
			if ($ret) {
				echo "1";
			} else {
				echo CHtml::errorSummary($activity);
			}
			Yii::app()->end();
		}
		echo '';
		Yii::app()->end();
	}


}