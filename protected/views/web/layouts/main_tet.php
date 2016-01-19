<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php /*<html lang="en" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">*/?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="vi" />

<title><?php echo CHtml::encode($this->htmlTitle); ?></title>
<!--[if IE]>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style-ie.css" type="text/css" rel="stylesheet">
<![endif]-->
<?php
echo $this->headMeta."\n";
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/style.css");
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/color.css");
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/width.css");

$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/search.css" );
$cs->registerCssFile(Yii::app()->theme->baseUrl."/web/css/style.css" );
if(Common::iever('==', 10)){
	$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/ie10.css" );
}

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->createUrl("index/loadJs"));
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_common.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/main.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_page.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/search.js");


$userId = 0;
if (!Yii::app()->user->isGuest){
	$userId = Yii::app()->user->Id;
}

$controller = Yii::app()->controller;
$action = $this->action->id;
?>

<script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-1344246-3']);
            _gaq.push(['_setDomainName', 'chacha.vn']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
</script>

</head>

<body>
<div id="wrr-body">
<div id="header">
    <div class="top-head">
    	<div class="wapper">
        	<div class="logo_vina fll">
            	<a href="/"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/vinaphone.png" alt="Vinaphone" /></a>
            </div>
            <div class="right_head flr">
            	<div class="link_head_left"></div>            	
            	<ul class="link_head link_head_center">
                	<li><a href="http://vinaphone.com.vn/new/homepage" target="_blank">Khuyến mại</a></li>
                    <li>|</li>
                	<li><a href="http://quatangamnhac.chacha.vn" target="_blank">Quà tặng âm nhạc</a></li>
                    <li>|</li>
                    <li><a href="http://vinaphone.com.vn/idea/homepage" target="_blank">Ý tưởng sáng tạo</a></li>
                    <li>|</li>
                    <li><a href="http://chonso.vinaphone.com.vn" target="_blank">Chọn số</a></li>
                    <li>|</li>
                    <li><a href="http://cskh.vinaphone.com.vn/" target="_blank">Chăm sóc khách hàng</a></li>
                    <li>|</li>
                    <li><a href="http://careplus.vinaphone.com.vn/" target="_blank">Careplus</a></li>
                    <li>|</li>
                    <li class="more_vina"><a href="#">Khác <i class="icon icon_more"></i></a>
                    	<ul class="vina_more">
                            <li><a href="http://3g.vinaphone.com.vn/" target="_blank">VinaPhone 3G</a></li>
                            <li><a href="http://iphone.vinaphone.com.vn/" target="_blank">iPhone</a></li>
                            <li><a href="http://blackberry.vinaphone.com.vn/" target="_blank">BlackBerry</a></li>
                        </ul>
                    </li>
                </ul>
        		<div class="link_head_right"></div>
            </div>
        </div>
    </div>
    <div class="bottom_head">
    	<div class="wapper">
    		<div class="fll"><a href="/" ><img src="<?php echo Yii::app()->request->baseUrl ?>/images/logo-chacha-home.png" class="icon_home" alt="Home"/></a></div>
			<?php include_once '_topmenu.php';?>
			<div class="search fll">
            	<form id="HeadSearch" name="HeadSearch" method="get" action="<?php echo Yii::app()->createUrl("/search")?>">
            		<!-- <input type="text" class="search autocomplete" name="keyword" id="keyword" value="" /> -->           		
            		<input type="text" class="search autocomplete" id="keyword" name="keyword" onblur="if(this.value=='') this.value='Nhập từ khóa' ;" onfocus="if(this.value=='Nhập từ khóa') this.value='';" value="Nhập từ khóa" />            		
                	<a href="javascript:;" id="submit-search"><i class="icon icon_search"></i></a>
                </form>
            </div>            
            <ul class="btn_login fll" id="user-menu-box">
            <?php if (Yii::app()->user->isGuest) :?>
                <li><a rel="<?php echo Yii::app()->createUrl("user/loginPopup", array('class'=>'top'))?>" class="has-ajax-pop">Đăng nhập</a></li>
                <li>|</li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl("user/register")?>">Đăng ký</a></li>
            <?php else:?>
            	<li class="sub_hover user-menu">
            	<img class="user-avatar" src="<?php echo AvatarHelper::getAvatar("user", Yii::app()->user->id,50)?>" width="25" height="25" />
            		<a href="<?php echo Yii::app()->createUrl("/user/detail"); ?>">
            			<span><?php echo Formatter::smartCut(Yii::app()->user->username, 12) ?></span>
            		</a>
            		<ul class="sub_nav">
	            		<li><a href="<?php echo Yii::app()->createUrl("/user/detail", array('id'=>$userId, 'tab'=>'playlist')); ?>">Playlist của tôi</a></li>
		                <li><a href="<?php echo Yii::app()->createUrl("/user/detail", array('id'=>$userId, 'tab'=>'song')); ?>">Bài hát của tôi</a></li>
		                <li><a href="<?php echo Yii::app()->createUrl("/user/detail", array('id'=>$userId, 'tab'=>'mv')); ?>">MV của tôi</a></li>
		                <li><a href="<?php echo Yii::app()->createUrl("/user/edit", array('id'=>$userId, 'tab'=>'setting')); ?>">Thiết lập</a></li>
		                <li><a href="<?php echo Yii::app()->createUrl("user/logout") ?>">Thoát</a></li>
            		</ul>
            	</li>
            <?php endif;?>
            </ul>
            
        </div>
    </div>
</div>
<div id="wapper">
	<div class="wapper">
		<?php if("index"!=$controller->id && "index"!=$action):?>
        <?php $this->widget("application.widgets.web.common.Banner",array("position"=>"banner_top"))?>
        <?php endif;?>
    	<div id="content">
    		<?php if("index"==$controller->id && "index"==$action):?>
        	<div class="slide_show fll">
            <?php $this->widget('application.widgets.web.slideshow.Init',array()); ?>
            </div>
            <div class="connection flr">
			<?php $this->widget('application.widgets.web.collection.HomeCollection',array()); ?>
            </div>
            <?php endif;?>
            <?php
            	if($this->breadcrumbs){
					$this->widget('application.widgets.web.common.VBreadcrumbs', array(
							'links'=>$this->breadcrumbs,
							'htmlOptions'=>array('class'=>'breadcrumbs','id'=>'breadcrumb'),
					));
            	}
            ?>
            <div class="content">
			<?php echo $content ?>
            </div>
        </div>
    </div>
</div>
<div id="footer">
<div id="wrr-ft">
	<div class="wapper">
        <div class="top_footer ovh">
            <ul class="col_ft fll">
                <li>Trợ giúp</li>
                <li><a rel="nofollow" href="#">Đường dây nóng 19001091</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl("/html/index", array('id'=>4)); ?>">Hướng dẫn sử dụng</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl("/html/index", array('id'=>34)); ?>">Câu hỏi thường gặp</a></li>
            </ul>
            <ul class="col_ft fll">
                <li>Thông tin</li>
                <li><a href="#">Giới thiệu</a></li>
                <li><a href="<?php echo Yii::app()->createUrl("/html/index", array('id'=>1)); ?>">Điều khoản sử dụng</a></li>
                <li><a href="<?php echo Yii::app()->createUrl("/html/index", array('id'=>13)); ?>">Giá cước</a></li>
            </ul>
            <ul class="col_ft fll icon_head">
                <li>Kết nối</li>
                <li><i class="icon icon_face"></i><a rel="nofollow" href="http://www.facebook.com/Chachavn">Chacha trên Facebook</a></li>
                <li><i class="icon icon_twitter"></i><a rel="nofollow" href="#">Chacha trên Twitter</a></li>
                <li><i class="icon icon_rss"></i><a rel="nofollow" href="#">Bản tin âm nhạc RSS</a></li>
                <li><i class="icon icon_youtube"></i><a rel="nofollow" href="#">Chacha trên Youtube</a></li>
            </ul>
            <ul class="col_ft fll">
                <li><i class="icon icon_chacha"></i></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/chart');?>">Bảng xếp hạng</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/song');?>">Bài hát</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/video');?>">MV</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/album');?>">Album</a></li>
            </ul>
            <ul class="col_ft fll">
                <li></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/artist');?>">Nghệ sĩ</a></li>
                <li><a rel="nofollow" href="<?php echo Yii::app()->createUrl('/news');?>">Tin tức</a></li>
            </ul>
        </div>
        <div class="bottom_footer ovh">
            <p class="fs11 marb15">Giấy phép số: 337/GP-BC do Bộ Thông Tin - Truyền thông cấp ngày 10/11/2006 | Bản quyền của Vinaphone - Thiết kế và phát triển bởi Vega Corporation</p>
        </div>
        <div id="sy1"></div>
    <div id="sy2"></div>
    </div>
    </div>
</div>
<div id="page_id" style="display: none;"><?php echo strtolower($controller->id)."_".strtolower($action) ?></div>
<div id="user_id" style="display: none;"><?php echo $userId ?></div>
<div id="dialog" style="display: none;"></div>
<div id="overlay" style="display: none;"></div>

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"DZWpi1awA+00Mv", domain:"chacha.vn",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=DZWpi1awA+00Mv" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
</div>
</body>
</html>
