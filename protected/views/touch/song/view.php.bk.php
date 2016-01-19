<?php $deviceId = yii::app()->session['deviceId']; ?>
<div class="song-detail">
    <div class="vg_contentBody">
        <ul class="album_list">
            <li class="item"><a href="#">
                    <table>
                        <tr>
                            <td valign="top">
                                <?php
                                $avatar = CHtml::image(Yii::app()->request->baseUrl . '/images/album-75.png', '', array('width' => '75px', 'height' => '75px'));
                                if ($artistId) {
                                    $avatar = CHtml::image(WapArtistModel::model()->getThumbnailUrl('s1', $artistId), '', array('width' => '75px', 'height' => '75px'));
                                }
                                echo $avatar;
                                ?>
                            </td>
                            <td valign="top">
                                <div class="ct-info" >
                                    <h3 class="subtext"><?php echo CHtml::encode($song->name) ?></h3>
                                    <ul class="info">
                                        <li><?php
                                            $artists = explode(',', $song->artist_name);
                                            $count = count($artists);
                                            $i = 1;
                                            foreach ($artists as $artist) {
                                                $artist = trim($artist);
                                                echo $artist;
                                                if ($i < $count)
                                                    echo "&nbsp;-&nbsp;";
                                                $i++;
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                </a></li>
        </ul>
    </div>
    <div class="player">
        <?php if (!$this->userPhone && false): ?>
            <a rel="msg_free_content" class="" href="<?php echo Yii::app()->createUrl("account/login", array("wrr" => 1, "back" => Yii::app()->request->getRequestUri())) ?>">
                <img src="<?php echo Yii::app()->request->baseUrl ?>/touch/images/audio_player.png" width="100%" />
            </a>
            <?php
        else:
            if(!empty($per)){
                echo '<div class="limit_content">
                    <div class="msglimit">
                        '.$per->msg_warning.'
                    </div>
                </div>';
            }else{
                $this->widget("application.widgets.touch.player.SongPlayer", array('song' => $song));
            }

        endif;
        ?>
    </div>
    <input type="hidden" value="<?php echo $song->id; ?>" id="detail_songid">
    <div class="action">
        <?php
        $package = yii::app()->user->getState('package');
        if (($song->allow_download ) && (strpos($deviceId, 'apple_iphone') === false && strpos($deviceId, 'apple_ipod') === false && strpos($deviceId, 'apple_ipad') === false)) :
            ?>
            <ul class="ul_4">
                <li>
                    <?php if (!$this->userPhone): ?>
                        <a rel="msg_free_content" class="" href="<?php echo Yii::app()->createUrl("account/login", array("wrr" => 1, "back" => Yii::app()->request->getRequestUri())) ?>">
                        <?php else: ?>
                            <a href="#download" onclick="downloadContent('<?php echo $song->id ?>', '<?php echo $song->code ?>', 'downloadSong', '')">
                            <?php endif; ?>
                            <p>
                                <i class="vg_icon icon_action_down"></i>
                            </p>
                            <p><?php echo Yii::t("wap","Download");?></p>
                        </a>
                </li>
            <?php else: ?>
                <ul class="ul_3">
                <?php endif; ?>
                <li id="song-<?php echo $song->id; ?>">
                    <a onclick="<?php echo $like ? "VegaCoreJs.dislikethis" : "VegaCoreJs.likethis"; ?>('song', <?php echo $song->id; ?>, 'detail');"
                       href="javascript:;">
                        <p>
                            <i class="vg_icon <?php if ($like): ?>icon_action_dislike<?php else: ?>icon_action_like<?php endif; ?>"></i>
                        </p>
                        <?php if ($like): ?>
                            <p><?php echo Yii::t("wap","Unlike");?></p>
                        <?php else: ?>
                            <p><?php echo Yii::t("wap","Like");?></p>
                        <?php endif; ?>
                    </a>
                </li>
                <li>

                    <a onclick="VegaCoreJs.addSongPlaylist('<?php echo Yii::app()->createUrl('/ajax/getPopupPlaylist', array('phone' => $this->userPhone, 'song_id' => $song['id'])); ?>');" href="#top">
                        <p>
                            <i class="vg_icon icon_action_add"></i>
                        </p>
                        <p><?php echo Yii::t("wap","Add");?></p>
                    </a></li>
                 <?php if($song->rbt_codes!=""):?>
                	 <li>
                    <a onclick="VegaCoreJs.downloadRbt('<?php echo Yii::app()->createAbsoluteUrl('/ajax/downloadRbt', array('id' => $song['id'])); ?>');" href="#top">
                        <p><i class="vg_icon icon_action_rbt"></i></p>
                        <p><?php echo Yii::t("wap","Nhạc chờ");?></p>
                    </a></li>
                    
				  <?php endif;?>
       
                    
                <?php $share_url = 'http://www.facebook.com/share.php?u=' . Yii::app()->createAbsoluteUrl('/song/view', array('id'=> $song->id, 'url_key'=> $song->url_key)) ;?>
                <li><a href="<?php echo $share_url?>" target="_blank">
                        <p>
                            <i class="vg_icon icon_action_face"></i>
                        </p>
                        <p><?php echo Yii::t("wap","Share");?></p>
                    </a></li>
            </ul>
    </div>
    <div class="lyrics">
        <h3 class='lyric-label'>
            <i class='ic-lyric'></i>	
            <?php echo Yii::t("wap","Lyric");?>
        </h3>
        <?php
        $lyrics = ($song->song_extra && $song->song_extra->lyrics) ? $song->song_extra->lyrics :  Yii::t("wap","Lyric Updating");
        $p = new CHtmlPurifier();
        $p->options = array('HTML.ForbiddenElements' => array('p', 'span','a','script'));
        $lyrics = $p->purify($lyrics);
        $lyrics = nl2br($lyrics);
        $content = Formatter::substring($lyrics, " ", 50, 250);
        ?>
        <?php if (!empty($lyrics)): ?>
            <div class="lyrics-short-desc text-desc t10 fs_15">
                <p class="pad-10 subtext"><?php echo $content; ?></p>
                <div class="short-desc-view-more">
                    <?php if ($song->song_extra && $song->song_extra->lyrics): ?>
                        <a href="javascript:void(0)"
                           class="lyrics-view-more"><?php echo Yii::t('wap', 'View all'); ?> &raquo;</a>
                       <?php endif; ?>
                </div>
            </div>
            <div class="lyrics-full-desc hide text-desc t10 fs_15">
                <p class="pad-10"><?php echo $lyrics; ?></p>
                <div class="short-desc-view-more">

                    <a href="javascript:void(0)" class="lyrics-collapse t10"><?php echo Yii::t('wap', 'Collapse'); ?> &raquo;</a>
                </div>
            </div>
        <?php else: ?>
            <p><?php echo Yii::t('wap','Updating')?></p>
        <?php endif; ?>
    </div>
    <ul class="orther clb">
        <li><a class="same active"
               onClick="LoadSameArtist('<?php echo Yii::app()->createUrl('/song/loadAjax', array('s' => 'artist', 'id' => $song->id, 'artist_id' => $artistId)); ?>');"
               href="javascript:void(0)"><?php echo Yii::t("wap","Same artist");?></a></li>
        <li class="line"><a href=''> | </a></li>
        <li><a class="same"
               onClick="LoadSameArtist('<?php echo Yii::app()->createUrl('/song/loadAjax', array('s' => 'genre', 'id' => $song->id, 'genre_id' => $genreId)); ?>');"
               href="javascript:void(0)"><?php echo Yii::t("wap","Same genre");?></a></li>
    </ul>

    <div id="res-video" class="vg_contentBody">
        <input type="hidden" class="total-page"
               value="<?php echo $pager->getPageCount() ?>" /> <input type="hidden"
               class="curent-page"
               value="<?php echo ($pager->getCurrentPage() + 1) ?>" /> <input
               type="hidden" class="curent-link" value="<?php echo $callBackLink ?>">
        <?php
        if (count($songArtist) > 0) {
            $this->widget('application.widgets.touch.song.SongList', array(
                'songs' => $songArtist
            ));
        } else {?>
            <p class="pad-10"><?php echo Yii::t("wap","Not found");?></p>
        <?php }
        ?>
    </div>

    <script type="text/javascript">
        $("a.lyrics-view-more").click(function () {
            $('.lyrics-short-desc').removeClass("show").addClass('hide');
            $('.lyrics-short-desc').hide();
            $('.lyrics-full-desc').addClass('show').removeClass('hide');
            $('.lyrics-full-desc').show();
        });

        $("a.lyrics-collapse").click(function () {
            $('.lyrics-full-desc').removeClass("show").addClass('hide');
            $('.lyrics-full-desc').hide();
            $('.lyrics-short-desc').addClass('show').removeClass('hide');
            $('.lyrics-short-desc').show();
        })
        $('a.same').click(function () {
            $('a.same').removeClass('active');
            $(this).toggleClass('active');
        });
        function LoadSameArtist(url) {
            $.ajax({
                'url': url,
                'async': false,
                'success': function (data) {
                    killScroll = false;
                    $("#res-video").html(data);
                },
                'beforeSend': function (data) {
                    $("#res-video").html("<img width='55' src='<?php echo Yii::app()->request->baseUrl; ?>/touch/images/ajax_loading.gif' />");
                }
            })
            return false;
        }

    </script>
</div>