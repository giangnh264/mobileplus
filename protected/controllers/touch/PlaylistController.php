<?php

class PlaylistController extends TController {
	public function  actionMyPlaylist()
	{
		if(!$this->userPhone){
			$this->redirect("/account/login");
			Yii::app()->end();
		}
		$limit = Yii::app()->params['numberPerPage'];
		$user = UserModel::model()->find("phone=".$this->userPhone);
		$page = Yii::app()->request->getParam('page', 1);
		
		if($user){
			$userId = $user->id;
			$count = WapPlaylistModel::model()->countPlaylistUserIDPhone($userId, $this->userPhone);
			$pager = new CPagination($count);
			$pager->setPageSize($limit);
			$playlist = WapPlaylistModel::model()->getPlaylistByUser($userId,$this->userPhone,$limit,$pager->getOffset());
		}else{
			$userId = null;
			$count = WapPlaylistModel::model()->countPlaylistByPhone($this->userPhone);
			$pager = new CPagination($count);
			$pager->setPageSize($limit);
			$playlist = WapPlaylistModel::model()->getPlaylistByPhone($this->userPhone,$limit,$pager->getOffset());
		}
		
		$callBack = Yii::app()->request->getParam('call_back',0);
		$callBackLink = Yii::app()->createUrl("playlist/myPlaylist");
		
		if($callBack){
			$this->layout = false;
			$this->render("_ajaxList",compact('playlist','pager','callBackLink'));
			Yii::app()->end();
		}
		$this->render('myplaylist', array(
			'playlist' => $playlist,
				'pager'=>$pager,
				'callBackLink'=>$callBackLink
		));
	}
	public function actionView() {
		$playlistId = Yii::app()->request->getParam('id');
		$playlist = WapPlaylistModel::model()->published()->findByPk($playlistId);
		$user_msisdn = $playlist->msisdn;
		if (!$playlist) {
			$this->forward("/site/error",true);
		}
		$songsOfPlaylist = WapPlaylistModel::model()->getSongs($playlistId);
		//samge user
		$countPlSameUser = WapPlaylistModel::model()->countPlaylistByPhone($this->userPhone);
		$playlistPages = new CPagination($countPlSameUser);
		$pageSize = Yii::app()->params['pageSize'];
		$playlistPages->setPageSize($pageSize);
		$currentPage = $playlistPages->getCurrentPage();
		$playlistsSameUser = WapPlaylistModel::model()->getSamePlaylistByPhone($playlist->id, $this->userPhone, $currentPage * $pageSize, $pageSize);
		$errorCode = 'success';
		$errorDescription = '';
		 
		//for show price
		$checkPlay = WapUserTransactionModel::model()->checkCharging24h($this->userPhone, $this->userPhone, $playlistId, 'play_album');
		$userSub = $this->userSub;//WapUserSubscribeModel::model()->getUserSubscribe($phone);
		if ($checkPlay) {
			$playPrice = 0;
		} else {
			if ($userSub) {
				$playPrice = 0;
			}
		}
		if ($checkPlay) {
			$playPrice = 0;
		}
// 		$registerText = WapAlbumModel::model()->getCustomMetaData('REG_TEXT');
		$this->itemName = $playlist->name;
		$this->artist = "Chacha"; //$playlist->username;
		$this->thumb = UserModel::model()->getThumbnailUrl('s1', $playlist->user_id);
		$this->url = URLHelper::buildFriendlyURL("playlist", $playlist->id, Common::makeFriendlyUrl($playlist->name));
		$this->description = $playlist->name;
		
		$this->render('view', array(
				'playlist' => $playlist,
				'songsOfPlaylist' => $songsOfPlaylist,
				'playlistsSameUser' => $playlistsSameUser,
				'playlistPages' => $playlistPages,
// 				'playPrice' => $playPrice,
				'errorCode' => $errorCode,
				'errorDescription' => $errorDescription,
// 				'registerText' => $registerText,
				'userSub' => $userSub,
				'user_msisdn'=>$user_msisdn,
				 
		));
	}
	public function actionDel()
	{
		$id = Yii::app()->request->getParam('id');
		$listsong = PlaylistSongModel::model()->deleteAll('playlist_id = :pid', array(':pid' => $id));
		try {
		$res = PlaylistModel::model()->findByPk($id);
		try {
			$res->delete();
			echo '1';
		}
		catch (Exception $ex)
		{
			echo '0';
		}
		}
		catch (Exception $ex1)
		{
			echo '0';
		}
		Yii::app()->end();
	}

}