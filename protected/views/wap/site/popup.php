<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
    </head>
    <body class="popup_page">
    <center>
        <div>
            <a title="Trang chủ" rel="chacha" href="/"><img src="/images/imgv2/chacha_logo.png" /></a>
        </div>
        <p>
            <?php
            echo Yii::t('chachawap', 'Đã có ứng dụng chacha cho điện thoại của bạn! Cài đặt ngay hôm nay để trải nghiệm âm nhạc tuyệt vời hơn!');
            ?>
        </p>
        <div>
            <img style="height:150px" src="<?php echo Yii::app()->theme->baseUrl;?>/images/popup/popup_image.png" />
        </div>
        <div>
            <?php
            if ($this->deviceOs == "IOS") {
                $link = 'http://itunes.apple.com/us/app/chacha/id513853264?mt=8';
            } else {
                $link = 'market://details?id=vn.com.vega.chacha';
            }
            ?>
            <a id="caidat" class="button" href="<?php echo $link; ?>" >CÀI NGAY</a>
            <a id="tieptuc" class="button" href="<?php
            $extra = "utm_source=POPUP_CHACHAWAP&utm_medium=cpc&utm_content=banner&utm_campaign=APP_INS";
            if(isset($_SESSION['request_uri_popup']) && (strpos($_SESSION['request_uri_popup'],'popup') === false)){
                if(strpos($_SESSION['request_uri_popup'],'?')===FALSE)
                    echo $_SESSION['request_uri_popup']."?$extra";
                else
                    echo $_SESSION['request_uri_popup']."&$extra";
            }
            else
                echo "";
            ?>">CÀI SAU</a>
        </div>
    </center>

<?php
        GAWap::$GA_ACCOUNT = Yii::app()->params['GA_ACCOUNT'];
        $googleAnalyticsImageUrl = GAWap::googleAnalyticsGetImageUrl();
        echo '<img style="display:none" src="' . $googleAnalyticsImageUrl . '" />';
    ?>
</body>
</html>