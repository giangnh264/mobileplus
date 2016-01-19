<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-1344246-22']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
<?php 
if($this->showPopup && !is_null($this->deviceOs) && false)
{
	echo '<script type="text/javascript">';
	if($this->deviceOs=="IOS"){
		echo '
		if(confirm("Đã có ứng dụng nghe tải nhạc Chacha cho máy iPhone, Cài đặt MIỄN PHÍ, nhấn OK để tải về"))
			window.location.href="http://itunes.apple.com/us/app/chacha/id513853264?mt=8";
		';
	}else{
		echo '
		if(confirm("Đã có ứng dụng nghe tải nhạc Chacha cho máy ANDROID, Cài đặt MIỄN PHÍ, nhấn OK để tải về"))
			window.location.href="https://play.google.com/store/apps/details?id=vn.com.vega.chacha";
		';
	}
	echo '</script>';
}
?>
    
</head>
<body>
    Layout <br/>
    <?php echo $content; ?>
</body>
</html>