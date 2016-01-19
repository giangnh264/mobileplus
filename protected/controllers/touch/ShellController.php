<?php
class ShellController extends TController
{
	const _NUMBER_ITEM = 6;
	const _NUMBER_ITEM_VIEW = 10;

	public function actionIndex()
	{
		$limit = self::_NUMBER_ITEM;
		$albums = WapAlbumModel::getListByCollection('ALBUM_DOC_QUYEN', 1, $limit);
		$videos = WapVideoModel::getListByCollection('VIDEO_DOC_QUYEN', 1, $limit);
		$songs = WapSongModel::getListByCollection('SONG_DOC_QUYEN', 1, $limit);
		$this->render("index", compact('albums','videos','songs'));
	}
	public function actionSong()
	{
		$type = CHtml::encode(Yii::app()->request->getParam('type', 'HOT'));
		$callBack = (int) Yii::app()->request->getParam('call_back', 0);
		$page = (int) Yii::app()->request->getParam('page', 1);
		$limit = self::_NUMBER_ITEM_VIEW;
		$count = WapSongModel::countListByCollection('SONG_DOC_QUYEN');
		$songs = WapSongModel::getListByCollection('SONG_DOC_QUYEN', $page, $limit);
		$options = array('col' => 'SONG_DOC_QUYEN');
		$pager = new CPagination($count);
		$pager->setPageSize($limit);
		$offset = $pager->getOffset();
		$callBackLink = Yii::app()->createUrl("/shell/song", array(
				'type' => $type
		));
		if ($callBack) {
			$this->layout = false;
			$this->render("_ajax_song_list", compact('songs', 'pager', 'callBackLink', 'options'));
		} else {
			$this->render("song", compact('options', 'songs', 'pager', 'callBackLink'));
		}
	}
	public function actionVideo() {
		$callBack = (int)Yii::app()->request->getParam('call_back', 0);
		$page = (int)Yii::app()->request->getParam('page', 1);
		$limit = self::_NUMBER_ITEM_VIEW;
	
		$count = WapVideoModel::countListByCollection('VIDEO_DOC_QUYEN');
		$videos = WapVideoModel::getListByCollection('VIDEO_DOC_QUYEN', $page, $limit);
		$pager = new CPagination($count);
		$pager->setPageSize($limit);
		$offset = $pager->getOffset();
		$callBackLink = Yii::app()->createUrl("/shell/video");
		if ($callBack) {
			$this->layout = false;
			$this->render("_ajax_video_list", compact('videos', 'pager', 'callBackLink'));
		} else {
			$this->render('video', array(
					'videos' => $videos,
					'pager' => $pager,
					'callBackLink' => $callBackLink,
			));
		}
	}
	public function actionAlbum() {
		$callBack = (int)Yii::app()->request->getParam('call_back', 0);
		$page = (int)Yii::app()->request->getParam('page', 1);
		$limit = self::_NUMBER_ITEM_VIEW;
	
		$count = WapAlbumModel::countListByCollection('ALBUM_DOC_QUYEN');
		$albums = WapAlbumModel::getListByCollection('ALBUM_DOC_QUYEN', $page, $limit);
		$pager = new CPagination($count);
		$pager->setPageSize($limit);
		$offset = $pager->getOffset();
		$callBackLink = Yii::app()->createUrl("/shell/album");
		if ($callBack) {
			$this->layout = false;
			$this->render("_ajax_album_list", compact('videos', 'pager', 'callBackLink'));
		} else {
			$this->render('album', array(
					'albums' => $albums,
					'pager' => $pager,
					'callBackLink' => $callBackLink,
			));
		}
	}
}