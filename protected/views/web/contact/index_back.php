<div id="content" class="site-content row">
    <div class="contact">
        <h2>Thông tin liên hệ</h2>
        <p>Công ty TNHH phần mềm Khởi Nguồn</p>
        <p><span class="contact_title">Địa chỉ: </span><span>38/166, Đường Phúc Diễn, Nam Từ Liêm, Hà Nội</span></p>
        <p><span class="contact_title">Điện thoại: </span><span>(043) 2442676</span></p>
        <p><span class="contact_title">Mobile: </span><span>+84 91815988</span></p>
        <p><span class="contact_title">Email: </span><span>congtykhoinguon@gmail.com</span></p>
        <p style="font-style:italic">Mọi yêu cầu liên hệ hoặc đóng góp, quý khách hàng và đối tác vui lòng liên hệ với chúng tôi theo form bên dưới</p>
        <div class="errorSummary">
            <ul>
                <?php if($error):?>
                <li class="contact_error"><?php echo $messages;?></li>
                <?php elseif($success):?>
                <li class="contact_done"><?php echo $messages;?></li>
                <?php endif;?>
            </ul>
        </div>

        <form class="contact_sm" method="post" action="/contact/index">
            <input class="w305 <?php echo ($error_type == 'name'? 'border_error' :'');?>" type="text" name="name" placeholder="Họ tên đầy đủ" style="margin-right: 29px;" value="<?php echo $name;?>" />
            <input class="w305 <?php echo ($error_type == 'email'? 'border_error' :'');?>" type="text" name="email" placeholder="Email" value="<?php echo $email;?>" />
            <textarea class="<?php echo ($error_type == 'description'? 'border_error' :'');?>" placeholder="Nội dung liên hệ" name="description" value="<?php echo $description;?>" ></textarea>
            <input type="submit" value="Gửi liên hệ">
            <a class="has-ajax-pop" rel="/contact/project">Kích hoạt dự án</a>
        </form>
    </div>

    <div class="googlee_maps">
        <p>Vị trí trên bản đồ</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3723.621225401771!2d105.79793294902059!3d21.047836504270222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1453011294580" width="475" height="396" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</div>