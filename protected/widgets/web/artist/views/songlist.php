<?php if (count($this->songs) > 0): ?>
    <div class="box_video">
        <?php if(!empty($this->pageTitle)):?>
            <div class="header_box">
                <h2 class="title"><?php echo $this->pageTitle;?></h2>&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="fll">
	                <?php 
					$pageN = isset($_GET['page'])?$_GET['page']:1;
					?>
					<a style="float: left" href="<?php echo Yii::app()->createUrl("/playall/artist",array("url_key"=>Common::makeFriendlyUrl($this->artist->name),"page"=>$pageN, "type"=>$this->artist->id)); ?>" class="play_all"><span>playall</span></a>
				</div>
            </div>
        <?php else:?>
        <div class="header_box" style="margin: 0;">
                <?php 
			$pageN = isset($_GET['page'])?$_GET['page']:1;
			?>
			<a style="float: left" href="<?php echo Yii::app()->createUrl("/playall/artist",array("url_key"=>Common::makeFriendlyUrl($this->artist->name),"page"=>$pageN, "type"=>$this->artist->id)); ?>" class="play_all"><span>playall</span></a>
		</div>
		<?php endif;?>
        <div class="content_box">
            <ul class="list_song">
                <?php
                $i = 0;
                foreach ($this->songs as $song):
                    $urlKey = ($song->url_key) ? $song->url_key : Common::makeFriendlyUrl(trim($song->name));
                    $link = Yii::app()->createUrl("song/view", array("id" => $song->id, "title" => $urlKey, 'artist'=>Common::makeFriendlyUrl($song->artist_name)));
                    if(isset($this->artist)){
                        $urlKey_Artist = ($this->artist->url_key) ? $this->artist->url_key : Common::makeFriendlyUrl(trim($this->artist->name));
                        //$linkArtist = Yii::app()->createUrl("artist/view", array("id" => $this->artist->id, "title" => $urlKey_Artist));
                        $linkArtist = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->artist_name)));
                    }
                    else
                        $linkArtist = '#';

                    if (!empty($song->song_statistic) && !empty($song->song_statistic->played_count)) {
                        $totalPlay = $song->song_statistic->played_count;
                    } else {
                        $totalPlay = 0;
                    }
                    $user_id = (Yii::app()->user->isGuest) ? 0: Yii::app()->user->getId();
                    $isLiked = WebFavouriteSongModel::model()->isLiked($user_id, $song->id);
                    ?>
                    <li>
                        <div class="col1 fll">
                            <h3>
                                <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($song->name); ?>">
                                    <?php echo Formatter::substring(CHtml::encode($song->name), " ", 8, 25); ?>
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
                            <?php /*<a href="<?php echo $linkArtist;?>"><?php echo Formatter::substring(CHtml::encode($song->artist_name), " ", 5, 23) ?></a>*/?>

                            <?php
							$artistName = str_replace("-", ",", $song->artist_name);
							$artistList = explode(",", $artistName);
							$j=0;
							foreach ($artistList as $artist):
							$artist = trim($artist);
							?>
							<h4><a href="<?php echo Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($artist))); ?>" title="<?php echo CHtml::encode($artist) ?>"><?php echo Formatter::smartCut(CHtml::encode($artist), 23) ?></a></h4>
							<?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
							<?php $j++; endforeach;?>

                        </div>
                        <div class="col3 fll"><?php echo $totalPlay ?> <?php echo Yii::t('web', 'views');?></div>
                        <div class="col4 flr"><?php echo Formatter::formatDuration($song->duration) ?></div>
                        <div class="more_action artist_song">
                            <ul>
                                <li><a href="javascript:;" id="<?php echo 'song-'.$song->id;?>" class="like_song <?php echo ($isLiked)?'liked':'';?>"><i class="icon icon_like"></i></a></li>
                                <li><a class="has-ajax-pop reqlogin" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/download", array("id" => $song->id)) ?>"><i class="icon icon_down"></i></a></li>
                                <li><a class="has-ajax-pop reqlogin" href="javascript:;" rel="<?php echo Yii::app()->createUrl("playlist/addSong", array("id" => $song->id)) ?>"><i class="icon icon_add"></i></a></li>
                                <li><a class="has-ajax-pop reqlogin" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/rbt", array("id" => $song->id)) ?>"><i class="icon icon_phone"></i></a></li>
                                <li><a class="has-ajax-pop reqlogin" href="javascript:;" rel="<?php echo Yii::app()->createUrl("song/gift", array("id" => $song->id)) ?>"><i class="icon icon_gift"></i></a></li>
                                <?php $shareLink = Yii::app()->params["base_url"] . URLHelper::buildFriendlyURL("song", $song->id, $urlKey);?>
								<li><a title="<?php echo $song->name;?>" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>&t=<?php echo urlencode($song->name);?>" target="_blank"><i class="icon icon_share"></i></a></li>
                            </ul>
                        </div>
                        <div class="meta-content hide" style="display: none;">
                            <span class="content_song_id"><?php echo $song->id?></span>
                        </div>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
        </div>
        <?php if(!empty($this->pageTitle)):?>
        <div class="readmore">
        	<a class = "gray_color" style="float: right" href="<?php echo $this->moreLink?>" class="fs11"><?php echo Yii::t('web', 'More');?> <i class="icon icon_mt"></i></a>
        </div>
        <?php endif;?>
    </div>
<?php endif; ?>