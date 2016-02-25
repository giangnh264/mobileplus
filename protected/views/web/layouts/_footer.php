<footer>
    <div class="social">
        <a href="#"><img src="http://mobileplus.vn/web/images/social/fb.png" class="icon_bf"></a>
        <a href="#"><img src="http://mobileplus.vn/web/images/social/tw.png" class="icon_bf"></a>
        <a href="#"><img src="http://mobileplus.vn/web/images/social/gp.png" class="icon_bf"></a>
        <a href="#"><img src="http://mobileplus.vn/web/images/social/yt.png" class="icon_bf"></a>
        <div style="padding-top: 5px" class="fb-like" data-href="http://mobileplus.vn/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false">

        </div>
    </div>
    <div class="about">
        <p>38/166, Đường Phúc Diễn, Nam Từ Liêm, Hà Nội</p>
        <a>
            © 2016  Powered By Mobileplus
        </a>|
        <a>
           Về chúng tôi
        </a>|
        <a>
           Chính sách bảo mật
        </a>
    </div>
    <ul id="toppage" style="overflow:hidden;">
        <li>
            <img style="cursor: pointer" src="http://mobileplus.vn/web/images/top.png">
        </li>
        <li >TOP</li>
    </ul>
</footer>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>
    $('#toppage').on('click', function(){
        $('html').animate({scrollTop:0}, 'slow');//IE, FF
        $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works
        $('.popupPeriod').fadeIn(1000, function(){
            setTimeout(function(){$('.popupPeriod').fadeOut(2000);}, 3000);
        });
    })

</script>