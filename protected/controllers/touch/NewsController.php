<?php
class NewsController extends TController
{
	public function actionIndex()
	{
		$this->forward("/site/error",true);
		$countNews = WapNewsModel::model()->countTopNews();
		$limit = Yii::app()->params['numberPerPage'];
		$page = (int)Yii::app()->request->getParam('page', 0);
		$pager = new CPagination($countNews);
		$pager->setPageSize($limit);
		$offset = $pager->getOffset();
		$callBackLink = Yii::app()->createUrl("news/index");
		$callBack = (int)Yii::app()->request->getParam('call_back',0);
		$news = WapNewsModel::model()->getTopNews($page * $limit, $limit);
		if($callBack){
			$this->layout = false;
			$this->render("_ajaxList",compact('news','pager','callBackLink'));
		}else{
			$userPlaylist = array();
			if($this->userPhone){
				$userPlaylist = WapPlaylistModel::model()->getPlaylistByPhone($this->userPhone);
			}
			$this->render("index",compact('news','pager','callBackLink'));
		}
	}
	public function actionView()
	{
		$this->forward("/site/error",true);
		$this->forward("news/detail",true);
		Yii::app()->end();
	}
	public function  actionDetail()
	{
		$this->forward("/site/error",true);
		$new_id = (int)Yii::app()->request->getParam('id');
		$from = Yii::app()->request->getParam('from','');
		$news = $detailnew = NewsModel::model()->findByPk($new_id);
		if(empty($news)){
			$this->forward("/site/error",true);
		}
		$this->itemName = htmlspecialchars($detailnew->title);
		$this->keyword = $detailnew->title;
		$this->thumb = NewsModel::model()->getAvatarUrl($new_id,'s1');
		$this->url = URLHelper::buildFriendlyURL("news", $detailnew ? $new_id : 0, Common::makeFriendlyUrl($detailnew->title ? $detailnew->title : " "));
		$this->description = "";
		if($from == 'api'){
			$this->layout = false;
		}
		$this->render('detail',compact('news','from'));
	}
}