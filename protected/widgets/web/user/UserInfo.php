<?php
class UserInfo extends CWidget{
    public $user;
    public $changeAvatar = false;
    public $link = '';
    
    public function run(){
    	$userSubscribe = WebUserSubscribeModel::model()->getUserSubscribeByPhone($this->user->phone);
        $this->render('userInfo', array('user'=>$this->user, 'userSubscribe' => $userSubscribe, 'changeAvatar'=>$this->changeAvatar));
    }
}
