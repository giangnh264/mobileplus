<?php
class SearchController extends TController {

    var $type_infos = array(
        'song' => array('ref_col' => 'song_id', 'class' => 'SongStatisticModel', 'text' => 'Bài hát'),
        'clip' => array('ref_col' => 'video_id', 'class' => 'VideoStatisticModel', 'text' => 'Video'),
        'album' => array('ref_col' => 'album_id', 'class' => 'AlbumStatisticModel', 'text' => 'Album'),
        'artist' => array('ref_col' => 'id', 'class' => 'ArtistModel', 'text' => 'Nghệ sĩ'),
        'videoplaylist' => array('ref_col' => 'id', 'class' => 'VideoPlaylistModel', 'text' => 'Video Playlist'),
    );

    public function actionIndex() {
        $keyword = trim(yii::app()->request->getParam('q', ''));
        $keyword = strip_tags($keyword);
        $search_type = trim(yii::app()->request->getParam('type', ''));
        $page = intval(yii::app()->request->getParam('page', 1));
        $is_search = Yii::app()->request->getParam('is_search', 1);
        $paging = array(
            'page' => $page,
            'recordsPerPage' => !($search_type) ? Yii::app()->params['numberPerPage'] : Yii::app()->params['pageSize']
        );
		$limit = 5;
        $searchType = !($search_type) ? $this->type_infos : array($search_type => '');
        $total_results = array();
        foreach ($searchType as $type => $info) {
            switch ($type) {
                case 'song':
                    $response = SearchHelper::getInstance()->search($keyword, 'song', $limit, ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('name' => 'name', 'artist_name' => 'artist_name'));
                    $results = $this->getStatistic($results, $type);
                    $countSong = $response->numFound;
                    $pages = new CPagination($countSong);
                    $pageSize = Yii::app()->params['pageSize'];
                    $pages->params = array('q' => $keyword, 'type' => $type);
                    $pages->setPageSize($pageSize);
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results,'pages' => $pages,
                    );
                    break;
                case 'clip':
                    $response = SearchHelper::getInstance()->search($keyword, 'video', $limit, ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    $results = $this->getStatistic($results, $type);
                    $countClip = $response->numFound;
                    $pages = new CPagination($countClip);
                    $pageSize = Yii::app()->params['pageSize'];
                    $pages->params = array('q' => $keyword, 'type' => $type);
                    $pages->setPageSize($pageSize);
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results,'pages' => $pages,
                    );
                    break;
                case 'album':
                    $response = SearchHelper::getInstance()->search($keyword, 'album', $limit, ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    $results = $this->getStatistic($results, $type);
                    $countAlbum = $response->numFound;
                    $pages = new CPagination($countAlbum);
                    $pageSize = Yii::app()->params['pageSize'];
                    $pages->params = array('q' => $keyword, 'type' => $type);
                    $pages->setPageSize($pageSize);
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results,'pages' => $pages,
                    );
                    break;
                case 'artist':
                    $response = SearchHelper::getInstance()->search($keyword, 'artist', $limit, ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    $results = $this->getStatistic($results, $type, 'song_count');
                    $countArtist = $response->numFound;
                    $pages = new CPagination($countArtist);
                    $pageSize = Yii::app()->params['pageSize'];
                    $pages->params = array('q' => $keyword, 'type' => $type);
                    $pages->setPageSize($pageSize);
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results,'pages' => $pages,
                    );
                    $listArtist = ArtistModel::updateResultFromSearch($this->copyAndCast($response->docs, array()));
                    $artistSeach = trim($listArtist[0]['name']);
                    if($artistSeach == $keyword
                        || Common::makeFriendlyUrl($artistSeach) == Common::makeFriendlyUrl($keyword)){
                        $urlKey =  Common::makeFriendlyUrl(trim($listArtist[0]['name']));
                        $link = Yii::app()->createUrl("artist/view", array("id" => $listArtist[0]['id'], "title" => $urlKey));
                        $this->redirect($link);
                    }
                    break;
                 case 'videoplaylist':
                    $response = SearchHelper::getInstance()->search($keyword, 'videoplaylist', $limit, ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    $results = $this->getStatistic($results, $type);
                    $countVideoPlaylist = $response->numFound;
                    $pages = new CPagination($countVideoPlaylist);
                    $pageSize = Yii::app()->params['pageSize'];
                    $pages->params = array('q' => $keyword, 'type' => $type);
                    $pages->setPageSize($pageSize);
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results,'pages' => $pages,
                    );
                    break;
               
            }
        }
        if ($is_search =='0')
        {
        	$this->render('list_rbt', array('keyword' => $keyword, 'search_type' => $search_type, 'total_results' => $total_results, 'type_infos' => $this->type_infos));
        }
//        echo '<pre>';print_r($total_results);
        $this->render('result', array('keyword' => $keyword, 'search_type' => $search_type, 'total_results' => $total_results, 'type_infos' => $this->type_infos));

    }
    public function actionList() {
        $keyword = trim(yii::app()->request->getParam('q', ''));
        $search_type = trim(yii::app()->request->getParam('type', 'song'));
        $page = intval(yii::app()->request->getParam('page', 1));
        $is_search = Yii::app()->request->getParam('is_search', 1);
        $paging = array(
            'page' => $page,
            'recordsPerPage' => !($search_type) ? Yii::app()->params['numberPerPage'] : Yii::app()->params['pageSize']
        );


        $searchType = !($search_type) ? $this->type_infos : array($search_type => '');
        foreach ($searchType as $type => $info) {
            switch ($type) {
                case 'song':
                    $response = SearchHelper::getInstance()->search($keyword, 'song', $paging['recordsPerPage'], ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('name' => 'name', 'artist_name' => 'artist_name'));
                    if ($response->numFound > 0) {
                        $countSong = $response->numFound;
                        $pages = new CPagination($countSong);
                        $pageSize = Yii::app()->params['pageSize'];
                        $pages->params = array('q' => $keyword, 'type' => $type);
                        $pages->setPageSize($pageSize);
                        $topItems = array();
                        $topItemPages = new CPagination(0);

                        $results = $this->getStatistic($results, $type);
                    } else {
                        $pages = new CPagination(0);
                        $pageSize = Yii::app()->params['numberPerPage'];
                        $topItemPages = new CPagination($pageSize);
                        $topItemPages->setPageSize($pageSize);
                        $currentPage = $topItemPages->getCurrentPage();
                        $topItems = null;// WapSongModel::model()->getTopSongsWeek($currentPage * $pageSize, $pageSize);;//WapSongModel::getListHot(1,$pageSize,'filter_sync_status');
                    }

                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
                    );
                    break;
                case 'clip':
                    $response = SearchHelper::getInstance()->search($keyword, 'video', $paging['recordsPerPage'], ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    if ($response->numFound > 0) {
                        $countClip = $response->numFound;
                        $pages = new CPagination($countClip);
                        $pageSize = Yii::app()->params['pageSize'];
                        $pages->params = array('q' => $keyword, 'type' => $type);
                        $pages->setPageSize($pageSize);
                        $topItems = array();
                        $topItemPages = new CPagination(0);

                        $results = $this->getStatistic($results, $type);
                    } else {
                        $pages = new CPagination(0);
                        $pageSize = Yii::app()->params['numberPerPage'];
                        $topItemPages = new CPagination($pageSize);
                        $currentPage = $topItemPages->getCurrentPage();
                        $topItemPages->setPageSize($pageSize);
                        $topItems = null;//WapVideoModel::model()->getTopVideosWeek($currentPage * $pageSize, $pageSize);//WapVideoModel::getListHot(1,$pageSize,'filter_sync_status');
                    }
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
                    );
                    break;
                case 'album':
                    $response = SearchHelper::getInstance()->search($keyword, 'album', $paging['recordsPerPage'], ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    if ($response->numFound > 0) {
                        $countAlbum = $response->numFound;
                        $pages = new CPagination($countAlbum);
                        $pageSize = Yii::app()->params['pageSize'];
                        $pages->params = array('q' => $keyword, 'type' => $type);
                        $pages->setPageSize($pageSize);
                        $topItems = array();
                        $topItemPages = new CPagination(0);

                        $results = $this->getStatistic($results, $type);
                    } else {
                        $pages = new CPagination(0);
                        $pageSize = Yii::app()->params['numberPerPage'];
                        $topItemPages = new CPagination($pageSize);
                        $topItemPages->setPageSize($pageSize);
                        $currentPage = $topItemPages->getCurrentPage();
                        $topItems = null;//WapAlbumModel::model()->getTopAlbumsWeek($currentPage * $pageSize, $pageSize);//WapAlbumModel::getListHot(1,$pageSize);
                    }
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
                    );
                    break;
                case 'artist':
                    $response = SearchHelper::getInstance()->search($keyword, 'artist', $paging['recordsPerPage'], ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    if ($response->numFound > 0) {
                        $countArtist = $response->numFound;
                        $pages = new CPagination($countArtist);
                        $pageSize = Yii::app()->params['pageSize'];
                        $pages->params = array('q' => $keyword, 'type' => $type);
                        $pages->setPageSize($pageSize);
                        $topItems = array();
                        $topItemPages = new CPagination(0);

                        $results = $this->getStatistic($results, $type, 'song_count');
                    } else {
                        $pages = new CPagination(0);
                        $pageSize = Yii::app()->params['numberPerPage'];
                        $topItemPages = new CPagination($pageSize);
                        $currentPage = $topItemPages->getCurrentPage();
                        $topItemPages->setPageSize($pageSize);
                        $topItems = null;//WapArtistModel::model()->getTopArtists($currentPage * $pageSize, $pageSize);
                    }
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
                    );
                    break;
                case 'videoplaylist':
                    $response = SearchHelper::getInstance()->search($keyword, 'videoplaylist', $paging['recordsPerPage'], ($page - 1));
                    $results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
                    if ($response->numFound > 0) {
                        $countArtist = $response->numFound;
                        $pages = new CPagination($countArtist);
                        $pageSize = Yii::app()->params['pageSize'];
                        $pages->params = array('q' => $keyword, 'type' => $type);
                        $pages->setPageSize($pageSize);
                        $topItems = array();
                        $topItemPages = new CPagination(0);
                        $results = $this->getStatistic($results, $type);
                    } else {
                        $pages = new CPagination(0);
                        $pageSize = Yii::app()->params['numberPerPage'];
                        $topItemPages = new CPagination($pageSize);
                        $currentPage = $topItemPages->getCurrentPage();
                        $topItemPages->setPageSize($pageSize);
                        $topItems = null;//WapArtistModel::model()->getTopArtists($currentPage * $pageSize, $pageSize);
                    }
                    $total_results[$type] = array(
                        'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
                    );
                    break;
               
            }
        }
        if ($is_search =='0')
        {
        	$this->render('list_rbt', array('keyword' => $keyword, 'search_type' => $search_type, 'total_results' => $total_results, 'type_infos' => $this->type_infos));
        }
        $this->render('index', array('keyword' => $keyword, 'search_type' => $search_type, 'total_results' => $total_results, 'type_infos' => $this->type_infos));

    }

    public function actionLoadAjax()
    {
		$keyword = trim(yii::app()->request->getParam('q', ''));
		$search_type = $type = trim(yii::app()->request->getParam('type', 'song'));
		$page = intval(yii::app()->request->getParam('page', 1));
		$is_search = Yii::app()->request->getParam('is_search', 1);
		$paging = array(
				'page' => $page,
				'recordsPerPage' => !($search_type) ? Yii::app()->params['numberPerPage'] : Yii::app()->params['pageSize']
		);


		switch ($search_type) {
			case 'song':
				$response = SearchHelper::getInstance()->search($keyword, 'song', $paging['recordsPerPage'], ($page - 1));
				$results = $this->copyAndCast($response->docs, array('name' => 'name', 'artist_name' => 'artist_name'));
				if ($response->numFound > 0) {
					$countSong = $response->numFound;
					$pages = new CPagination($countSong);
					$pageSize = Yii::app()->params['pageSize'];
					$pages->params = array('q' => $keyword, 'type' => $type);
					$pages->setPageSize($pageSize);
					$topItems = array();
					$topItemPages = new CPagination(0);

					$results = $this->getStatistic($results, $type);
				} else {
					$pages = new CPagination(0);
					$pageSize = Yii::app()->params['numberPerPage'];
					$topItemPages = new CPagination($pageSize);
					$topItemPages->setPageSize($pageSize);
					$currentPage = $topItemPages->getCurrentPage();
					$topItems = null;// WapSongModel::model()->getTopSongsWeek($currentPage * $pageSize, $pageSize);;//WapSongModel::getListHot(1,$pageSize,'filter_sync_status');
				}

				$total_results[$type] = array(
						'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
				);
				break;
			case 'clip':
				$response = SearchHelper::getInstance()->search($keyword, 'video', $paging['recordsPerPage'], ($page - 1));
				$results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
				if ($response->numFound > 0) {
					$countClip = $response->numFound;
					$pages = new CPagination($countClip);
					$pageSize = Yii::app()->params['pageSize'];
					$pages->params = array('q' => $keyword, 'type' => $type);
					$pages->setPageSize($pageSize);
					$topItems = array();
					$topItemPages = new CPagination(0);

					$results = $this->getStatistic($results, $type);
				} else {
					$pages = new CPagination(0);
					$pageSize = Yii::app()->params['numberPerPage'];
					$topItemPages = new CPagination($pageSize);
					$currentPage = $topItemPages->getCurrentPage();
					$topItemPages->setPageSize($pageSize);
					$topItems = null;//WapVideoModel::model()->getTopVideosWeek($currentPage * $pageSize, $pageSize);//WapVideoModel::getListHot(1,$pageSize,'filter_sync_status');
				}
				$total_results[$type] = array(
						'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
				);
				break;
			case 'album':
				$response = SearchHelper::getInstance()->search($keyword, 'album', $paging['recordsPerPage'], ($page - 1));
				$results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
				if ($response->numFound > 0) {
					$countAlbum = $response->numFound;
					$pages = new CPagination($countAlbum);
					$pageSize = Yii::app()->params['pageSize'];
					$pages->params = array('q' => $keyword, 'type' => $type);
					$pages->setPageSize($pageSize);
					$topItems = array();
					$topItemPages = new CPagination(0);

					$results = $this->getStatistic($results, $type);
				} else {
					$pages = new CPagination(0);
					$pageSize = Yii::app()->params['numberPerPage'];
					$topItemPages = new CPagination($pageSize);
					$topItemPages->setPageSize($pageSize);
					$currentPage = $topItemPages->getCurrentPage();
					$topItems = null;//WapAlbumModel::model()->getTopAlbumsWeek($currentPage * $pageSize, $pageSize);//WapAlbumModel::getListHot(1,$pageSize);
				}
				$total_results[$type] = array(
						'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
				);
				break;
			case 'artist':
				$response = SearchHelper::getInstance()->search($keyword, 'artist', $paging['recordsPerPage'], ($page - 1));
				$results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
				if ($response->numFound > 0) {
					$countArtist = $response->numFound;
					$pages = new CPagination($countArtist);
					$pageSize = Yii::app()->params['pageSize'];
					$pages->params = array('q' => $keyword, 'type' => $type);
					$pages->setPageSize($pageSize);
					$topItems = array();
					$topItemPages = new CPagination(0);

					$results = $this->getStatistic($results, $type, 'song_count');
				} else {
					$pages = new CPagination(0);
					$pageSize = Yii::app()->params['numberPerPage'];
					$topItemPages = new CPagination($pageSize);
					$currentPage = $topItemPages->getCurrentPage();
					$topItemPages->setPageSize($pageSize);
					$topItems = null;//WapArtistModel::model()->getTopArtists($currentPage * $pageSize, $pageSize);
				}
				$total_results[$type] = array(
						'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
				);
				break;
                    case 'videoplaylist':
				$response = SearchHelper::getInstance()->search($keyword, 'videoplaylist', $paging['recordsPerPage'], ($page - 1));
				$results = $this->copyAndCast($response->docs, array('artist' => 'artist_name'));
				if ($response->numFound > 0) {
					$countArtist = $response->numFound;
					$pages = new CPagination($countArtist);
					$pageSize = Yii::app()->params['pageSize'];
					$pages->params = array('q' => $keyword, 'type' => $type);
					$pages->setPageSize($pageSize);
					$topItems = array();
					$topItemPages = new CPagination(0);

					$results = $this->getStatistic($results, $type);
				} else {
					$pages = new CPagination(0);
					$pageSize = Yii::app()->params['numberPerPage'];
					$topItemPages = new CPagination($pageSize);
					$currentPage = $topItemPages->getCurrentPage();
					$topItemPages->setPageSize($pageSize);
					$topItems = null;//WapArtistModel::model()->getTopArtists($currentPage * $pageSize, $pageSize);
				}
				$total_results[$type] = array(
						'numFound' => $response->numFound, 'results' => $results, 'topItems' => $topItems, 'pages' => $pages, 'topItemPages' => $topItemPages
				);
				break;
			
		}

		$this->layout = false;
		$this->render("_ajaxList",compact('total_results','search_type'));
    }

    private function copyAndCast($array, $mapping) {
        $rs = array();
        foreach ($array as $item) {
            $cast = array();
            foreach ($item as $key => $value) {
                if ($key == 'id') {
                    $cast['id'] = substr($value, strlen($item->type));
                } elseif (array_key_exists($key, $mapping)) {
                    $key = $mapping[$key];
                    if (is_array($key)) {
                        $value = explode('|', $value);
                        for ($index = 0; $index < count($key);) {
                            $key2 = $key[$index++];
                            $cast[$key2] = $value[$key[$index++]];
                        }
                    }else
                        $cast[$key] = $value;
                }else
                    $cast[$key] = $value;
            }
            $rs[] = $cast;
        }
        return $rs;
    }


    /*
     * get played_count/ downloaded_count / song_count
     */

    function getStatistic($results, $type, $statistic_col = 'played_count') {
        $ids = array();
        $data = array();
        //$obj = new ucfirst($type)."Model";
        foreach ($results as $result) {
            $ids[] = intval($result['id']);
            $data[$result['id']] = $result;
            $data[$result['id']][$statistic_col] = 0;
        }
        $ids = implode(',', $ids);
        if($ids){
            $arr_type = $this->type_infos;
            $refCol = $arr_type[$type]['ref_col'];
            $criteria = new CDbCriteria;
            $criteria->condition = " $refCol in ($ids)";
            $items = $arr_type[$type]['class']::model()->findAll($criteria);
            foreach ($items as $item) {
                $data[$item->$refCol][$statistic_col] = $item->$statistic_col;
            }
        }
        return $data;
    }

}