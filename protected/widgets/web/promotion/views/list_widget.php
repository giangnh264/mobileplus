<div class="<?php echo $this->class;?>">
    <?php if(!empty($this->title)){?>
    <div class="box_title">
        <h2 class="name"><a href="<?php echo $this->link?>"><?php echo Yii::t('web',CHtml::encode($this->title));?></a></h2>

        <?php if($this->playall && (count($this->songList) > 0)){?>
            <?php if(!empty($this->playall_url)){?>
                <a style="margin-top: 10px;" class="btn_playall" href="<?php echo $this->playall_url; ?>"><i class="icon icon_All"></i><?php echo Yii::t('web', 'Play All')?></a>
                <?php }else{?>
                <a class="btn_playall" href="<?php echo Yii::app()->createUrl("/playall/song",array("url_key"=>Common::makeFriendlyUrl(CHtml::encode($this->title)),"page"=>$currPage, "type"=>CHtml::encode($this->type))); ?>"><i class="icon icon_All"></i><?php echo Yii::t('web', 'Play All')?></a>
                <?php }?>
        <?php }?>
        <!-- option type -->
        <?php if($this->show_type){?>
        <div class="flr">
            <ul class="btn_ty">
                <li><a href="<?php if($this->page=='song') echo Yii::app()->createUrl("song/index",array("type"=>'NEW')); else echo 'javascript:;';?>" class="pre <?php echo (strtoupper($this->type)=="NEW")?" active":""?>"><?php echo Yii::t('web', 'New'); ?></a></li>
                <li><i class="icon icon_s"></i></li>
                <li><a href="<?php if($this->page=='song') echo Yii::app()->createUrl("song/index",array("type"=>'HOT')); else echo 'javascript:;';?>" class="next <?php echo (strtoupper($this->type)=="HOT")?" active":""?>"><?php echo Yii::t('web', 'Hot'); ?></a></li>
            </ul>
        </div>
        <?php }?>
    </div>
    <?php }?>
    <div class="box_content">
        <?php if ($this->songList): ?>
        <ul class="list_song">
            <?php foreach ($this->songList as $song):
                $urlKey = Common::makeFriendlyUrl($song->name);
                $artist_name = Common::makeFriendlyUrl($song->artist_name);
                $link = Yii::app()->createUrl("song/view",array("id"=>CHtml::encode($song->id),"title"=>CHtml::encode($urlKey),'artist'=>CHtml::encode($artist_name)));
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
                <li style="height: inherit;">
                    <h3 class="over-text"><a href="<?php echo $link; ?>" class="name" title="<?php echo $songName;?>"><?php echo $songName;?></a> -
                        <?php
                        $j=0;
                        $artistList = explode(",", $song->artist_object);
                        foreach ($artistList as $item):
                            $artists = explode("|", $item);
                            $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
                            $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
                            ?>
                            <a href="<?php echo $artistLink;?>" class="singer"><?php echo CHtml::encode($artists[1]) ?></a>
                            <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                            <?php $j++;?>
                        <?php endforeach;?>
                    </h3>

                    <?php if(SongModel::model()->isHQ($song->profile_ids)):?>
                        <span class="flr icon_hq"><?php echo Yii::t('web', 'HQ'); ?></span>
                    <?php elseif(isset($song->lossless)):?>
                        <span class="flr icon_ll"><?php echo Yii::t('web', 'Lossless'); ?></span>
                    <?php endif;?>
                    <div class="more_action">
                        <ul>
                            <?php if(isset($song->video_id) && $song->video_id > 0):?>
                                <li>
                                <?php $video_key = (empty($song->video_name))?$urlKey:Common::makeFriendlyUrl(trim($song->video_name));?>
                                <a href="<?php echo Yii::app()->createUrl('video/view', array('id'=>$song->video_id, 'title'=>$video_key, "artist"=>Common::makeFriendlyUrl($song->artist_name)));?>" title="<?php echo htmlspecialchars($song->name) ?>">
                                    <i class="icon icon_video"></i>
                                </a>
                                </li>
                            <?php endif;?>
                            <li><a href="javascript:;" title="<?php echo Yii::t('web', 'Like'); ?>" class="like_song" id="song-<?php echo $song->id?>"><i class="icon icon_like"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Add to playlist'); ?>" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                            <li><a href="javascript:;" class="has-ajax-pop reqlogin" title="<?php echo Yii::t('web', 'Download'); ?>" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&amp;t=<?php echo urlencode($song->name);?>" target="_blank" title="<?php echo Yii::t('web', 'Share via facebook'); ?>"><i class="icon icon_share"></i></a></li>
                        </ul>
                    </div>
                    <div class="meta-content hide" style="display: none;">
                        <span class="content_song_id"><?php echo CHtml::encode($song->id);?></span>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
        <?php else:?>
            <p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif; ?>
    </div>
</div>