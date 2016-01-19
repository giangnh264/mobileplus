<?php

class FavouriteController extends TController
{
    public function  actionIndex()
    {
        $callBack = (int)Yii::app()->request->getParam('call_back', 0);
        $s = CHtml::encode(Yii::app()->request->getParam('s', 'SONG'));
        if (empty($this->userPhone) && $callBack != 0) {
            echo '1';
            Yii::app()->end();
        }
        if (empty($this->userPhone)) {
            $this->redirect('/account/login');
            Yii::app()->end();
        }
        $limit = 5;
        $pageSize = 10;

        $sTitle = ($s == 'SONG') ? "BÀI HÁT" : $s;
        switch ($s) {
            case 'SONG':
                $sTitle = Yii::t("wap", "Favourite songs");
                break;
            case 'VIDEO':
                $sTitle = Yii::t("wap", "Favourite videos");
                break;
            case 'ALBUM':
                $sTitle = Yii::t("wap", "Favourite albums");
                break;
            case 'VIDEOPLAYLIST':
                $sTitle = Yii::t("wap", "Favourite video playlist");
                break;

        }

        $callBackLink = Yii::app()->createUrl("favourite/index", array(
            's' => $s
        ));
        if ($s == 'SONG') {
                $count = WapFavouriteSongModel::model()->countByPhone($this->userPhone);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $offset = $pager->getOffset();
                $listfavourite = WapFavouriteSongModel::model()->findAllByPhone($this->userPhone, $pageSize, $offset);
            if ($callBack) {
                $this->layout = false;
                $this->render("/song/_ajaxList", array(
                    'songs' => $listfavourite
                ));
                Yii::app()->end();
            }
        } elseif ($s == 'VIDEOPLAYLIST') {
                $count = FavouriteVideoPlaylistModel::model()->countByPhone($this->userPhone);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $offset = $pager->getOffset();
                $listfavourite = FavouriteVideoPlaylistModel::model()->findAllByPhone($this->userPhone, $pageSize, $offset);
            if ($callBack) {
                $this->layout = false;
                $this->render("/videoPlaylist/_ajaxList", array(
                    'videoplaylist' => $listfavourite
                ));
                Yii::app()->end();
            }
        } elseif ($s == 'ALBUM') {
            $count = WapFavouriteAlbumModel::model()->countByPhone($this->userPhone);
            $pager = new CPagination($count);
            $pager->setPageSize($limit);
            $offset = $pager->getOffset();
            $listfavourite = WapFavouriteAlbumModel::model()->findAllByPhone($this->userPhone, $pageSize, $offset);

            if ($callBack) {
                $this->layout = false;
                $this->render("/album/_ajaxList", array(
                    'albums' => $listfavourite
                ));
                Yii::app()->end();
            }
        } else {
                $count = WapFavouriteVideoModel::model()->countByPhone($this->userPhone);
                $pager = new CPagination($count);
                $pager->setPageSize($limit);
                $offset = $pager->getOffset();
                $listfavourite = WapFavouriteVideoModel::model()->findAllByPhone($this->userPhone, $limit, $offset);
            if ($callBack) {
                $this->layout = false;
                $this->render("/video/_ajaxList", array(
                    'videos' => $listfavourite
                ));
                Yii::app()->end();
            }
        }
        $this->render('index', array(
            'listfavourite' => $listfavourite,
            's' => $s,
            'sTitle' => $sTitle,
            'pager' => $pager,
            'callBackLink' => $callBackLink
        ));
    }

    public function  actionList()
    {
        if (empty($this->userPhone)) {
            $this->redirect('/account/login');
            Yii::app()->end();
        }
        $limit = 5;
        $pageSize = 5;
        $listfavourite = array();
        $offset = 0;
        $listfavourite['song'] = WapFavouriteSongModel::model()->findAllByPhone($this->userPhone, $pageSize, $offset);
        $listfavourite['album'] = WapFavouriteAlbumModel::model()->findAllByPhone($this->userPhone, $pageSize, $offset);
        $listfavourite['video'] = WapFavouriteVideoModel::model()->findAllByPhone($this->userPhone, $limit, $offset);
        $listfavourite['videoplaylist'] = FavouriteVideoPlaylistModel::model()->findAllByPhone($this->userPhone, $limit, $offset);
        $this->render('list', array(
            'listfavourite' => $listfavourite,
        ));
    }
}

?>