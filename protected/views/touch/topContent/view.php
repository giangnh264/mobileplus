<?php if($topContent->type == 'album'){
    $userType = "GUEST";
    $phone = Yii::app()->user->getState('phone');
    if ($phone) {
        $userType = "MEMBER";
    }
    $userSub = Yii::app()->user->getState('userSub');
    $packageCode = Yii::app()->user->getState('packageCode');
    if ($userSub) {
        $userType = "SUB_" . $packageCode;
    }
    $perLimit = ContentLimitModel::getPermision($topContent->content_id, "album", $userType, "WAP");
    $songsOfAlbum = WapSongModel::model()->getSongsOfAlbum($topContent->content_id);
    $like = null;
    if ($phone) {
        $userId = WapUserModel::model()->findByAttributes(array('phone'=>$phone))->id;
        $like = FavouriteAlbumModel::model()->findByAttributes(array('album_id' => $albumId, 'msisdn' => $phone));
    }
    $this->renderPartial('_albumView', compact('content', 'perLimit', 'songsOfAlbum','like'));
}elseif($topContent->type == 'video_playlist'){
    $list_video_playlist = WapVideoModel::model()->getVideosOfVideoPlaylist($topContent->content_id);
    //check noi dung doc quyen
    $userType = "GUEST";
    $phone = Yii::app()->user->getState('phone');
    if ($phone) {
        $userType = "MEMBER";
    }
    $userSub = Yii::app()->user->getState('userSub');
    $packageCode = Yii::app()->user->getState('packageCode');
    if ($userSub) {
        $userType = "SUB_" . $packageCode;
    }
    $content_limit = ContentLimitModel::model()->getIdByType('video','WAP',$userType);
    $list_video = array();
    for($i=0;$i< count($list_video_playlist);$i++){
        if(!in_array($list_video_playlist[$i]->id,$content_limit)){
            $list_video[] = $list_video_playlist[$i];
        }
    }
    $phone = Yii::app()->user->getState('msisdn');
    $like = null;
    if ($phone) {
        $like = FavouriteVideoPlaylistModel::model()->findByAttributes(array('video_playlist_id' => $topContent->content_id, 'msisdn' => $phone));
    }
    $video = $list_video[0];
    $this->renderPartial('_videoplaylistView', compact('content', 'list_video_playlist', 'songsOfAlbum', 'like', 'video', 'list_video'));

}

?>
