<?php
class PersonalityController extends TController
{
	public function actionIndex()
	{
		$parent_id = Yii::app()->params['horoscope']['parent_id'];
/*		$criteria = new CDbCriteria();
		$criteria->condition = "parent_id= :PARENT_ID AND status = ".RadioModel::_ACTIVE;
		$criteria->params = array(":PARENT_ID"=>$parent_id);
		$criteria->order = "ordering ASC";
		$radioList = WapRadioModel::model()->findAll($criteria);*/
        $radioList = WapRadioModel::model()->getHoroscopes($parent_id, 12);

        $this->render('index', compact('radioList'));
	}
	public function actionList()
	{
		$parent_id = Yii::app()->params['horoscope']['parent_id'];
		$criteria = new CDbCriteria();
		$criteria->condition = "parent_id= :PARENT_ID AND status = ".RadioModel::_ACTIVE;
		$criteria->params = array(":PARENT_ID"=>$parent_id);
		$criteria->order = "ordering ASC";
		$radioList = WapRadioModel::model()->findAll($criteria);
		$this->render('index', compact('radioList'));
	}
	public function actionView()
	{
		$radioId = Yii::app()->request->getParam("id", 0);
		$radioName = WapRadioModel::model()->findByPk($radioId)->name;
		$albumId = WapRadioModel::model()->getAlbumByRadio($radioId, "c2.id");
		$radioAvatar = RadioModel::model()->getAvatarUrl($radioId,'s1');

		$album = WapAlbumModel::model()->published()->findByPk($albumId);
		if (!$album) {
			$this->forward("/site/error",true);
		}

		$songsOfAlbum = WapSongModel::model()->getSongsOfAlbum($albumId);

		$artists = AlbumArtistModel::model()->getArtistsByAlbum($albumId);

		$phone = yii::app()->user->getState('msisdn');
		$errorCode = 'success';
		$errorDescription = '';

		$registerText = WapAlbumModel::model()->getCustomMetaData('REG_TEXT');

		///meta tag
		$AlbumDetail = AlbumModel::model()->findByPk($albumId);
		$artistId = !empty($artists)?$artists[0]->artist_id:$AlbumDetail->artist_id;
		$ArtistInfo = ArtistModel::model()->findByPk($artistId);
		$this->itemName = $AlbumDetail->name;
		$this->artist = $ArtistInfo->name;

		$this->thumb = AlbumModel::model()->getAvatarUrl($albumId, 's1');
		$this->url = URLHelper::buildFriendlyURL("album", $albumId, Common::makeFriendlyUrl($ArtistInfo->name));
		$this->description = strip_tags($AlbumDetail->description);

		//get other radio
		$parent_id = Yii::app()->params['horoscope']['parent_id'];
        $radioListOther = WapRadioModel::model()->getHoroscopes($parent_id);
		$this->render('detail', array(
			'album' => $album,
			'songsOfAlbum' => $songsOfAlbum,
			'errorCode' => $errorCode,
			'errorDescription' => $errorDescription,
			'registerText' => $registerText,
			'radioListOther'=>$radioListOther,
			'radioAvatar'=>$radioAvatar
		));
	}
}