<footer>
    <div class="social">
        <a href="#"><img src="../web/images/social/fb.png" class="icon_bf"></a>
        <a href="#"><img src="../web/images/social/tw.png" class="icon_bf"></a>
        <a href="#"><img src="../web/images/social/gp.png" class="icon_bf"></a>
        <a href="#"><img src="../web/images/social/yt.png" class="icon_bf"></a>
        <div style="padding-top: 5px" class="fb-like" data-href="http://mobileplus.vn/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false">

        </div>
    </div>
    <div class="about">
        <p>Ha Noi Head Office: R 12A04, 17T8 Building, Hoang Dao Thuy, Ward Trung Hoa, Cau Giay Dist., Ha Noi</p>
        <a>
            © 2016  Powered By SUSOFT
        </a>|
        <a>
           Về chúng tôi
        </a>|
        <a>
           Chính sách bảo mật
        </a>
    </div>
    <ul>
        <li>
            <img src="../web/images/top.png">
        </li>
        <li>TOP</li>
    </ul>
</footer>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/wp-embed.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/skip-link-focus-fix.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/custom.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/carousel.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/jquery.cycle2.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/jquery.mmenu.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl . "/web/js/jquery.placeholder.min.js");
?>