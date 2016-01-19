<?php
class AjaxController extends Controller {
	public function actionIndex() {
		if (Yii::app ()->request->isPostRequest) {
			$doAction = Yii::app ()->request->getParam ( 'action' );
			if (method_exists ( $this, $doAction )) {
				$this->$doAction ();
			} else {
				echo "Method is not exits!";
				Yii::app ()->end ();
			}
		}
	}
	/* Danh sách bài hát đang nghe nhiều */
	function topListen() {
		$songs = WebSongPlayModel::model ()->getTop ( 5 );
		$this->renderPartial ( "_topListen", compact ( "songs" ) );
	}

	/* BXH bài hát, video,albumn */
	function chart() {
		$type = Yii::app ()->request->getParam ( '_type', 'song' );
        $genre = Yii::app ()->request->getParam ( 'genre', 'VN' );
		if($type=='video'){
			$collectionCodeDefault = 'BXH_VIDEO_'.strtoupper($genre);
		}elseif($type=='song'){
			$collectionCodeDefault = 'BXH_SONG_'.strtoupper($genre);
		}else{
			$collectionCodeDefault = 'BXH_ALBUM_'.strtoupper($genre);
		}
                $cacheId = "collection_".$type."_".$genre."_".$collectionCodeDefault;
                $collectionCode = Yii::app()->cache->get($cacheId);
                if($collectionCode === FALSE){
                    $collection = CollectionModel::model()->getCollectionByType($type, "bxh", $genre, 0);
                    $collection = ($collection) ? $collection[0] : null;
                    $collectionCode = ($collection) ? $collection->code : $collectionCodeDefault;
                    Yii::app()->cache->set($cacheId, $collectionCode, Yii::app()->params['cacheTime']);
                }
		switch ($type) {
			case "video" :
				$view = "_videoChart";
				//$data = MainContentModel::getListByCollection ( 'BXH_VIDEO', 1, 10 );
				//$collectionCode = ($collection) ? $collection->code : 'BXH_VIDEO';
                //$collectionCode = 'BXH_VIDEO_'.$genre;
                                $data = Yii::app()->cache->get("video_chart_".$collectionCode);
                                if($data === FALSE){
                                    $data = MainContentModel::getListByCollection($collectionCode, 1, 10);
                                    Yii::app()->cache->set("video_chart_".$collectionCode, $data, Yii::app()->params['cacheTime']);
                                }
				break;
			case "album" :
				$view = "_albumChart";
				//$data = MainContentModel::getListByCollection ( 'ALBUM_HOT', 1, 10 );
				//$collectionCode = ($collection) ? $collection->code : 'ALBUM_HOT';
				//$collectionCode = 'BXH_ALBUM_'.$genre;
                                $data = Yii::app()->cache->get("album_chart_".$collectionCode);
                                if($data === FALSE){
                                    $data = MainContentModel::getListByCollection($collectionCode, 1, 10);
                                    Yii::app()->cache->set("album_chart_".$collectionCode, $data, Yii::app()->params['cacheTime']);
                                }
				break;
			case "song" :
			default :
				$view = "_songChart";
				//$data = MainContentModel::getListByCollection ( 'BXH_SONG', 1, 10 );
				//$collectionCode = ($collection) ? $collection->code : 'BXH_SONG_VN';
                //$collectionCode = 'BXH_SONG_'.$genre;
                                $data = Yii::app()->cache->get("song_chart_".$collectionCode);
                                if($data === FALSE){
                                    $data = MainContentModel::getListByCollection($collectionCode, 1, 10);
                                    Yii::app()->cache->set("song_chart_".$collectionCode, $data, Yii::app()->params['cacheTime']);
                                }
				
				break;
		}
		$this->renderPartial ( $view, compact ( "data","collection","collectionCode","genre") );
	}
	
	/* BXH albumn or video: VN, CHAUA, AUMY */
	function chartByType() {
		$type = Yii::app ()->request->getParam ( '_type', 'song' );
		$district = Yii::app ()->request->getParam ( '_district', 'VN' );
		$collection = CollectionModel::model()->getCollectionByType($type, "bxh", $district, 0);
		$collection = ($collection) ? $collection[0] : null;
	
		switch ($type) {
			case "video" :
				$view = "_videoChart";
				$collectionCode = ($collection) ? $collection->code : 'BXH_VIDEO';
				$data = MainContentModel::getListByCollection($collectionCode, 1, 10);
				break;
			case "album" :
				$view = "_albumChartForAlbumPage";
				$collectionCode = ($collection) ? $collection->code : 'ALBUM_HOT';
				$data = MainContentModel::getListByCollection($collectionCode, 1, 10);
				break;
			case "song" :
			default :
				$view = "_songChartForSongPage";
				$collectionCode = ($collection) ? $collection->code : 'BXH_SONG_VN';
				$data = MainContentModel::getListByCollection($collectionCode, 1, 10);
				break;
		}
	
		$this->renderPartial ( $view, compact ( "data","collection") );
	}

	/* Danh sách album mới - HOT */
	function album() {
		$type = Yii::app ()->request->getParam ( '_type', 'hot' );
		if ($type == 'hot') {
			$albums = MainContentModel::getListByCollection ( 'ALBUM_HOT', 1, 12 );
		} else {
			$albums = MainContentModel::getListByCollection ( 'ALBUM_NEW', 1, 12 );
		}
		$this->renderPartial ( "_album", compact ( 'albums', 'type' ) );
	}
	
	/* Danh sách album mới - HOT theo VietNam, Au My, Chau A*/
	function albumByDistrict() {
		$type = Yii::app ()->request->getParam ( '_type', 'hot' );
		$district = Yii::app ()->request->getParam ( '_district', 'VN' );
		$district = CHtml::encode($district);
		$type = CHtml::encode($type);
		if ($type == 'hot') {
			$albums = MainContentModel::getListByCollectionByDistrict ( 'ALBUM_HOT', $district, 1, 8);
		} else {
			$albums = MainContentModel::getListByCollectionByDistrict ( 'ALBUM_NEW', $district, 1, 8);
		}
		$this->renderPartial ( "_albumByDistrict", compact ( 'albums', 'type', 'district') );
	}

	/* Danh sách video NEW - HOT */
	function video() {
		$type = Yii::app ()->request->getParam ( '_type', 'hot' );
		if ($type == 'hot') {
			$videos = MainContentModel::getListByCollection ( 'VIDEO_HOT', 1, 12 );
		} else {
			$videos = MainContentModel::getListByCollection ( 'VIDEO_NEW', 1, 12 );
		}
		$this->renderPartial ( "_video", compact ( 'videos', 'type' ) );
	}

	/* Danh sách song NEW - HOT */
	function song() {
		$type = Yii::app ()->request->getParam ( '_type', 'hot' );
		if ($type == 'hot') {
			$songs = MainContentModel::getListByCollection ( 'SONG_HOT', 1, 20 );
		} else {
			$songs = MainContentModel::getListByCollection ( 'SONG_NEW', 1, 20 );
		}
		$this->renderPartial ( "_song", compact ( 'songs', 'type' ) );
	}

	/* Danh sach bai hat cung album */
	function songInAlbum() {
		$songId = Yii::app ()->request->getParam ( 'song_id' );
		if ($songId) {
			$songs = WebAlbumModel::model ()->getAlbumBySong ( $songId );
			$album = WebAlbumSongModel::model ()->getAlbumIdBySong ( $songId );
			$album = ($album) ? $album->album : NULL;
			if (! empty ( $songs )) {
				$this->renderPartial ( "_songInAlbum", compact ( "songs", "album" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach bai hat cung ca sy */
	function songByArtist() {
		$artistId = Yii::app ()->request->getParam ( 'artist_id' );
		if ($artistId) {
			$songs = WebSongModel::model ()->getSongbyArtist ( $artistId, 10, 0, true);
			if (! empty ( $songs )) {
				$this->renderPartial ( "_songByArtist", compact ( "songs" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach bai hat lien quan toi tin tuc */
	function songByArtists() {
		$artistIds = Yii::app ()->request->getParam ( 'artist_ids' );

		if ($artistIds) {
			$songs = WebSongModel::model ()->getSongsByArtistIds ( $artistIds, 10 );
			if (! empty ( $songs )) {
				$this->renderPartial ( "_songByGenre", compact ( "songs" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach bai hat cung ca sy, random trong danh sách artist */
	function songForArtistInfo() {
		$songList = Yii::app()->request->getParam('song_ids',array());
		$c = new CDbCriteria();
		$c->addInCondition("id", $songList);
		$songs = WebSongModel::model()->findAll($c);
		$i=0;
		$arrSongsByArtist = array();
		foreach($songs as $song){
			$link = Yii::app ()->createUrl ( "song/view", array ("id" => $song->id,"title" => trim ( $song->url_key, "-" )));
			$html = '<a href="' . $link. '"><i class="icon icon_song"></i>' . $song->name . '</a>';
			$arrSongsByArtist [$i] ['song_id'] = $song->id;
			$arrSongsByArtist [$i] ['html'] = $html;
			$i++;
		}
		header("Content-type: application/json");
		echo json_encode ( $arrSongsByArtist );
		Yii::app ()->end ();
	}

	/* Danh sach video lien quan toi tin tuc */
	function videosByArtists() {
		$artistIds = Yii::app ()->request->getParam ( 'artist_ids' );
		if ($artistIds) {
			$videos = WebVideoModel::model ()->getVideoByArtists ( $artistIds );
			if (! empty ( $videos )) {
				$this->renderPartial ( "_videoByArtists", compact ( "videos" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach bai hat theo the loai */
	function songByGenre() {
		$genreId = Yii::app ()->request->getParam ( 'genre_id' );
		if ($genreId) {
			$songs = WebGenreModel::model ()->getSongbyGenre ( $genreId, 10, 0, true );
			if (! empty ( $songs )) {
				$this->renderPartial ( "_songByGenre", compact ( "songs" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach bai hat da like cua user */
	function loadLikeSong() {
		$msisdn = Yii::app()->user->phone;
		//$songList = Yii::app ()->request->getParam ( '_data' );
		$songLiked = WebFavouriteSongModel::model ()->getSongLike ( $msisdn );
		header ( "Content-type: application/json" );
		echo json_encode ( $songLiked );
		Yii::app ()->end ();
	}

	/* Danh sach video da like cua user */
	function loadLikeVideo() {
		$msisdn = Yii::app()->user->phone;
		//$songList = Yii::app ()->request->getParam ( '_data' );
		$videoLiked = WebFavouriteVideoModel::model ()->getVideoLike ( $msisdn );
		header ( "Content-type: application/json" );
		echo json_encode ( $videoLiked );
		Yii::app ()->end ();
	}

	/* Danh sach album da like cua user */
	function loadLikeAlbum() {
		$msisdn = Yii::app()->user->phone;
		$albumLiked = WebFavouriteAlbumModel::model ()->getAlbumLike ( $msisdn );
		header ( "Content-type: application/json" );
		echo json_encode ( $albumLiked );
		Yii::app ()->end ();
	}

	function like_unlike_song() {
		$song_id = Yii::app ()->request->getParam ( 'id' );
		if (! Yii::app ()->user->isGuest) {
			$msisdn = Yii::app()->user->phone;
            $ret = WebFavouriteSongModel::model()->doLikeSong($msisdn,$song_id);
			echo $ret;
		}
		Yii::app ()->end ();
	}

	/* BEGIN get content for artist view page */
        /*GET song list by artistId*/
	function artistSongs() {
		$artistId = Yii::app ()->request->getParam ( 'artist_id' );
		if ($artistId) {
			$songs = WebSongModel::model ()->getSongbyArtist ( $artistId, Yii::app ()->params ['constLimit'] ['numberSongsInArtistPage'], 0 );
			if (! empty ( $songs )) {
				$this->renderPartial ( "_artistSongs", compact ( "songs" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* GET video list by artistId */
	function artistVideos() {
		$artistId = Yii::app ()->request->getParam ( 'artist_id' );
		if ($artistId) {
			$videos = WebVideoModel::model ()->getHotVideobyArtist ( $artistId, Yii::app ()->params ['constLimit'] ['numberVideosInArtistPage'], 0 );
			if (! empty ( $videos )) {
				$this->renderPartial ( "_artistVideos", compact ( "videos" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}
	/* GET album list by artistId */
	function artistAlbums() {
		$artistId = Yii::app ()->request->getParam ( 'artist_id' );
		if ($artistId) {
			$albums = WebAlbumModel::model ()->getAlbumbyArtist ( $artistId, Yii::app ()->params ['constLimit'] ['numberAlbumsInArtistPage'], 0 );
			if (! empty ( $albums )) {
				$this->renderPartial ( "_artistAlbums", compact ( "albums" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach ca sỹ theo the loai */
	function artistByGenre() {
		$genreId = Yii::app ()->request->getParam ('genre_id' );
		$exclusion = $artistId = Yii::app ()->request->getParam ('artist_id', 0);
		if ($genreId) {
			$artists = WebArtistModel::model()->getRelatedArtists($genreId, $artistId, 6, 0);
			if (! empty ( $artists )) {
				$this->renderPartial ( "_artistByGenre", compact ( "artists", "exclusion" ) );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}

	/* Danh sach ca sỹ theo the loai */
	function favouriteUsers() {
		$id = Yii::app ()->request->getParam ('id' );
		$limit = 9;
		$boxName = Yii::t('web',"Fan");
		if ($id) {
			$users = WebArtistFanModel::model()->getArtistFanUsers($id, $limit, 0);
			if (! empty ( $users )) {
				$this->renderPartial ( "_favouriteUsers", compact ( "users", "limit", "boxName") );
				Yii::app ()->end ();
			}
		}
		echo "";
		Yii::app ()->end ();
	}
	/* END get content for artist view page */

        /*GET song lyric*/
	function songLyric() {
		$songId = Yii::app ()->request->getParam ( 'song_id' );
		if ($songId) {
			$song = WebSongModel::model ()->published ()->with ( "song_extra", "song_statistic" )->findByPk ( $songId );
			if (isset ( $song ))
				$songExtra = $song->song_extra;
				$this->renderPartial ( "_songLyric", compact ( "songExtra",'song' ) );
				Yii::app ()->end ();
		}
		Yii::app ()->end ();
	}
	/* END get content for artist view page */
	public function getListBanner() {

		header ( "Content-type: application/json" );
		$banners = WebBannerModel::getBanner ( 'web' );
		$data = array ();
		if (count ( $banners ) > 0) {
			foreach ( $banners as $key => $value ) {
				$data ['banner_' . $value ['position']][] = $value;
			}
			foreach ($data as $key => $value){
				if(count($value)>1){
					//random
					$maxKey = count($value)-1;
					$randKey = rand(0, $maxKey);
					$val = $value[$randKey];
					$data[$key] = $val;
				}else{
					$data[$key] = $value[0];
				}
			}
		}
		echo CJSON::encode ( $data );
		Yii::app ()->end ();
	}

	/* like_unlike album */
	function like_unlike_album() {
		$album_id = Yii::app ()->request->getParam ( 'id' );
		$type = Yii::app ()->request->getParam ( 'type', 'like' );
        if (! Yii::app ()->user->isGuest) {
			$msisdn = Yii::app()->user->phone;
            $ret = WebFavouriteAlbumModel::model()->doLikeAlbum($msisdn, $album_id);
            echo $ret;
        }
		Yii::app ()->end ();
	}

	/* like_unlike artist */
	function like_unlike_artist() {
		$artist_id = Yii::app ()->request->getParam ( 'artist_id' );
		$type = Yii::app ()->request->getParam ( 'type', 'like' );
		if (! Yii::app ()->user->isGuest) {
			$user_id = Yii::app ()->user->getId ();
			if ($type == 'like') {
				$ret = WebArtistFanModel::model ()->likeArtist ( $user_id, $artist_id );
				if ($ret == 1)
					echo "liked";
				else
					echo "isliked";
			} else {
				WebArtistFanModel::model ()->unlikeArtist ( $user_id, $artist_id );
				echo "unliked";
			}
		}
		Yii::app ()->end ();
	}

	/* like_unlike video */
	function like_unlike_video() {
		$video_id = Yii::app ()->request->getParam ( 'id' );
		$type = Yii::app ()->request->getParam ( 'type', 'like' );
		if (! Yii::app ()->user->isGuest) {
			$msisdn = Yii::app()->user->phone;
            $ret = WebFavouriteVideoModel::model()->doLikeVideo($msisdn, $video_id);
            echo $ret;
		}
		Yii::app ()->end ();
	}

	/* like_unlike video playlist*/
	function like_unlike_video_playlist() {
		$video_id = Yii::app ()->request->getParam ( 'id' );
		$type = Yii::app ()->request->getParam ( 'type', 'like' );
		if (! Yii::app ()->user->isGuest) {
			$msisdn = Yii::app()->user->phone;
            $ret = WebFavouriteVideoPlaylistModel::model()->doLikeVideo($msisdn, $video_id);
            echo $ret;
		}
		Yii::app ()->end ();
	}
        
        /* Danh sách videoByGenre NEW - HOT */
	function videoByGenre() {
		$type = Yii::app ()->request->getParam ( '_type', 'hot');
                $district = Yii::app ()->request->getParam ( '_district', 'VN');
                
//                $genre = Yii::app ()->request->getParam ( '_genre', '');
//                $genreIds = explode(',', $genre);
                $title = 'video';
                if($district =='VN')
                    $title=Yii::t('web','Khmer');
                elseif($district =='AUMY')
                    $title=Yii::t('web','US-UK');
                elseif($district =='CHAUA')
                    $title=Yii::t('web','Châu á');
                    
		$this->renderPartial("_videoByGenre", compact('district','type','title'));
	}
        function videoplaylist(){
            $type = Yii::app ()->request->getParam ( '_type', 'hot' );
            $limit  = Yii::app ()->request->getParam ( 'limit', 20 );
            
            if ($type == 'hot') {
                    $items = MainContentModel::getListByCollection ( 'VIDEO_PLAYLIST_HOT', 1, $limit );
            } else {
                    $items = MainContentModel::getListByCollection ( 'VIDEO_PLAYLIST_NEW', 1, $limit );
            }
            $this->renderPartial ( "_videoplaylist", compact ( 'items', 'type' ) );
        }
        
        function videoplaylistbox(){
            $type = Yii::app ()->request->getParam ( '_type', 'hot' );
            $limit  = Yii::app ()->request->getParam ( 'limit', 20 );
            
            if ($type == 'hot') {
                    $items = MainContentModel::getListByCollection ( 'VIDEO_PLAYLIST_HOT', 1, $limit );
            } else {
                    $items = MainContentModel::getListByCollection ( 'VIDEO_PLAYLIST_NEW', 1, $limit );
            }
            $this->renderPartial ( "_videoplaylistbox", compact ( 'items', 'type' ) );
        }

	public function actionCheckUser(){
		$return = array();
		if(Yii::app()->user->isGuest){
			$return['error_code'] = 1;
		}else{
			$phone =  Yii::app()->user->phone;
			$subscribe = WebUserSubscribeModel::model()->with("package")->get(Formatter::formatPhone($phone));
			if($subscribe){
				$return['error_code'] = 0;
			}else $return['error_code'] = 2;
		}

		header ( "Content-type: application/json" );
		echo json_encode ( $return );
		Yii::app ()->end ();
	}

	function Radio(){
		$time = time();
		$dateTimeFormat = Common::getFormatTime($time);
                $ip = $_SERVER['REMOTE_ADDR'];
                //$ip = '118.70.124.143';
                $cacheId = "radio_ip_".$ip;
                $radios = Yii::app()->cache->get($cacheId);
                if($radios === FALSE){
                    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
                    if(isset($details->loc)){
                        $strLoc = $details->loc;
                        $local = explode(',', $strLoc);
                        $xLong = $local[0];
                        $yLong = $local[1];
                        $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
                        $yql_query = 'SELECT * FROM geo.placefinder WHERE text="' . $xLong . ', ' . $yLong . '" and gflags="R"';
                        $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
                        $yql_query_url .= "&format=json";
                        $session = curl_init($yql_query_url);
                        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                        $json = curl_exec($session);
                        $dataDecode = json_decode($json);
                        $weatherCode = 0;
                        $woeid = 0;
                        $city = 'Fail';
                        if (!is_null($dataDecode->query->results) && $dataDecode->query->count == 1) {
                            // Safe to parse data
                            $woeid = $dataDecode->query->results->Result->woeid;
                            $urlWeather = 'http://weather.yahooapis.com/forecastrss?w=' . $woeid . '&u=c';
                            $city = $this->getCity($urlWeather);
                            $doc = new DOMDocument();
                            $doc->load($urlWeather);
                            $channel = $doc->getElementsByTagName("channel");
                            foreach ($channel as $chnl) {
                                $item = $chnl->getElementsByTagName("item");
                                foreach ($item as $itemgotten) {
                                    $weatherCode = $itemgotten->getElementsByTagNameNS("http://xml.weather.yahoo.com/ns/rss/1.0", "condition")->item(0)->getAttribute("code");
                                }
                            }
                            $sql = "
                                    (SELECT * FROM radio
                                    WHERE time_point like '%{$dateTimeFormat['TP']}%' AND day_week like '%{$dateTimeFormat['DOW']}%' and status=1
                                    ORDER BY ordering ASC
                                    LIMIT 4)
                                    UNION DISTINCT
                                    (SELECT c1.*
                                    FROM radio c1
                                    LEFT JOIN radio_weather c2 ON c1.id=c2.radio_id
                                    LEFT JOIN weather c3 ON c2.weather_id = c3.id
                                    WHERE c3.code = :code and c1.status=1)
                            ";
                            $cm = Yii::app()->db->createCommand($sql);
                            $cm->bindParam(':code', $weatherCode, PDO::PARAM_STR);
                            $radios = $cm->queryAll();
                            Yii::app()->cache->set($cacheId, $radios, Yii::app()->params['cacheTime']);
                        }
                    }
                    
                }
                
                // default
                if(!$radios){
                    $sql = "SELECT * FROM radio
                            WHERE time_point like '%{$dateTimeFormat['TP']}%' AND day_week like '%{$dateTimeFormat['DOW']}%' and status=1
                            ORDER BY ordering ASC
                            LIMIT 4
                            ";
                    $command = Yii::app()->db->createCommand($sql);
                    $radios = $command->queryAll();
                }
		$this->renderPartial ( "_radio", compact ( 'radios','dateTimeFormat' ) );
	}
	function Herocopes(){
		$id = Yii::app()->params['horoscope']['parent_id'];
		$limit = 4;
		$criteria = new CDbCriteria();
		$criteria->condition = "parent_id=".$id . " AND status = ".RadioModel::_ACTIVE;
		$criteria->order = "RAND()";
		$criteria->limit = $limit;
		$radioList = RadioModel::model()->findAll($criteria);
		$this->renderPartial ( "_herocopes", compact ( 'radioList' ) );
	}
        
        private function getCity($weatherLink) {
            $city = 'fail';
            if ($fp = fopen($weatherLink, 'r')) {
                $content = '';
                while ($line = fread($fp, 1024)) {
                    $content .= $line;
                }
            }
            // Get city name
            $wrss = $content;
            $spos = strpos($wrss, 'yweather:location city="') + strlen('yweather:location city="');
            $epos = strpos($wrss, '"', $spos);
            if ($epos > $spos) {
                $city = substr($wrss, $spos, $epos - $spos);
            }
            return $city;
        }

	public function actionSetCookies()
	{
		$type = Yii::app()->request->getParam('type');
		$day = Yii::app()->request->getParam('day',1);
		if($type=='popup_km'){
			$_SESSION['already_popupkm'] = 1;
			$cookie = new CHttpCookie('showPopupKm', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopupKm'] = $cookie;
		}elseif($type=='popup_not_km'){
			$_SESSION['already_popup'] = 1;
			$cookie = new CHttpCookie('showPopup', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopup'] = $cookie;
		}elseif($type=='popup_ctkm'){
			$_SESSION['already_popup_ctkm'] = 1;
			$cookie = new CHttpCookie('showPopupCTKm', 1);
			$cookie->expire = time() + 60 * 60 * 24 * $day;
			Yii::app()->request->cookies['showPopupCTKm'] = $cookie;
		}
	}

	public function actionLimitCtkm(){
		$userPhone = Yii::app()->user->getState('phone');
		$userPhone = Formatter::formatPhone($userPhone);
        $user_sub = UserSubscribeModel::model()->get($userPhone);
		if(!$user_sub && !empty($userPhone)){
			$promotion = 0;
			$check_promotion = UserSubscribeModel::model()->check_promotion($userPhone);
			if($check_promotion){
				$promotion = 1;
			}
			$session = isset(Yii::app()->session['free_ctkm'])? Yii::app()->session['free_ctkm'] : 1;
			Yii::app()->session['free_ctkm']  = Yii::app()->session['free_ctkm'] + 1;
			$data = array(
				'session'=>$session,
				'promotion'=>$promotion,
			);
			header("Content-type: application/json");
			echo json_encode($data);
		}else{
			echo json_encode(new stdClass());
		}
		Yii::app()->end();

	}
}

?>