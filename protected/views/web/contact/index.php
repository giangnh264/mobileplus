<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/web/css/contact_responsive.css" );
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/web/css/contact_style.css" );
?>
<section id="container">


    <form name="hongkiat" id="hongkiat-form" method="post" action="#">
        <div id="wrapping" class="clearfix">

            <section id="aligned">
                <div id="content" class="site-content row">
                    <div class="contact">
                        <h2>Thông tin liên hệ</h2>
                        <p>Công ty TNHH phần mềm Khởi Nguồn</p>
                        <p><span class="contact_title">Địa chỉ: </span><span>38/166, Đường Phúc Diễn, Nam Từ Liêm, Hà Nội</span></p>
                        <p><span class="contact_title">Điện thoại: </span><span>(043) 2442676</span></p>
                        <p><span class="contact_title">Mobile: </span><span>+84 91815988</span></p>
                        <p><span class="contact_title">Email: </span><span>congtykhoinguon@gmail.com</span></p>
                        <p style="font-style:italic">Mọi yêu cầu liên hệ hoặc đóng góp, quý khách hàng và đối tác vui lòng liên hệ với chúng tôi theo form bên dưới</p>
                    </div>
                </div>
                <input type="text" name="name" id="name" placeholder="Họ tên đầy đủ" autocomplete="off" tabindex="1" class="txtinput">

                <input type="email" name="email" id="email" placeholder="Email" autocomplete="off" tabindex="2" class="txtinput">

                <textarea name="message" id="message" placeholder="Nội dung liên hệ" tabindex="5" class="txtblock"></textarea>
            </section>

            <section id="aside" class="clearfix">
                <div class="googlee_maps">
                    <p>Vị trí trên bản đồ</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3723.621225401771!2d105.79793294902059!3d21.047836504270222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1453011294580" width="475" height="396" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </section>
        </div>
        <section id="buttons">
            <input type="submit" value="Gửi liên hệ">
            <a class="has-ajax-pop" rel="/contact/project">Kích hoạt dự án</a>
        </section>
    </form>
</section>