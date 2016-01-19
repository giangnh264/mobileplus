<div class="vg_option">
	<a href="#" class="opt_genre"><span class="fll">Đăng nhập</span></a>
</div>
<style>
    .login-wifi label{
        width: 200px;
    }
    #login-wifi{
        padding: 20px 10px;
    }
</style>
<div id="login-wifi">
    <div class="form">
        <form name="verify" method="post">
            <span class="label">Mã xác nhận đã được gửi đến số điện thoại: <b><?php echo $phone; ?></b></span>
            <div>Hãy nhập mã xác nhận vào ô bên dưới và nhấn nút <b>Xác nhận</b>.</div>
            <?php if ($error == 1): ?>
                <div class="error">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>
            <div class="field"><input type="text" name="code">&nbsp;&nbsp;<input class="button bt-actived" type="submit" value="Xác nhận"/></div>
        </form>
    </div>
</div>