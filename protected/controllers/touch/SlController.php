<?php
class SlController extends TController
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


	public function init() {
		$this->aes = new MobifoneAES($this->key, '');

		parent::init();
	}

	public function actionIndex()
	{
		$urlKey = Yii::app()->request->getParam('url_key');
		$urlKey = preg_replace( "/^\.+|\.+$/", "",trim($urlKey));
		$sql = "select * from ads_marketing where url_key=:url_key limit 1";
		$cm = Yii::app()->db->createCommand($sql);
		$cm->bindParam(':url_key', $urlKey, PDO::PARAM_STR);
		$ads = $cm->queryRow();
		if($ads){
			$userPhone = Yii::app()->user->getState('msisdn');
			$userSub = $this->isSub;
			$source = $ads['code'];
			Yii::app()->session['source'] = $source;
			if($source=='ADS'){
				Yii::app()->session['src'] = 'ads';
			}
			//log ads
			$write = 1;
			if (isset($_SESSION [$source])) {
				// check time giua 2 lan visit co > 15 giay hay ko
				$latest_time = $_SESSION [$source];
				$now = date("Y-m-d H:i:s");
				$diff = strtotime($now) - strtotime($latest_time);
				if (intval($diff) < 15) {
					$write = 0;
				}
			}
			if ($write == 1) {
				// log to table log_ads_click
				$log = new LogAdsClickModel ();
				$ip = $_SERVER ["REMOTE_ADDR"];
				$is3G = 0;
				if($this->is3g){
					$is3G = 1;
				}
				//$log->logAdsWap($userPhone, $source, $ip, $is3G);
				$log->ads = $source;
				$log->user_phone = $userPhone;
				$log->user_ip = $ip;
				$log->is_3g = $is3G;
				$log->created_time = date("Y-m-d H:i:s");
				$log->save(false);
				// set session value
				$_SESSION [$source] = date("Y-m-d H:i:s");
			}
			//end log
			$destLink = $ads['dest_link'];
			if ($userSub || empty($userPhone)) {
				$this->redirect($destLink);
			}
			$logger = new KLogger("log_sl", KLogger::INFO);
			$logger->LogInfo("action:".$ads['action']."|userSub:".json_encode($userSub), false);
			if($ads['action']=='subscribe' && !($userSub)){//subscribe now
				$this->showPopupKm=false;
				$this->showPopup=false;
				$userPackage = UserSubscribeModel::model()->get($userPhone);
				$package_id = $ads['package_id'];
				$packageCode = PackageModel::model()->findByPk($package_id)->code;
				if(empty($userPackage)) {
					//doregister
					$url = Yii::app()->createUrl('account/vasRegister', array('package'=>$package_id, 'back_link'=>$destLink));
					$this->redirect($url);
				}
			}
			$this->redirect($destLink);
		}else{
			$this->redirect('http://amusic.vn');
		}
	}

	private function _register($phone, $package_id){
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
			$msg = $e->getMessage();
		}
		return $msg;
	}


}