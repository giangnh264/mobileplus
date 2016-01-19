<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <style>
			.pk-btn a{
				display: block;
			}
		</style>
    </head>
    <body style="background: #F5F4F1;padding-top: 20px;height: 500px">
    <center>
    	<div>
            <a title="Trang chủ" rel="chacha" href="/"><img src="/images/imgv2/chacha_logo.png" /></a>
        </div>
    <?php
	    $link_reg = Yii::app()->createUrl('/account/subscribe',array('confirm'=>1,'source'=>$source,'url'=>$destUrl));
    ?>
       <div id="popup-reg" style="top: 20%;position: inherit;">
	    <div class="popup-km">
	    	<h3><?php echo Yii::t("wap","Notification");?></h3>
	    	<div class="pk-ct" style="text-align: left;">
	    		<?php
	    		$btn = 'Đăng ký';
	    		if(!empty($result)){
					if($result->errorCode==401){
						$arr = explode("##", $result->message);
						foreach ($arr as $text) {
							echo yii::t('chachawap', $text) . "<br>";
						}
					}else{
						echo Yii::t('wap', Yii::app()->params['subscribe'][$result->message]);
					}
	    		}else{
		    		if($isPromotion){
		    			echo '<p>Quý khách được MIỄN PHÍ 07 ngày nghe, xem, tải TOÀN BỘ nội dung trên amusic và MIỄN CƯỚC data (3G/GPRS) khi sử dụng dịch vụ. Hãy đăng ký để trải nghiệm !</p>';
		    			$btn = 'Đăng ký khuyến mại';
		    		}else{
						echo '<p>Đăng ký  - MIỄN PHÍ nghe, xem, tải TOÀN BỘ nội dung không bị trừ data 3G khi sử dụng. Tặng kèm gói miễn phí tải nhạc chuông và tặng quà âm nhạc cho thuê bao khác</p>';
		    		}
	    		}
    			?>
	    		<div class="pk-btn">
	    			<a href="<?php echo $link_reg;?>"><?php echo $btn ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	    			<a href="<?php echo $destUrl;?>">Bỏ qua</a>
	    		</div>
	    	</div>
	    </div>
    </div>
    </center>

<?php
        GAWap::$GA_ACCOUNT = Yii::app()->params['GA_ACCOUNT'];
        $googleAnalyticsImageUrl = GAWap::googleAnalyticsGetImageUrl();
        echo '<img style="display:none" src="' . $googleAnalyticsImageUrl . '" />';
    ?>
</body>
</html>



<?php /*

<div class="padB10">
	<div class="padL5 padT10 fontB">
	<?php echo Yii::t('chachawap', 'Đăng ký');  ?>
	</div>
	<div class="padT10 padL5">
	<?php
		$flag = false;
		if(!empty($userObj)){
			$expTime = date("d/m/Y",strtotime($userObj->expired_time));
			echo "
			";
		}else if(!empty($result) && $result->errorCode != 0){
			echo $msg = Yii::t('wap', Yii::app()->params['subscribe'][$result->message]);
		}else{
			$flag = true;
			echo "Đăng ký ngay để nghe, tải bài hát, video, nhạc chuông không giới hạn, tặng quà tặng âm nhạc hoàn toàn miễn cước, phí Data = 0";
		}
	?>
	</div>
</div>
<?php if($flag):?>
<div class="padL5 padT10 padB10">
<?php echo CHtml::submitButton(Yii::t('chachawap', 'ĐĂNG KÝ'), array('submit' => Yii::app()->createUrl('/account/subscribe',array('confirm'=>1,'source'=>$source)),'class' => 'btnRed fontB')); ?>
<br /><br />
<?php echo CHtml::button(yii::t('chachawap', 'Bỏ qua'), array('submit' => Yii::app()->createUrl('/account/index'), 'class' => 'btnGrey')) ?>

<br /><br />
<div style=" color: #434343;  font-size: 13px; font-style: italic;">
<span class="fontB">Lưu ý:</span> Thuê bao được miễn phí đăng ký trong trường hợp đã hủy dịch vụ trong vòng 90 ngày tính đến thời điểm đăng ký mới.

</div>
</div>
<?php endif;?>
*/?>