<?php
class ArtistController extends TController
{
	public function actionIndex()
	{
		$this->forward("artist/top",true);
		$this->render('index');
	}

    /**
     * function actionTop
     * call to render artist top page
     */
    public function actionTop()
    {
        $countArtist = WapArtistModel::model()->countTopArtists();
        $artistPages = new CPagination($countArtist);
        $pageSize = Yii::app()->params['pageSize'];
        $artistPages->setPageSize($pageSize);
        $currentPage = $artistPages->getCurrentPage();
        $topArtists = WapArtistModel::model()->getTopArtists($currentPage * $pageSize, $pageSize);
        $this->render('top', array('artists' => $topArtists, 'artistPages' => $artistPages));
    }

    /**
     * function actionList
     * call to render artist list page
     */
    public function actionList()
    {
        $countArtist = WapArtistModel::model()->countTopArtists();
        $artistPages = new CPagination($countArtist);
        $pageSize = Yii::app()->params['pageSize'];
        $artistPages->setPageSize($pageSize);
        $currentPage = $artistPages->getCurrentPage();
        $topArtists = WapArtistModel::getTopArtists($currentPage * $pageSize, $pageSize);
        $this->render('top', array('artists' => $topArtists, 'artistPages' => $artistPages));
    }


    /**
     * function actionDetail
     * call to render artist detail page
     */
    public function actionView()
    {
        $artistId = Yii::app()->request->getParam('id');
        $artist = ArtistModel::model()->findByPk($artistId);


        $this->artist = $artist->name;
        $this->thumb = ArtistModel::model()->getAvatarUrl($artist->id, 150);
        $this->url = URLHelper::buildFriendlyURL("artist", $artist->id, $artist->url_key);

        if (!$artist)
        {
            $this->forward("/site/error",true);
        }
        $pageSize = 5;
        $result = array();
        //song
            // in case that list songs of artist
        $result['song'] = WapSongModel::model()->getSongsSameSinger(0, $artist->id, 0, $pageSize);
        //video
		$result['video'] = WapVideoModel::model()->getVideosSameArtist(0, $artist->id, 0, $pageSize);
        //album
//                $result['album'] = AlbumArtistModel::model()->getAlbumsSameArtist($artist->id, 0, $pageSize);
		$result['album'] = WapAlbumModel::model()->getAlbumsSameArtist(0, $artist->id, 0, $pageSize);
        $this->render('view', array('artist' => $artist,'result'=>$result));

    }
    public function actionViewType(){
        $artistId = Yii::app()->request->getParam('id');
        $artist = ArtistModel::model()->findByPk($artistId);


        $this->artist = $artist->name;
        $this->thumb = ArtistModel::model()->getAvatarUrl($artist->id, 150);
        $this->url = URLHelper::buildFriendlyURL("artist", $artist->id, $artist->url_key);


        if (!$artist)
        {
            $this->forward("/site/error",true);
        }
        $listType = Yii::app()->request->getParam('list', 'song');
        $countSongsOfArtist = $artist->song_count;
        $countClipsOfArtist = $artist->video_count;
        $countAlbumsOfArtist = $artist->album_count;
        $pageSize = Yii::app()->params['numberSongsPerPage'];
        if ($listType == 'song')
        {
            // in case that list songs of artist
            $songPages = new CPagination($countSongsOfArtist);
            $songPages->setPageSize($pageSize);
            $currentPage = $songPages->getCurrentPage();
            $songsOfArtist = WapSongModel::model()->getSongsSameSinger(0, $artist->id, $currentPage * $pageSize, $pageSize);
            $this->render('viewtype', array('artist' => $artist, 'listType' => $listType,
                'countSongsOfArtist' => $countSongsOfArtist,
                'countClipsOfArtist' => $countClipsOfArtist,
                'countAlbumsOfArtist' => $countAlbumsOfArtist,
                'songsOfArtist' => $songsOfArtist, 'songPages' => $songPages));
        }
        elseif ($listType == 'clip')
        {
            // in case that list clips of artist
            $clipPages = new CPagination($countClipsOfArtist);
            $clipPages->setPageSize($pageSize);
            $currentPage = $clipPages->getCurrentPage();
            $clipsOfArtist = WapVideoModel::model()->getVideosSameArtist(0, $artist->id, $currentPage * $pageSize, $pageSize);
            $this->render('viewtype', array('artist' => $artist, 'listType' => $listType,
                'countSongsOfArtist' => $countSongsOfArtist,
                'countClipsOfArtist' => $countClipsOfArtist,
                'countAlbumsOfArtist' => $countAlbumsOfArtist,
                'clipsOfArtist' => $clipsOfArtist, 'clipPages' => $clipPages));
        }
        else
        {
            // in case that list albums of artist
            $albumPages = new CPagination($countAlbumsOfArtist);
            $albumPages->setPageSize($pageSize);
            $currentPage = $albumPages->getCurrentPage();
            $albumsOfArtist = WapAlbumModel::model()->getAlbumsSameArtist(0, $artist->id, $currentPage * $pageSize, $pageSize);
            $this->render('viewtype', array('artist' => $artist, 'listType' => $listType,
                'countSongsOfArtist' => $countSongsOfArtist,
                'countClipsOfArtist' => $countClipsOfArtist,
                'countAlbumsOfArtist' => $countAlbumsOfArtist,
                'albumsOfArtist' => $albumsOfArtist, 'albumPages' => $albumPages));
        }
    }
}