<div class="nhacvnplayer album-player-touch player">
    <div id='<?php echo $this->id;?>'></div>
    <div style="color: rgb(255, 255, 255);" id="control-button">
        <div id="repeat">Repeat</div>
        <div id="playone" style="display: none;">Play One</div>
        <div id="prev">Back</div>
        <div class="play control" id="play" style="">Play</div>
        <div style="display: none;" class="pause control" id="pause">Pause</div>
        <div id="next">Next</div>
        <div id="sequence">Sequence</div>
        <div id="shuffle" style="display: none;">Shuffle</div>
    </div>
    <div class="clear"></div>
<div class="box_content">
    <ul id="playlist" class="<?php echo $this->classScroll;?> list_song album_song_list">
        <?php
        $songs = $this->songs;
        $i=0;
        if($songs) {
            Yii::app()->SEO->addMetaProp('music:song_count', count($songs));
            foreach ($songs as $song) {
                $obj = array("obj_type" => 'song', 'name' => $song->name, 'id' => $song->id, 'artist' => $song->artist_name);
                $link = URLHelper::makeUrl($obj);
                Yii::app()->SEO->addMetaProp('music:song', $link);
                Yii::app()->SEO->addMetaProp('music:song:track', ($i+1));

                $duration = isset($song->duration) ? $song->duration : 250;
                $songName = CHtml::encode($song->name);
                $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->artist_name)));
                $urlKey = !empty($song->url_key) ? $song->url_key : Common::makeFriendlyUrl($song->name);
                $shareLink = $link;
                ?>
                <li class="item item-in-list song-item-<?php echo $i ?>" id="song_<?php echo $song->id ?>"
                    value="<?php echo $song->id ?>">

                    <a onClick="javascript: playThis('<?php echo $i;?>');return false" href="<?php echo $link;?>" title="<?php echo $songName?>">
                        <span class="album_order"><?php echo str_pad(($i + 1), 2, "0", STR_PAD_LEFT) ?></span>

                        <h3><?php echo $songName; ?></h3>
                        <div class="artist"><a href="<?php echo $artistLink; ?>" class="singer"><?php echo Formatter::smartCut(CHtml::encode($song->artist_name), 23) ?></a></div>

                        <div class="meta-content hide" style="display: none;">
                            <span class="content_song_id"><?php echo $song->id ?></span>
                        </div>
                        <div style="display: none" id="lyrics-<?php echo $song->id;?>"><?php echo $song->lyrics;?></div>
                        <div class="more_action_wap">
                            <ul>
                                <li style="padding-left: 10px !important;">
                                    <a href="javascript:;"  title="<?php echo Yii::t('wap','Thêm vào playlist');?>" rel="" onclick="VegaCoreJs.addSongPlaylist('<?php echo Yii::app()->createUrl('/ajax/getPopupPlaylist', array('song_id' => $song['id'])); ?>');">
                                        <i class="icon icon_add"></i>
                                    </a>
                                </li>
                                <li style="padding-left: 10px !important;"><a href="<?php echo $link;?>" target="_blank" title="<?php echo Yii::t('wap','Đến trang bài hát ')." '".CHtml::encode($song->name)."'"; ?>"><i class="icon icon_detail"></i></a></li>
                            </ul>
                        </div>
                    </a>

                    <div class="meta-content hide" style="display: none;">
                        <span class="content_song_id"><?php echo $song->id ?></span>
                    </div>
                </li>
                <?php $i++;
            }
        }
        ?>
    </ul>
</div>
</div>