        <!--<img src="/images/player.png"  />-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/web/flash/js/swfobject.js"); ?>
<?php
	$playerJs = 'AlbumPlayer.js';
	if ($option == 'playlist') {
		$playerJs = 'PlaylistPlayer.js';	
	} else if ($option == 'collection') {
		$playerJs = 'CollectionPlayer.js';	
	} elseif($option == 'song_list'){
		$playerJs = 'SongListPlayer.js';
	}
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/web/flash/js/" . $playerJs);
?>
<?php if($this->showPlayer):?>
<div id="player">
    <h3><?php echo Yii::t('web', 'You need to install Adobe Flash Player to listen this song'); ?></h3>
    <p><a href="http://www.adobe.com/go/getflashplayer" target="_blank"><img src="/web/flash/images/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>
<?php endif;?>
<!--class='playlist'-->
<ul id="playlist" class="list_song album_song_list">
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
                <li class="item item-in-list song-item-<?php echo $i?>" id="song_<?php echo $i?>" value="<?php echo $song->id ?>">
                	<span class="album_order"><?php echo str_pad(($i+1), 2,"0", STR_PAD_LEFT)?></span>
                    <h3><a href="javascript:PlayerplaySong(<?php echo $i?>)" class="name "><?php echo $songName;?></a> - 
                    <a href="<?php echo $artistLink;?>" class="singer"><?php echo Formatter::smartCut(CHtml::encode($song->artist_name), 23) ?></a></h3>

                    <?php if(SongModel::model()->isHQ($song->profile_ids)):?>
                        <span class="flr icon_hq">HQ</span>
                    <?php elseif($song->lossless):?>
                        <span class="flr icon_ll">Lossless</span>
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
                            <li><a href="javascript:;" title="<?php echo Yii::t('web', 'Like');?>" class="like_song" id="song-<?php echo $song->id?>"><i class="icon icon_like"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Add to playlist');?>" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Download');?>" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&amp;t=<?php echo urlencode($song->name);?>" target="_blank" title="<?php echo Yii::t('web', 'Share via facebook');?>"><i class="icon icon_share"></i></a></li>
                        </ul>
                    </div>
                    <div class="meta-content hide" style="display: none;">
                        <span class="content_song_id"><?php echo $song->id?></span>
                    </div>
                </li>
            <?php $i++;endforeach;?>
</ul>