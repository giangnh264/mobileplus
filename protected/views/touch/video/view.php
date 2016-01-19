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
    <div class="video-player" style="text-align: center;">
        <?php if(!empty($per)){?>
            <div class="limit_content">
                    <div class="msglimit">
                      <?php echo $per->msg_warning?>
                        <a class="underline" href="<?php echo Yii::app()->createUrl('account/package')?>">Đăng ký tại đây</a>
                    </div>
                </div>;

        <?php }elseif($deactive){
            $msg = Yii::app()->params['alert_content_limited'];
            $this->widget('application.widgets.touch.common.NotifyMessageWidget', array('msg'=>$msg,'type'=>'video'));
        }else{?>
        <div class="poster" id="video-poster"
             style="background: #000 url(<?php echo str_replace('imuzik2013/imuzik2013', 'imuzik2013', WapVideoModel::model()->getThumbnailUrl(320, $video->id)); ?>) no-repeat center center; width: 320px;height: 240px; margin: 0 auto">
            <?php if (VideoModel::model()->isHD($video['profile_ids'])): ?>
                <?php
                $playUrlHD = VideoModel::model()->getVideoFileUrl($video->id, $deviceId, 'http', true, 9);
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
            <span id="play-video" onclick="playVideo('<?php echo $video->id ?>', '<?php echo $video->code ?>')"><img
                    src="<?php echo Yii::app()->request->baseUrl ?>/touch/images/play.png"/></span>
        </div>
        <?php }?>
        <div class="video-tag" id="video-tag" style="display: none;">
            <video id="video-player-obj" width="320" height="240" controls
                   poster="<?php echo WapVideoModel::model()->getThumbnailUrl(320, $video->id); ?>">
                <source src="<?php echo $playUrl ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <div class="action">
        <?php
        $is_download = 0;
        if (($video->allow_download) && (strpos($deviceId, 'apple_iphone') === false && strpos($deviceId, 'apple_ipod') === false && strpos($deviceId, 'apple_ipad') === false)) {
            $is_download = 1;
        }
        ?>
        <ul class="<?php echo ($is_download == 1) ? 'width33' : 'width50' ?>">
            <!--<li id="video-<?php /*echo $video->id; */?>">
                <a onclick="<?php /*echo $like ? "VegaCoreJs.dislikethis" : "VegaCoreJs.likethis"; */?>('video', <?php /*echo $video->id; */?>, 'detail');"
                   href="#like">
                    <p>
                        <i class="vg_icon <?php /*if ($like): */?>icon_action_dislike<?php /*else: */?>icon_action_like<?php /*endif; */?>"></i>
                    </p>
                    <?php /*if ($like): */?>
                        <p>Bỏ thích</p>
                    <?php /*else: */?>
                        <p>Thích</p>
                    <?php /*endif; */?>
                </a>
            </li>
            <?php /*$share_url = 'http://www.facebook.com/share.php?u=' . Yii::app()->createAbsoluteUrl('/video/view', array('id' => $video->id, 'url_key' => $video->url_key)); */?>
            <li><a href="<?php /*echo $share_url */?>" target="_blank">
                    <p>
                        <i class="vg_icon icon_action_face"></i>
                    </p>

                    <p>Facebook</p>
                </a></li>-->
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
        <h3 class="name"><?php echo CHtml::encode($video->name) ?></h3>

        <p class="artist">
            <?php
            $artists = explode(',', $video->artist_name);
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
        </p>
    </div>
    <div id="video-collection" class="vg_contentBody">
        <ul class="orther clb" style='overflow:hidden'>
            <li><a class="same active"
                   onClick="LoadSameVideo('<?php echo Yii::app()->createUrl('/video/loadAjax', array('s' => 'artist', 'id' => $video->id, 'artist_id' => $artistId)); ?>');"
                   href="javascript:void(0)">Cùng ca sĩ</a></li>
            <li class="line"><a href="">|</a></li>
            <li><a class="same"
                   onClick="LoadSameVideo('<?php echo Yii::app()->createUrl('/video/loadAjax', array('s' => 'genre', 'id' => $video->id, 'genre_id' => $video->genre_id)); ?>');"
                   href="javascript:void(0)">Cùng thể loại</a></li>
        </ul>

        <div id="res-video" class="vg_contentBody">

            <input type="hidden" class="total-page"
                   value="<?php echo $pager->getPageCount() ?>"/> <input type="hidden"
                                                                         class="curent-page"
                                                                         value="<?php echo($pager->getCurrentPage() + 1) ?>"/>
            <input
                type="hidden" class="curent-link" value="<?php echo $callBackLink ?>">

            <?php
            $this->widget('application.widgets.touch.video.VideoList', array('videos' => $videoSameArtist));
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('a.same').click(function () {
        $('a.same').removeClass('active');
        $(this).toggleClass('active');
    });

    function ended() {

    }

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

    function playVideo(id, code) {
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
                    return false;
                }
                //goi gioi han noi dung ctkm
                url = rootPath + '/account/package';
                $.ajax({
                    type: "GET",
                    url: urlLimitCtkm,
                    data: {},
                    async: false,
                    beforeSend: function() {
                    },
                    success: function(data) {
                        ret =  data;
                        if(ret.session == 3 && ret.promotion == 1){
                            html =
                                '<div class="promotion_popup">'
                                +'<p class="padB5">MIỄN PHÍ <span class="text_promotion"> 05 ngày </span>nghe/xem/tải nhạc chất lượng cao miễn phí <span class="text_promotion"> 3G/GPRS </span></p>'
                                +'<p class="padB5">Cơ hội trúng<span class="text_promotion"> HONDA LEAD </span> và nhiều phần quà giá trị </p>'
                                +'<div class="pk-btn">'
                                +'<a class="button-dark btn-submit" href="'+url+'">Đăng ký</a>'
                                +'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Để sau</a>'
                                +'</div>'
                                +'</div>'
                            Popup.alert(html,'Niềm vui nhân đôi');
                        }else if(ret.session == 3 && ret.promotion == 0){
                            html =
                                '<div class="promotion_popup">'
                                +'<p class="padB10">Chưa bao giờ sở hữu<span class="text_promotion"> HONDA LEAD </span>và thưởng thức các ca khúc chất lượng cao hoàn toàn<span class="text_promotion"> MIỄN PHÍ 3G/GPRS </span>dễ dàng đến thế!</p>'
                                +'<div class="pk-btn">'
                                +'<a class="button-dark btn-submit" href="'+url+'">Đăng ký</a>'
                                +'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Để sau</a>'
                                +'</div>'
                                +'</div>'
                            Popup.alert(html,'Khuyến mại');
                        }
                        return false;
                    }
                });
            }




            ret = docharge('playVideo', id, code);
/*            console.log("charging");
            if (ret.errorCode != 0) {
                alert(ret.message);
                return false;
            }*/
            $('#video-poster').hide();
            $('#video-tag').show();
            var videoObj = document.getElementById("video-player-obj");
            videoObj.play();
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
            } else {
                back_url = document.URL;
                url = rootPath + '/account/login?back=' + back_url;
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
                        } else {
                            $('#video-poster').hide();
                            $('#video-tag').show();
                            var videoObj = document.getElementById("video-player-obj");
                            videoObj.play();
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
            }
        }
    }
</script>
