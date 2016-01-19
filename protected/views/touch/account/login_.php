<div class="vg_option">
	<a href="#" class="opt_genre"><span class="fll">Đăng nhập</span></a>
</div>
<div class="padB10" >
    <p>Bạn là thuê bao Vinaphone hãy đăng nhập để sử dụng dịch vụ qua Wifi.</p>
    <a href="/account/loginWifi" style="text-align: center; text-transform: uppercase;" class="button bt-actived">đăng nhập</a>
    <div style="clear: both;"></div>
    <br/>
    <?php
    $arr = explode("##", $registerText);
    foreach ($arr as $text) {
        echo yii::t('chachawap', $text) . "<br>";
    } 
    ?>
</div>
