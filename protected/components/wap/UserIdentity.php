<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends MainUserIdentity {
	private $_id;
	/**
	 * function userAuthenticate
	 * call after detect phone number, save phone number and package to session
	 *
	 * @param string $type
	 * @return bool
	 */
	public function userAuthenticate($type, $os) {
		Yii::app()->user->setState ( 'is3g', 0 );
		if($type == 'autoLogin') {
			$msisdn = self::_detectMSISDN('wap',NULL,$os);
			if ($msisdn){
				//xác thực qua 3G
				Yii::app()->user->setState ('is3g', 1 );
				// get user info from phone
				if($user = UserModel::model()->findByAttributes(array("phone" => $msisdn))) {
					if(!empty($user->suggested_list))
						$this->setState('_user', array(
							'id'    => $user->id,
							'suggested_list' => $user->suggested_list,
						));
					else
						$this->setState('_user', array(
							'phone'    => $msisdn,
							'suggested_list' => ""
						));
				}
				else{
					$this->setState('_user', array(
						'phone'    => $msisdn,
						'suggested_list' => ""
					));
				}

				$this->_msisdn = $msisdn;
				$this->errorCode = self::ERROR_NONE;


			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
			$this->_id = $msisdn;
		}else{
			$user = WapUserModel::model ()->findByUsername ( $this->username );
			if (empty ( $user )) {
				$phone = Formatter::formatPhone ( $this->username );
				$user = WapUserModel::model ()->findByPhone ( $phone );
			}
			if ($user === null)
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			else if ($user->password !== (Common::endcoderPassword ( $this->password )))
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			else if ($user->status != UserModel::ACTIVE) {
				Yii::app ()->request->redirect ( "/account/ActiveOtp?phone=". Formatter::formatPhone($this->username ));
				Yii::app ()->end ();
			} else {
				$this->_id = $user->id;
				$this->setState ( 'username', $user->username );
				$this->setState ( 'phone', $user->phone );
				$this->errorCode = self::ERROR_NONE;
				$user->login_time = new CDbExpression ( "NOW()" );
				$user->save ();
				$this->_msisdn = $user->phone;
			}
		}
		if ($this->_msisdn) {
			$this->setState ( 'msisdn', $this->_msisdn );
		}
		$package = WapUserSubscribeModel::model ()->getUserSubscribe ( $this->_msisdn ); // get user_subscribe record by phone
		if ($package) {
			$packageObj = WapPackageModel::model ()->findByPk ( $package->package_id );
			$this->setState ( 'package', $packageObj->code );
		}
		return ! $this->errorCode;

	}
	public function userAuthenticateWifi($msisdn) {
		if ($msisdn) {
			// get user info from phone
			$user = UserModel::model ()->findByAttributes ( array (
				"phone" => $msisdn
			) );
			if ($user) {
				if (! empty ( $user->suggested_list ))
					$this->setState ( '_user', array (
						'id' => $user->id,
						'suggested_list' => $user->suggested_list
					) );
				else
					$this->setState ( '_user', array (
						'phone' => $msisdn,
						'suggested_list' => ""
					) );
			} else {
				$this->setState ( '_user', array (
					'phone' => $msisdn,
					'suggested_list' => ""
				) );
			}
			$this->_msisdn = $msisdn;

			$this->setState ( 'msisdn', $msisdn );
			$package = WapUserSubscribeModel::model ()->getUserSubscribe ( $this->_msisdn ); // get user_subscribe record by phone
			if ($package) {
				$packageObj = WapPackageModel::model ()->findByPk ( $package->package_id );
				$this->setState ( 'package', $packageObj->code );
			}

			self::_logDetectMSISDN( $msisdn, 'wifi' );

			$this->errorCode = self::ERROR_NONE;
		} else {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		return ! $this->errorCode;
	}

	/**
	 *
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->_id;
	}
}