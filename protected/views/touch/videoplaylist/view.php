<?php
$deviceId = yii::app()->session['deviceId'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($userAgent, 'BB10') !== false) {
    //fake for BB10 generic_mobile
    $deviceId = 'apple_iphone_ver6';
} elseif (strpos($deviceId, 'generic_web_browser') !== false) {
    //$deviceId = 'android';
    $deviceId = 'iphone';
}
$playUrl = VideoModel::model()->getVideoFileUrl($video->id, $deviceId, 'rtsp', true);

$name = explode("-", $video->name);
?>

<div class="video-detail">
    <?php if (count($list_video) > 0): ?>
    <div class="video-player" style="text-align: center;">
        <div class="poster" id="video-poster"
             style="background: #000 url(<?php echo str_replace('imuzik2013/imuzik2013', 'imuzik2013', WapVideoModel::model()->getThumbnailUrl(320, $video->id)); ?>) no-repeat center center; width: 320px;height: 240px; margin: 0 auto">
            <?php if (VideoModel::model()->isHD($video['profile_ids'])): ?>
                <?php
                $playUrlHD = VideoModel::model()->getVideoFileUrl($video->id, $deviceId, 'http', true, 6);
                ?>
                <div class="_mbx">
                    <div><a class="playHd" href="javascript: void(0)"><span class="vhd">HD</span></a></div>
                </div>
                <script>
                    $(function () {
                        $(".playHd").live("click", function () {
                            $(this).find("span").toggleClass("nhd");
                            var video = document.getElementsByTagName('video')[0];
                            var sources = video.getElementsByTagName('source');
                            if ($(this).find("span").hasClass("nhd")) {
                                sources[0].src = '<?php echo $playUrlHD;?>';
                            } else {
                                sources[0].src = '<?php echo $playUrl;?>';
                            }
                            video.load();
                        })
                    })
                </script>
            <?php endif; ?>
<!--            <span id="play-video" onclick="playVideo('<?php /*echo $video->id */?>', '<?php /*echo $video->code */?>')"><img
-->            <span id="play-video" onclick="playVideo()"><img
                    src="<?php echo Yii::app()->request->baseUrl ?>/touch/images/play.png"/></span>
        </div>

        <div class="video-tag" id="video-tag" style="display: none;">
            <video id="video-player-obj" width="320" height="240" controls
                   poster="<?php echo WapVideoModel::model()->getThumbnailUrl(320, $video->id); ?>">
                <source src="<?php echo $playUrl ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="_mbx">
                <div><a class="playHd" href="javascript: void(0)"><span class="vhd">HD</span></a></div>
            </div>
        </div>
    </div>
    <?php if (count($list_video) > 1): ?>
        <div id="imuzik-player-playlist">
            <div style="cursor: pointer" onclick="VegaCoreJs.playlistToggle();" class="playing">
                <i class="izpl-icon-pl"></i>

                <div class="info_vp">
                    <h1 class="video-playlist-name"><?php echo CHtml::encode(Formatter::smartCut($video->name, 20)); ?></h1>
                </div>
                <i class="izpl-icon-al" id="izpl-icon-al"></i>
            </div>

            <div style="display: none;" class="info_vp" id="imuzik-player-tools">
                <span
                    class="c-video"><?php echo count($list_video); ?> <?php echo Yii::t("wap", "Video"); ?></span>

            </div>

            <div style="display: none;" class="scroll" id="imuzik-player-lst">
                <ul class="list">
                    <?php $i = 0; ?>
                    <?php foreach ($list_video as $item): ?>
                        <li class="item-video-playlist <?php echo ($video->id == $item->id) ? 'selected' : '' ?>"
                            id="video-item-<?php echo $i ?>" rel="<?php echo $item->id;?>">
                            <?php
                            $playUrl = VideoModel::model()->getVideoFileUrl($item->id, $deviceId, 'rtsp', true);
                            $videoPlaylistLink = Yii::app()->createUrl('videoPlaylist/view', array('id' => $videoPlaylist->id, 'url_key' => Common::makeFriendlyUrl($item['name']), 'video_id' => $item->id));
                            ?>
                            <a data-toggle="modal" data-freeview="1" data-allowview="3" data-pricev="0" data-priced="0"
                               data-id="39618" data-3g="0" data-hp="0" href="javascript:void(0)"
                               class="thumb-link popup-modal">
                                <?php
                                $avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $item['id']), 'avatar', array('class' => 'video-avatar', 'align' => 'left'));
                                ?>
                                <div class="thumb">
                                    <?php echo $avatarImage; ?>
                                </div>
                                <h2><?php echo Formatter::smartCut(CHtml::encode($item['name']), Yii::app()->params['limit_substring_title'], 0) ?></h2>

                                <div
                                    class="desc"><?php echo Formatter::smartCut($item['artist_name'], Yii::app()->params['limit_substring'], 0); ?></div>
                            </a>
                            <a id="call-download-free" class="ic-download" href=" javascript:void(0) "></a>
                        </li>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <?php else: ?>
        <div class="limit_content">
            <div class="msglimit">[Nội dung Độc Quyền] <br><br>Đây là nội dung VIP của dịch vụ AMUSIC, nội dung chỉ dành cho thuê bao đã đăng ký dịch vụ.<br><br>Để nghe MIỄN PHÍ nội dung xin vui lòng đăng ký gói cước của dịch vụ.<br>Xin cảm ơn!</div>
        </div>

    <div class="action">
        <?php
        $is_download = 0;
        if (($video->allow_download) && (strpos($deviceId, 'apple_iphone') === false && strpos($deviceId, 'apple_ipod') === false && strpos($deviceId, 'apple_ipad') === false)) {
            $is_download = 1;
        }
        ?>
        <ul class="<?php echo ($is_download == 1) ? 'width33' : 'width50' ?>">
            <li id="videoPlaylist-<?php echo $videoPlaylist->id; ?>">
                <a onclick="<?php echo $like ? "VegaCoreJs.dislikethis" : "VegaCoreJs.likethis"; ?>('videoPlaylist', <?php echo $videoPlaylist->id; ?>, 'detail');"
                   href="#like">
                    <p>
                        <i class="vg_icon <?php if ($like): ?>icon_action_dislike<?php else: ?>icon_action_like<?php endif; ?>"></i>
                    </p>
                    <?php if ($like): ?>
                        <p>Bỏ thích</p>
                    <?php else: ?>
                        <p>Thích</p>
                    <?php endif; ?>
                </a>
            </li>
            <?php $share_url = 'http://www.facebook.com/share.php?u=' . Yii::app()->createAbsoluteUrl('/video/view', array('id' => $video->id, 'url_key' => $video->url_key)); ?>
            <li><a href="<?php echo $share_url ?>" target="_blank">
                    <p>
                        <i class="vg_icon icon_action_face"></i>
                    </p>

                    <p>Facebook</p>
                </a></li>
            <?php
            $deviceId = yii::app()->session['deviceId'];
            $package = yii::app()->user->getState('package');
            if ($is_download == 1) : ?>
                <li><a href="#download"
                       onclick="downloadContent('<?php echo $video->id ?>', '<?php echo $video->code ?>', 'downloadVideo', '')">
                        <p>
                            <i class="vg_icon icon_action_down"></i>
                        </p>

                        <p>Tải</p>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="video">
        <h3 class="name"><?php echo CHtml::encode($videoPlaylist->name) ?></h3>
        <p class="artist">
            <?php
            echo CHtml::encode($videoPlaylist['artist_name']);
            ?>
        </p>

        <?php if (count($list_video) > 1): ?>
            <p class="video_playlist_description">
                <?php
                $description = $videoPlaylist->description;;
                $p = new CHtmlPurifier();
                $p->options = array('HTML.ForbiddenElements' => array('p', 'span', 'a', 'script'));
                $description = $p->purify($description);
                echo $description = nl2br($description);
                ?>
            </p>
        <?php endif; ?>
    </div>
    <div id="video-collection" class="vg_contentBody">
        <ul class="orther clb" style='overflow:hidden'>
            <li><a class="same active"
                   onClick="LoadSameVideo('<?php echo Yii::app()->createUrl('/videoPlaylist/loadAjax', array('s' => 'artist', 'id' => $videoPlaylist->id, 'artist_id' => $artist_id)); ?>');"
                   href="javascript:void(0)">Cùng ca sĩ</a></li>
            <li class="line"><a href="">|</a></li>
            <li><a class="same"
                   onClick="LoadSameVideo('<?php echo Yii::app()->createUrl('/videoPlaylist/loadAjax', array('s' => 'genre', 'id' => $videoPlaylist->id, 'genre_id' => $videoPlaylist->genre_id)); ?>');"
                   href="javascript:void(0)">Cùng thể loại</a></li>
        </ul>

        <div id="res-video" class="vg_contentBody">
            <input type="hidden" class="total-page"
                   value="<?php echo $pager->getPageCount() ?>"/> <input type="hidden" class="curent-page"
                                                                         value="<?php echo($pager->getCurrentPage() + 1) ?>"/>
            <input
                type="hidden" class="curent-link" value="<?php echo $callBackLink ?>">
            <?php
            $this->widget('application.widgets.touch.videoPlaylist.VideoPlaylistListWidget', array('videoPlaylists' => $videoPlaylistSameArtist, 'options' => array()));
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/touch/js/vplayer.js?v=1.0"></script>

<script type="text/javascript">
$('a.same').click(function () {
        $('a.same').removeClass('active');
        $(this).toggleClass('active');
    });
    $(document).ready(function(){
        var albumObj = {
            id:<?php echo $videoPlaylist->id ?>,
            name:"<?php echo CHtml::encode($videoPlaylist->name) ?>",
            listSong:{}
        };
        listSong = Array();
        <?php
            foreach($list_video as $key => $song):
            $playUrl = WapVideoModel::model()->getVideoFileUrl($song->id, $deviceId, 'rtsp', true);
            $playHD ='http://video.chacha.vn:8282/videos/output/11/95154/9.mp4';
            $img = WapVideoModel::model()->getThumbnailUrl(320, $song->id);
        ?>
        var item = {
            title: "<?php echo Formatter::smartCut($song->name,20) ?>",
            url_normal: "<?php echo $playUrl; ?>",
            url_hd: "<?php echo $playHD; ?>",
            img: "<?php echo $img?>"
        };
        listSong.push(item);
        <?php endforeach;?>
        albumObj.listSong = listSong;
        new VideoPlaylistPlayer("video-player-obj",albumObj);
    });

    function LoadSameVideo(url) {
        $.ajax({
            'url': url,
            'async': false,
            'success': function (data) {
                killScroll = false;
                $("#res-video").html(data);
            },
            'beforeSend': function (data) {
                $("#res-video").html("<img width='55' src='/touch/images/ajax_loading.gif' />");
            }
        })
        return false;
    }

    function playVideo() {
       if(this.CheckVideo() == 1){
           $('#video-poster').hide();
           $('#video-tag').show();
           var videoObj = document.getElementById("video-player-obj");
           videoObj.play();
       }
    };
function CheckVideo(){
    if (userPhone) {
        if ((userSubs == 'false' || userSubs == false)) {
            if ($(".playHd").children().hasClass("nhd")) {
                var html = "Quý khách vui lòng đăng ký để nghe miễn phí nội dung chất lượng cao.";
                html += '<div class="clb ovh">';
                html += '<div class="btn-popup btn-popup-green" style="width: 45%; float: left;">';
                html += '<a href="<?php echo Yii::app()->createUrl("account/package")?>" class="show" style="color: #FFF">Đăng ký</a>';
                html += '</div>';
                html += '<div class="btn-popup btn-popup-green" style="width: 45%; float: right;">';
                html += '<a href="javascript::void();" onclick="Popup.close()" class="show" style="color: #FFF">Hủy</a>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                Popup.alert(html);
                return 0;
            }
        }
        return 1;
    }

    if (!userPhone || typeof userPhone == 'undefined') {
        if ($(".playHd").children().hasClass("nhd")) {
            var html = "Quý khách vui lòng đăng ký để nghe miễn phí nội dung chất lượng cao.";
            html += '<div class="clb ovh marg10">';
            html += '<a href="<?php echo Yii::app()->createUrl("account/package")?>" class="button-dark btn-submit" style="color: #FFF">Đăng ký</a>';
            html += '<a href="javascript::void();" onclick="Popup.close()" class="button-grey btn-submit" style="color: #FFF">Hủy</a>';
            html += '</div>';
            html += '</div>';
            Popup.alert(html);
            return 0;
        } else {
            back_url = document.URL;
            url = rootPath + '/account/login?back=' + back_url;
            var res = 0;
            $.ajax({
                type: "GET",
                url: urlLimit,
                data: {},
                async: false,
                beforeSend: function () {
                },
                success: function (data) {
                    if (data >= 5) {
                        html =
                            '<p class="padB10">Quý khách đã nghe/xem hết 5 nội dung miễn phí trong lần truy cập này. Để được miễn phí nghe xem các bài hát, video, miễn cước data (3G/GPRS) của MobiFone vui lòng đăng nhập.</p>'
                            + '<div class="pk-btn">'
                            + '<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Đóng</a>'
                            + '<a class="button-dark btn-submit" href="' + url + '">Đồng ý</a>'
                            + '</div>'
                        Popup.alert(html);
                        res = 0;
                    } else {
                        res = 1;
                    }
                },
                complete: function () {
                },
                statusCode: {
                    404: function () {
                        ret = {error: 404, message: "Error connect to charging"};
                    }
                }
            });

            return res;
        }
    }
}

var VideoPlaylistPlayer = function(cssSelector, contentObj)
{
    //alert(JSON.stringify(contentObj));
    var self = this;
    document.getElementById("video-player-obj").addEventListener("ended", function() {
        var listSong = contentObj.listSong;
        index = (index + 1 < listSong.length) ? index + 1 : 0;
        self._play();
    }, false);
    $(".item-video-playlist").click(function(){
        var id_item = $(this).attr("id");
        id_item = id_item.replace("video-item-","");
        index = parseInt(id_item);
        var listSong = contentObj.listSong;
        if(index >= 0 && index <= listSong.length){
            self._play();
        }
    });
};
VideoPlaylistPlayer._getInstance = function() {
    if (!VideoPlaylistPlayer._instance)
        VideoPlaylistPlayer._instance = new VideoPlaylistPlayer('video',null);
    return VideoPlaylistPlayer._instance;
};
VideoPlaylistPlayer.prototype =  $.extend(true, vplayer.prototype,{
    _play: function(){
        if(CheckVideo() == 1){
            $('#video-poster').hide();
            $('#video-tag').show();
            $("#imuzik-player-lst ul li").removeClass("selected");
            $("#video-item-"+index).addClass("selected");
            if ($(".playHd").find("span").hasClass("nhd")) {
                var url = listSong[index].url_hd;
            } else {
                var url = listSong[index].url_normal;
            }
            var title = listSong[index].title;
            $(".video-playlist-name").html(title);
            var img = listSong[index].img;
            var videoPlayer = document.getElementById("video-player-obj");
            videoPlayer.src = url;

            $("#video-poster").css('background-image', 'url(' + img + ')');
            videoPlayer.load();
            videoPlayer.play();
        }

    }

})
</script>
