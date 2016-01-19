<div class="header_box">
    <h2 class="title vertical_align"><?php echo Yii::t('web','Song');?></h2>&nbsp;&nbsp;&nbsp;
    	<a href="javascript:void(0)" onclick="playall('<?php echo $this->type;?>');" class="play_all"><span><?php echo Yii::t('web','playall');?></span></a>
    <div class="flr">
        <ul>
            <li class="mart"><a href="javascript:void(0)" class="load_song_hot <?php echo (strtoupper($this->type) == "HOT") ? " active" : "" ?>" ><?php echo Yii::t('web','Hot');?></a></li>
            <li class="mart">|</li>
            <li class="mart"><a href="javascript:void(0)" class="load_song_new <?php echo (strtoupper($this->type) == "NEW") ? " active" : "" ?>"><?php echo Yii::t('web','New');?></a></li>
            <li><a href="javascript:void(0)" class="song_prev"><i class="icon icon_back"></i></a></li>
            <li><a href="javascript:void(0)" class="song_next"><i class="icon icon_next"></i></a></li>
        </ul>
    </div>
</div>
<div class="content_box">
    <div id="song_mask" style="position: relative;width: 700px;overflow: hidden;min-height: 355px">
        <div id="song_contain" style="position: absolute;width: 1500px;min-height: 355px">
            <?php
            $i = 0;
            foreach ($this->songList as $song):
                $urlKey = ($song->url_key) ? $song->url_key : Common::makeFriendlyUrl(trim($song->name));
                $artist_name = Common::makeFriendlyUrl($song->artist_name);
                $link = Yii::app()->createUrl("song/view", array("id" => $song->id, "title" => $urlKey,"artist"=>$artist));

                if (!empty($song->song_statistic) && !empty($song->song_statistic->played_count)) {
                    $totalPlay = $song->song_statistic->played_count;
                } else {
                    $totalPlay = 0;
                }

                if (fmod($i, 10) == 0) {
                    echo '<ul class="list_song song_page" style="width: 700px;float:left">';
                }
                ?>
                <li>
                    <div class="col1 fll">
                        <h3>
                            <a href="<?php echo $link ?>" title="<?php echo CHtml::encode($song->name); ?>">
                                <?php echo Formatter::smartCut(CHtml::encode($song->name), 23); ?>
                                <?php if(SongModel::model()->isHQ($song->profile_ids)):?>
	                            &nbsp;&nbsp;<i class="hq">HQ</i>
	                            <?php endif;?>
                            </a>
                            <?php if($song->video_id > 0):?>
                            <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                                <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key, "artist"=>Common::makeFriendlyUrl($song->artist_name)));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                                    <i class="icon icon_video"></i>
                                </a>
                            <?php endif;?>
                        </h3>
                    </div>

					<div class="col2 fll" style="height: 35px;">
						<?php
						$artistName = str_replace("-", ",", $song->artist_name);
						$artistList = explode(",", $artistName);
						$j=0;
						foreach ($artistList as $artist):
						$artist = trim($artist);
						?>
						<span>
							<a href="<?php echo Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($artist))); ?>" title="<?php echo CHtml::encode($artist) ?>"><?php echo Formatter::smartCut(CHtml::encode($artist), 23) ?></a>
						</span>
						<?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
						<?php $j++; endforeach;?>
					</div>

                    <div class="col3 fll"><?php echo $totalPlay ?> lượt nghe</div>
                    <div class="col4 flr"><?php echo Formatter::formatDuration($song->duration) ?></div>
                    <div class="more_action content_action">
                        <ul>
                            <li><a href="javascript:;" title="<?php echo Yii::t("web", "Like"); ?>" class="like_song" id="song-<?php echo $song->id ?>"><i class="icon icon_like"></i></a></li>
                            <li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Download"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                            <li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Add to playlist"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                            <li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Download/gift rbt"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/rbt", array("id" => $song->id)) ?>" ><i class="icon icon_phone"></i></a></li>
                            <li><a class="has-ajax-pop reqlogin" title="<?php echo Yii::t("web", "Gift ringbacktone"); ?>" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/gift", array("id" => $song->id)) ?>"><i class="icon icon_gift"></i></a></li>
                            <?php $shareLink = Yii::app()->request->getHostInfo().Yii::app()->request->baseUrl . URLHelper::buildFriendlyURL("song", $song->id, $urlKey);?>
                            <li><a title="<?php echo Yii::t('web', 'Share via facebook'); ?>" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&amp;t=<?php echo urlencode($song->name);?>" target="_blank"><i class="icon icon_share"></i></a></li>
                        </ul>
                    </div>
                    <div class="meta-content hide" style="display: none;">
                        <span class="content_song_id"><?php echo $song->id ?></span>
                    </div>
                </li>
                <?php
                if (fmod($i, 10) == 9 || $i == count($this->songList) - 1) {
                    echo '</ul>';
                }
                $i++;
            endforeach;
            ?>
        </div>
    </div>
</div>
<div>
<a style="float: right" href="<?php echo Yii::app()->createUrl("/song/index");?>">
    		<span class="fs11 vertical_align gray_color" >Xem thêm <i class="icon icon_mt"></i></span>
    	</a>
</div>