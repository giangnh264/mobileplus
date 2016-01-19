<?php
if($status ==1):
?>
	<?php echo Yii::t('wap','Bạn đã hủy gói cước của Imuzik3G thành công!');?>
	Bấm <b><a href="/">vào đây</a></b> để quay lại trang chủ.
<?php
else:
	echo $msg;
endif;
?>
