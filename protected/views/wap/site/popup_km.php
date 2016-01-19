<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="/wap/css/main.css" />

        <style>
			.pk-btn a{
				display: block;
			}
		</style>
    </head>
    <body style="background: #F5F4F1;padding-top: 20px; height: 500px;">
    <center>

    <?php
	    $link_close = Yii::app()->createUrl('/site/index', array('popup_km'=>'close'));
	    $link_reg = Yii::app()->createUrl('/account/Doregister', array('id'=>1));
    ?>
       <div id="popup-reg" style="top: 20%; position: inherit;">
	    <div class="popup-km">
	    	<h3>THÔNG BÁO</h3>
	    	<div class="pk-ct">
                    <p class="padB10">Amusic – CTKM dành cho thuê bao VIP: MIỄN PHÍ 5 ngày nghe, xem, tải các bài hát, Clip ca nhạc HOT chất lượng cao nhất. Đặc biệt, miễn cước 3G/GPRS. Bạn muốn trải nghiệm?</p>
	    		<div class="pk-btn">
                            <a href="<?php echo $link_reg;?>">Đồng ý</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $link_close;?>">Hủy</a>
	    		</div>
	    	</div>
	    </div>
    </div>
    </center>
</body>
</html>