<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/vplayer.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl. '/web/css/player.css');

Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,"
					var page_id = 'album-view';
				",CClientScript::POS_HEAD);

?>
<div class="player-ads">
	<img src="<?php echo Yii::app()->request->baseUrl?>/images/player-ads.png" height="122px" width="100%" />
</div>

<div class="player list-layout">
	<div class="hide-html5">
		<audio controls="controls" preload="auto" id="audio" oncanplay="myOnCanPlayFunction()"
		   oncanplaythrough="myOnCanPlayThroughFunction()"
		   onloadeddata="myOnLoadedData()" ontimeupdate="updateProgressBar()"  type="audio/mpeg">
			<source id="mp3_src" type="audio/mpeg" src="" ></source>
		</audio>
	</div>

	<div class="vp-thumb">
		<img id="vp-avatar" src="http://s2.chacha.vn/artists/s5/310/310.jpg" width="50" height="50px" />
	</div>

	<div class="vp-control">
		<div id="prev"></div>
		<div class="play control before-load" id="play">
			<img width="20" height="28" src="<?php echo Yii::app()->request->baseUrl?>/web/images/loading-small.gif" />
		</div>
		<div class="pause control" id="pause" style="display: none;"></div>
		<div id="next"></div>
	</div>

	<div id="progress">
		<div id="progress_box">
			<div style="" id="load_progress">
				<div style="left: 0px;" id="hand_progress" class="hand-control">
				</div>
				<div style="width: 0px;" id="play_progress">
				</div>
			</div>
		</div>
	</div>
	<div id="play_time">
		<span id="current_time_display">00:00</span>
		<span id="total_time_display">00:00</span>
	</div>
	<div id="song-playing"><?php echo Yii::t('web','Playing'); ?></div>

	<div class="vp-toggles">
		<div id="bt-shuffle" class="bt-shuffle shuffle-off"></div>
	</div>

	<div class="vp-quarity">
		<div class=""></div>
	</div>

	<div class="vp-volume-controls">
		<div class="vp-mute"></div>
		<div class="vp-volume-bar" id="vp-volume-bar">
			<div class="hand-control" id="hand_volume" style="left: 64px;"></div>
			<div class="vp-volume-bar-value" id="vp-volume-bar-value" style="width:100%;"></div>
		</div>
	</div>

	<div class="loading-data" id ="loading-data" style="display: none;">
		<img alt="" src="<?php echo Yii::app()->request->baseUrl?>web/images/loading-small.gif" width="60">
	</div>

</div>


<div class="box_content">
        <ul class="list_song player_album">
            <?php
            $i=0;
            foreach ($songs as $song):
                $urlKey = Common::makeFriendlyUrl($song->name);
                $link = Yii::app()->createUrl("song/view",array("id"=>$song->id,"title"=>$urlKey, 'artist'=>Common::makeFriendlyUrl($song->artist_name)));
                if (!empty($song->song_statistic) && !empty($song->song_statistic->played_count)) {
                    $totalPlay = $song->song_statistic->played_count;
                } else{
                    $totalPlay = 0;
                }
                $duration = isset($song->duration)?$song->duration:250;
                $songName = CHtml::encode($song->name);
                $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->artist_name)));
                $shareLink = Yii::app()->request->getHostInfo().Yii::app()->request->baseUrl . URLHelper::buildFriendlyURL("song", $song->id, $urlKey);
                ?>
                <li class="item item-in-list song-item-<?php echo $i?>" id="item-<?php echo $i?>">
                	<span class="album_order"><?php echo str_pad(($i+1), 2,"0", STR_PAD_LEFT)?></span>
                    <h3><a href="javascript:void(0)" class="name "><?php echo $songName;?></a> -
                    <a href="<?php echo $artistLink;?>" class="singer"><?php echo Formatter::smartCut(CHtml::encode($song->artist_name), 23) ?></a></h3>

                    <?php if(SongModel::model()->isHQ($song->profile_ids)):?>
                        <span class="flr icon_hq"><?php echo Yii::t('web', 'HQ'); ?></span>
                    <?php elseif($song->lossless):?>
                        <span class="flr icon_ll"><?php echo Yii::t('web', 'Lossless'); ?></span>
                    <?php endif;?>
                    <div class="more_action">
                        <ul>
                            <?php if($song->video_id > 0):?>
                                <li>
                                <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                                <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key, "artist"=>Common::makeFriendlyUrl($song->artist_name)));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                                    <i class="icon icon_video"></i>
                                </a>
                                </li>
                            <?php endif;?>
                            <li><a href="javascript:;" title="<?php echo Yii::t('web', 'HQ'); ?>" class="like_song" id="song-<?php echo $song->id?>"><i class="icon icon_like"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Add to playlist'); ?>" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Download'); ?>" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&amp;t=<?php echo urlencode($song->name);?>" target="_blank" title="<?php echo Yii::t('web', 'Share vie facebook'); ?>"><i class="icon icon_share"></i></a></li>
                        </ul>
                    </div>
                    <div class="meta-content hide" style="display: none;">
                        <span class="content_song_id"><?php echo $song->id?></span>
                    </div>
                </li>
            <?php $i++;endforeach;?>
        </ul>
 </div>

<?php
	$albumSongList = array();
	foreach ($songs as $song){

		$mp3 = array();
		$profiles = explode(",", $song->profile_ids);
        $webSongProfile = Yii::app()->params["song.profile.default"]["web"];
        $profiles = array_intersect($profiles, $webSongProfile);
        $songProfile = SongProfileModel::model()->getProfileByIds($profiles);
        //echo "<pre>";print_r(json_decode(CJSON::encode($song)));echo "</pre>";exit();
        $count_profile = count($songProfile);

		for ($i = 0; $i < $count_profile; $i++){
			$songUrl = WebSongModel::model()->getUrlByProfile($song->id, $songProfile[$i]->profile_id, $song->url_key, $song->artist_name);
			if ($i == $count_profile - 1){
				$mp3[$songProfile[$i]->bitrate . 'K'] = array(
						'url'=>$songUrl,
						"default"=>true,
				);
			}else{
				$mp3[$songProfile[$i]->bitrate . 'K'] = array(
							'url'=>$songUrl,
							"default"=>false,
					);
			}
		}

		$albumSongList[] = array(
				"_type"=>"song",
				"id"=>$song->id,
				"code"=>$song->code,
				"name"=>$song->name,
				"url_key"=>$song->url_key,
				"artist_name"=>$song->artist_name,
				"duration"=>$song->duration,
				"avatar"=>AvatarHelper::getAvatar("artist", $song->song_artist[0]->artist_id, 50),
				"mp3"=>$mp3,

		);
	}
?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/vplayer.js?v=1.0"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	var albumObj = {
				id:<?php echo $this->album->id?>,
				name:"<?php echo $this->album->name?>",
				listSong:<?php echo json_encode($albumSongList)?>
			};

	new albumPlayer("audio",albumObj);

	setTimeout(function() {
		//chachaPlayer._play();
	},50);


})
//]]>
</script>


<?php /*

<div id="player">
    <h3>Bạn cần cài đặt Adobe Flash Player để nghe bài hát này</h3>
    <p><a href="http://www.adobe.com/go/getflashplayer" target="_blank"><img src="/flash/images/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>
<!--class='playlist'-->
<ul id="playlist" class="list_song player_album">
    <?php
    $max = min(count($songs), $limit);
    $counter = 0;

    for ($i = 0; $i < $max; $i++):
        $song = $songs[$i];
        if (!isset($song))
            continue;
        elseif(empty($song->name))
            continue;
        $counter++;
        $user_id = (Yii::app()->user->isGuest) ? 0: Yii::app()->user->getId();
        $isLiked = WebFavouriteSongModel::model()->isLiked($user_id, $song->id);
        $urlKey = (!empty($song->url_key))?$song->url_key:Common::makeFriendlyUrl(trim($song->name));
        ?>

    <li id="<?php echo 'song_'.($counter-1);?>" value="<?php echo $song->id;?>">
        <div class="col1 fll">
            <span><?php echo $counter.'.'; ?></span>
            <h3><a class="song-title" href="<?php echo 'javascript:PlayerplaySong('.($counter-1).')';?>" title="<?php echo htmlspecialchars($song->name) ?>">
                    <?php echo Formatter::smartCut(htmlspecialchars($song->name), 25); ?>
                </a>
                <?php if($song->video_id > 0):?>
                    <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                    <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                        <i class="icon icon_video"></i>
                    </a>
                <?php endif;?>
            </h3>
        </div>
        <div class="col2 fll">
            <a href='<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("keyword"=>CHtml::encode($song->artist_name)));?>'
               title="<?php echo htmlspecialchars($song->artist_name) ?>">
                <?php echo Formatter::substring(htmlspecialchars($song->artist_name), " ", 5, 20); ?>
            </a>
        </div>
        <div class="col3 fll"><?php echo Yii::t("web", "{count} lượt nghe", array("{count}" => isset($song->song_statistic) ? $song->song_statistic['played_count'] : 0)); ?></div>
        <div class="col4 flr"><?php echo Formatter::formatDuration(WebSongModel::model()->findByPk($song->id)->duration); ?></div>
        <div class="more_action">
            <ul>
                <li><a href="javascript:;" title="Thích" id="<?php echo 'song-'.$song->id;?>" class="like_song <?php echo ($isLiked)?'liked':'';?>"><i class="icon icon_like"></i></a></li>
                <li><a class="has-ajax-pop reqlogin" title="Tải bài hát" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                <li><a class="has-ajax-pop reqlogin" title="Thêm vào playlist" href="javascript:;" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                <li><a class="has-ajax-pop reqlogin" title="Tải/tặng nhạc chờ" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/rbt", array("id" => $song->id)) ?>"><i class="icon icon_phone"></i></a></li>
                <li><a class="has-ajax-pop reqlogin" title="Tặng bài hát" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/gift", array("id" => $song->id)) ?>"><i class="icon icon_gift"></i></a></li>
                <?php $songLink = Yii::app()->createUrl('/song/view', array('id'=>$song->id, 'title'=>$urlKey)); ?>
				<li><a title="Chi tiết bài hát" href="<?php echo $songLink; ?>" ><i class="icon icon_detail_song"></i></a></li>
            </ul>
        </div>
        <div class="meta-content hide" style="display: none;">
            <span class="content_song_id"><?php echo $song->id?></span>
        </div>
    </li>
<?php endfor; ?>
</ul>
*/?>