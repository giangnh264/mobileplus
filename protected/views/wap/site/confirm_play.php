<div class="padT35">
    <p style="text-align: justify; color: red; font-weight:bold;">
        <?php echo $msg ?>
    </p>
    </br>
    <div class="padT10"><b><a href="<?php echo Yii::app()->createUrl('/site');?>">Quay lại trang chủ</a></b></div>

</div>
<div class="mar0_auto">
        <a class="new_login" href="<?php echo Yii::app()->createUrl('account/register');?>">Đăng ký dịch vụ</a>
        <?php $title = ($type == 'song') ? "Nghe" : 'Xem';?>
        <a class="new_login" href="<?php echo Yii::app()->createUrl("/$type/view", array('id'=>$content_id, 'play'=>1, 'confirm'=>'success'));?>"><?php echo $title;?></a>
</div>