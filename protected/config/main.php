<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    require(dirname(__FILE__) . '/local.php'),
    require(dirname(__FILE__) . '/mongo.php'),
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'sourceLanguage' => 'code',
        'language' => 'vi_vn',
        // preloading 'log' component
        'preload' => array('log'),
        // autoloading model and component classes
        'import' => array(
            'application.models.db._base.*',
            'application.models.db.*',
            'application.components.common.*',
            'application.vendors.utilities.*',
        ),
        // application components
        'components' => array(
            'gearman' => array(
                'class' => 'ext.gearman.Gearman',
                'servers' => array(
                    array('host' => '192.168.89.96', 'port' => 4730),
                ),
            ),
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => true,
                'class' => 'WebUser',
            ),
            "SEO"=>array(
                'class'=>'application.components.common.SEO'
            ),
            // enable URLs in path-format
            'urlManager' => array(
            ),
            /*'request' => array(
                'class' => 'application.components.common.HttpRequest',
                'enableCsrfValidation' => true,
            ),*/
            /* 'session' => array(
                'class' => 'system.web.CDbHttpSession',
                'connectionID' => 'db',
                'timeout' => 86400,
                'sessionName' => 'SOMEABSTRACT_PHPSESSID',
            ), */
        ),
        /* 'behaviors'=>array(
             'runEnd'=>array(
                 'class'=>'application.components.common.ApplicationConfigBehavior',
                 'enabled' => true,
             ),
         ),*/
        // module config
        'modules' => array(
        ),
        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params' => array(

            'cacheTime' => 600,
            // this is used to support multi lanuages
            'languages' => array('en_us' => 'English', 'vi_vn' => 'Tiếng Việt'),
            'defaultLanguage' => 'vi_vn',
            'web.domain' => '',
            "phone.country.code" => "84",
            "phone.prefix" => array(
                "841" => 12,
                "849" => 11
            ),
            'genreType' => array('all' => 'all', 'song' => 'song', 'album' => 'album', 'video' => 'video'),
            'VNGenreParent' => 1,
            'QTEGenreParent' => 33,
            'CAGenreParent' => 60,
            'VNGenre' => array(60),
            'QTEGenre' => array(101),
            'CHAUAGenre' => array(29,31,34,35),
            'NHACVIETGenre' => array(60, 1122, 1, 1148, 1113, 5, 1117, 7, 119, 8, 9, 6, 11, 14, 623, 1158, 1168, 1155, 1156, 1153, 625),
            'OTHERGenre'=>  array(1136, 1124,5,619,7,8,47,9,6,14,11,1111),

            'imageSize' => array(// order tu thap len cao
                's5' => 50, 's4' => 100, 's3' => 150, 's2' => 320, 's1' => 640, 's0' => '1024'
            ),
            'videoResolutionRate' => "16:9", // ty le width:height cua video
            'adminMaxUpload' => 52428800, // 50*1024*1024 = (50M) limit file size in bytes
            'supportFileExtensions' => array("*.gif", "*.jpg", "*.jpeg", "*.jpe", "*.png", "*.swf", "*.psd" . "*.bmp", "*.tiff", "image/jp2", "*.wbmp", "*.ico"),
            'supportMineTypes' => array("image/gif", "image/jpeg", "image/png", "application/x-shockwave-flash", "image/psd", "image/bmp", "image/tiff", "image/jp2", "image/iff", "image/vnd.wap.wbmp", "image/xbm", "image/vnd.microsoft.icon"),
            "profile.avatar.upload.mimetypes" => array("image/jpeg", "image/png", "image/gif", "image/x-png", "image/pjpeg"),
            "profile.avatar.upload.maxsize" => "8388608",
            'secret_stream_key' => 'fa0e8f3fd2',
            "video.profile.default" => array(
                'web' => array(7,8,9),
                'iphone' => array(3,7,8,9),
                'android' => array(6,7,8,9),
                'rtsp_mp4' => array(2,5),
                'rtsp_3gp' => array(1,4),
            ),
            "song.profile.default" => array(
                'web' => array(1, 4),
                'iphone' => array(2,4),
                'rtsp_3gp' => array(3, 5),
                '320k'=> 4,
                '128k'=> 2,
            ),

            'position' => array(
                'web' => array(
                    "1"           => "300x250 - góc trên cùng cột bên phải trên web",
                    "web_player"  => "690x110 Hiển thị player trên web",
                ),
                'wap' => array(
                    "2"           => "320x50 - phía trên menu cuối trang trên touch",
                )
            ),
            'bannerChannel' => array(
                'wap' => 'wap',
                'web' => 'web',
                'app' => 'app'
            ),
            'eventChannel' => array(
                'wap' => 'wap',
                'web' => 'web',
                'app' => 'app'
            ),
            'storage_path' => array(
                'song' => array(
                    '' => array('min' => 0, 'max' => 9999999999999),
                ),
                'video' => array(
                    '' => array('min' => 0, 'max' => 9999999999999),
                ),
                'album' => array(
                    '' => array('min' => 0, 'max' => 9999999999999),
                ),
                'ringtone' => array(
                    '' => array('min' => 0, 'max' => 9999999999999),
                ),
                'rbt' => array(
                    '' => array('min' => 0, 'max' => 9999999999999),
                ),
            ),
            'horoscope'=>array(
                'parent_id'=>'169',
                'title'=>'Âm Nhạc 12 Cá Tính',
                'intro'=>'Tuyển Tập Âm Nhạc 12 Cá Tính và Tâm Trạng',
                'full'=>'<p class="desc" style="font-size: 14px;">Bạn là người mạnh mẽ, sôi nổi, thích những ca khúc cá tính và màu sắc? Hay bạn là người ủy mị, nhạy cảm, luôn đắm chìm trong những bản tình ca sặc mùi yêu đương? Cho dù bạn có khó tính như thế nào, Amusic vẫn sẽ mang tới cho bạn những ca khúc phù hợp nhất, hoàn toàn do bạn lựa chọn thông qua Âm Nhạc 12 Cá Tính. 12 Cá Tính - 12 sắc màu âm nhạc, sẽ đồng hành cùng bạn xuyên suốt theo tâm trạng hàng ngày. Hôm nay vui à, hãy cùng sôi động, ngày mai chẳng may buồn buồn, hãy sướt mướt cùng với chúng tôi.<br /><b> Âm Nhạc 12 Cá Tính - người bạn tri ân cho những xúc cảm!</b></p>'
            ),
            'monetary'=>'VND',
            'message'=>array(
                'limit_content'=>'Quý khách đã nghe/xem hết 5 nội dung miễn phí trong lần truy cập này. Để được miễn phí nghe xem các bài hát, video, miễn cước dât (3G/GPRS) của MobiFone vui lòng đăng nhập.',
            ),
            'htmlMetadata'=>array(
                'title'=>'Công ty khởi nguồn',
                'description'=>'Công ty khởi nguồn - Song hành cùng thành công',
                'keywords'=>'Công ty khởi nguồn - Song hành cùng thành công',
            ),
            'alert_content_limited'=>'Xin lỗi Quý khách! {content} bị hạ tạm thời. Mong Quý khách vui lòng quay lại sau. Trân trọng cảm ơn!',
            'alert_content_active'=>'Xin lỗi quý khách. Nội dung chưa đến ngày phát hành. Quý khách vui lòng quay lại sau. Trân trọng cảm ơn!',
            'ctkm'=>array(
                'type_name' =>'CTKM_DOT_1',
                'id_collection_song_hot'=>133,
                'id_collection_video_hot'=>134,
                'id_collection_album_hot'=>135,
                'phone_check'=>array(
                    '841205126493',
                    '841205086934',
                    '841227396040',
                    '841223221987',
                    '841205126505'
                ),
            ),
        ),
    )
);
