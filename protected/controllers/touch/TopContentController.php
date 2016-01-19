<?php
class TopContentController extends TController{
    public function actionIndex(){
        $limit = 10;
        $topContent = TopContentModel::model()->getTopContent('home',$limit);
        $this->render('index', compact('topContent'));
    }

    public function actionView(){
        $id = Yii::app()->request->getParam('id',0);
        $topContent = TopContentModel::model()->findByPk($id);
        if(!$topContent){
            $this->forward("/site/error",true);
        }
        if($topContent->type == 'album'){
            $content = AlbumModel::model()->findByPk($topContent->content_id);
        }elseif($topContent->type == 'video_playlist'){
            $content = WapVideoPlaylistModel::model()->published()->with('video_playlist_artist')->findByPk($topContent->content_id);
        }
        if(!$content || $content->status != 1){
            $this->forward("/site/error",true);
        }
        $this->render('view',compact('topContent','content'));

    }
}