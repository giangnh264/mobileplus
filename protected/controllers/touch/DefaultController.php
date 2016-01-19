<?php

class DefaultController extends TController {

    public function actionCharge() {

        $contentId = (int) Yii::app()->request->getParam('id');
        $contentCode = (int) Yii::app()->request->getParam('code');
        $contentType = htmlspecialchars(Yii::app()->request->getParam('type'));
        $bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
        $client = new SoapClient($bmUrl, array('trace' => 1));
        $fromPhone = Yii::app()->user->getState('msisdn');
        $options = array();
        if (Yii::app()->user->getState('isWifi')) {
            $options['note'] = 'WIFI';
        }
        $result = new stdClass();
        switch ($contentType) {
            case "downloadSong":
                $params = array(
                    'code' => $contentCode,
                    'from_phone' => yii::app()->user->getState('msisdn'),
                    'to_phone' => yii::app()->user->getState('msisdn'),
                    'source_type' => 'wap',
                    'promotion' => 0,
                    'smsId' => '',
                    'noteOptions' => $options
                );
                $result = $client->__soapCall('downloadSong', $params);
                if ($result->errorCode == 0) {
                    $song = WapSongModel::model()->findByPk($contentId);
                    $deviceId = yii::app()->session['deviceId'];
                    $downloadUrl = WapSongModel::model()->getNiceDownloadUrl($song->id, $deviceId, 'http', $song->profile_ids, $song->url_key, $song->artist_name);
                    $result->url = $downloadUrl;
                }
                if (isset(Yii::app()->params['charging']["{$result->message}"])) {
                    $result->message = Yii::app()->params['charging']["{$result->message}"];
                } else {
                    $result->message = Yii::t("wap", "Your account balance is not enough");
                }

                break;
            case "playSong":
                if (Yii::app()->session['src'] == 'ads') {
                    $promotion = 1;
                    $options['note'] = 'ADS';
                } else {
                    $promotion = 0;
                }
                $params = array(
                    'code' => $contentCode,
                    'from_phone' => Yii::app()->user->getState('msisdn'),
                    'source_type' => 'wap',
                    'promotion' => $promotion,
                    'noteOptions' => $options
                );
                $result = $client->__soapCall('playSong', $params);
                if (isset(Yii::app()->params['charging']["{$result->message}"])) {
                    $result->message = Yii::app()->params['charging']["{$result->message}"];
                } else {
                    $result->message = Yii::t("wap", "Your account balance is not enough");
                }

                //Chua dang ky goi cuoc -> log tinh luot play free trong ngay
                if (empty($this->userPhone)) {
                    $params = array(
                        'content_id' => $contentId,
                        'type' => 'song',
                    );
                    FreeContentOnDayModel::model()->add($params);
                }
                break;
            case "playVideo":
                $params = array(
                    'code' => $contentCode,
                    'from_phone' => yii::app()->user->getState('msisdn'),
                    'source_type' => 'wap',
                    'promotion' => 0,
                    'noteOptions' => $options
                );
                $result = $client->__soapCall('playVideo', $params);
                if (isset(Yii::app()->params['charging']["{$result->message}"])) {
                    $result->message = Yii::app()->params['charging']["{$result->message}"];
                } else {
                    $result->message = Yii::t("wap", "Your account balance is not enough");
                }

                //Chua dang ky goi cuoc -> log tinh luot play free trong ngay
                if (empty($this->userPhone)) {
                    $params = array(
                        'content_id' => $contentId,
                        'type' => 'video',
                    );
                    FreeContentOnDayModel::model()->add($params);
                }

                break;
            case "downloadVideo":
                $params = array(
                    'code' => $contentCode,
                    'from_phone' => yii::app()->user->getState('msisdn'),
                    'to_phone' => yii::app()->user->getState('msisdn'),
                    'source_type' => 'wap',
                    'promotion' => 0,
                    'smsId' => '',
                    'noteOptions' => $options
                );
                $result = $client->__soapCall('downloadVideo', $params);
                if ($result->errorCode == 0) {
                    $video = WapVideoModel::model()->findByPk($contentId);
                    $deviceId = yii::app()->session['deviceId'];
                    $downloadUrl = VideoModel::model()->getNiceDownloadUrl($contentId, $deviceId, 'http', true, $video->url_key);
                    $result->url =$downloadUrl;
                }
                //$result->message = Yii::app()->params['charging']["{$result->message}"];
                if (isset(Yii::app()->params['charging']["{$result->message}"])) {
                    $result->message = Yii::app()->params['charging']["{$result->message}"];
                } else {
                    $result->message = Yii::t("wap", "Your account balance is not enough");
                }
                break;
            case "subscribe":
                $packageCode = 'CHACHAFUN';
                $params = array(
                    'phone' => Yii::app()->user->getState('msisdn'),
                    'package' => $packageCode,
                    'source' => 'wap',
                    'promotion' => 0
                );
                $result = $client->__soapCall('userRegister', $params);
                break;

            case "playAlbum":
                $params = array(
                    'id' => $contentId,
                    'from_phone' => yii::app()->user->getState('msisdn'),
                    'source_type' => 'wap',
                    'promotion' => 0
                );
                $result = $client->__soapCall('playAlbum', $params);
                if (isset(Yii::app()->params['charging']["{$result->message}"])) {
                    $result->message = Yii::app()->params['charging']["{$result->message}"];
                } else {
                    $result->message = Yii::t("wap", "Your account balance is not enough");
                }
                //$result->message = Yii::app()->params['charging']["{$result->message}"];
                break;
        }

        header("Content-type: application/json");
        echo json_encode($result);
        Yii::app()->end();
    }

    public function actionLike() {
        $this->layout = false;
        $type = htmlspecialchars(Yii::app()->request->getparam('type', 'song'));
        $id = (int) Yii::app()->request->getparam('id', 0);
        $phone = Formatter::formatPhone(Yii::app()->user->getState('msisdn'));
        if (empty($phone)) {
            echo 'phone_not_detect';
            Yii::app()->end();
        }
        $criteria = new CDbCriteria;
        $criteria->condition = "phone=:phone";
        $criteria->params = array(':phone' => $phone);
        $userId = WapUserModel::model()->find($criteria)->id;
        if (empty($userId)) {
            echo 'phone_not_register';
            Yii::app()->end();
        }
        switch ($type) {
            case 'video':
                $video = WapFavouriteVideoModel::model()->findByAttributes(array('video_id' => $id, 'msisdn' => $phone));
                if (!isset($video)) {
                    $videoModel = new WapFavouriteVideoModel;
                    $videoModel->video_id = $id;
                    $videoModel->msisdn = $phone;
                    $videoModel->created_time = date('Y-m-d H:i:s');
                    $videoModel->save();
                }
                echo 'success';
                break;
            case 'videoPlaylist':
                $video = FavouriteVideoPlaylistModel::model()->findByAttributes(array('video_playlist_id' => $id, 'msisdn' => $phone));
                if (!isset($video)) {
                    $videoModel = new FavouriteVideoPlaylistModel;
                    $videoModel->msisdn = $phone;
                    $videoModel->video_playlist_id = $id;
                    $videoModel->created_time = date('Y-m-d H:i:s');
                    $videoModel->save();
                }
                echo 'success';
                break;
            case 'album':
                $album = FavouriteAlbumModel::model()->findByAttributes(array('album_id' => $id, 'msisdn' => $phone));
                if (!isset($album)) {
                    $albumModel = new FavouriteAlbumModel;
                    $albumModel->msisdn = $phone;
                    $albumModel->album_id = $id;
                    $albumModel->created_time = date('Y-m-d H:i:s');
                    $albumModel->save();
                }
                break;
            default://song
                $song = WapFavouriteSongModel::model()->findByAttributes(array('song_id' => $id, 'msisdn' => $phone));
                if (!isset($song)) {
                    $songModel = new WapFavouriteSongModel;
                    $songModel->msisdn = $phone;
                    $songModel->song_id = $id;
                    $songModel->created_time = date('Y-m-d H:i:s');
                    $songModel->save();
                }
                echo 'success';
                break;
        }

        Yii::app()->end();
    }

    public function actionDislike() {
        $this->layout = false;
        $type = htmlspecialchars(Yii::app()->request->getparam('type', 'song'));
        $id = (int) Yii::app()->request->getparam('id', 0);
        $phone = Formatter::formatPhone(Yii::app()->user->getState('msisdn'));
        if (empty($phone)) {
            echo 'phone_not_detect';
            Yii::app()->end();
        }
        $criteria = new CDbCriteria;
        $criteria->condition = "phone=:phone";
        $criteria->params = array(':phone' => $phone);
        switch ($type) {
            case 'video':
                $videoModelDel = WapFavouriteVideoModel::model()->deleteAll("video_id=$id AND msisdn=$phone");
                if ($videoModelDel) {
                    echo 'deleted success';
                } else {
                    echo 'deleted fail';
                }
                break;
            case 'videoPlaylist':
                $videoModelDel = FavouriteVideoPlaylistModel::model()->deleteAll("video_playlist_id=$id AND msisdn=$phone");
                if ($videoModelDel) {
                    echo 'deleted success';
                } else {
                    echo 'deleted fail';
                }
                break;
            case 'album':
                $albumModelDel = FavouriteAlbumModel::model()->deleteAll("album_id=$id AND msisdn=$phone");
                if ($albumModelDel) {
                    echo 'deleted success';
                } else {
                    echo 'deleted fail';
                }
                break;
            default://song
                $songModelDel = WapFavouriteSongModel::model()->deleteAll("song_id=$id AND msisdn=$phone");
                if ($songModelDel) {
                    echo 'deleted success';
                } else {
                    echo 'deleted fail';
                }
                break;
        }

        Yii::app()->end();
    }

    public function actionError() {
        $this->pageTitle = "Xảy ra lỗi";
        $error = Yii::app()->errorHandler->error;
        if (Yii::app()->request->isAjaxRequest)
            echo $error['message'];
        else {
            //echo "<pre>";print_r($error);exit();
            $this->render('error', array('error' => $error));
        }
    }

    public function actionFeedback() {
        $model = new FeedbackModel();
        $success = 0;
        if (isset($_POST['FeedbackModel'])) {
            $model->attributes = $_POST['FeedbackModel'];
            $model->setAttribute('phone', Yii::app()->user->getState('msisdn'));
            $model->setAttribute('created_datetime', date("Y-m-d H:i:s"));
            $model->setAttribute('version', 'TOUCH');
            if ($model->save())
                $success = 1;
        }
        $this->render('feedback', array('model' => $model, 'success' => $success));
    }

    public function actionDownload() {
        $this->layout = false;
        $contentId = (int) Yii::app()->request->getParam('id');
        $type = Yii::app()->request->getParam('type', 'downloadSong');
        $deviceId = yii::app()->session['deviceId'];
        $downloadUrl = '';
        if ($type == 'downloadVideo') {
            $video = WapVideoModel::model()->findByPk($contentId);
            $downloadUrl = VideoModel::model()->getDownloadUrl($contentId, $deviceId, 'http', true);
            $contentType = 'video/mp4';
            $fileName = $video->name;
            $fileName = Common::makeFriendlyUrl($fileName) . ".mp4";
        } elseif ($type == 'downloadSong') {
            $song = WapSongModel::model()->findByPk($contentId);
            //$downloadUrl = WapSongModel::model()->getNiceDownloadUrl($song->id, $deviceId, 'http', $song->profile_ids, $song->url_key, $song->artist_name);
            //$downloadUrl = WapSongModel::model()->getAudioFileUrl($song->id, $deviceId, 'http', $song->profile_ids);
            $downloadUrl = WapSongModel::model()->getNiceDownloadUrl($song->id, $deviceId, 'http', $song->profile_ids, $song->url_key, $song->artist_name);
            echo '<meta http-equiv="refresh" content="0;url=' . $downloadUrl . '" />';
            exit();
            $contentType = 'audio/mpeg';
            $fileName = $song->name;
            $fileName = Common::makeFriendlyUrl($fileName) . ".mp3";
        }
        echo '<meta http-equiv="refresh" content="0;url=' . $downloadUrl . '" />';
        exit();
        //$this->redirect($downloadUrl);
        //Yii::app()->end();
        //echo '<meta http-equiv="refresh" content="0;url='.$downloadUrl.'" />';
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $fileName);
        header("Content-Type: $contentType");
        header("Content-Transfer-Encoding: binary");
        readfile($downloadUrl);
        //Yii::app()->end();
        //Common::DownloadWithName($this->userPhone, $contentId, $type);
        exit();
    }

    public function actionPopup() {
        $this->renderPartial('popup');
    }

}
