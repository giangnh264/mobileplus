<div id="Popup">
<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/touch/css/popup_rbt.css" );

if(Yii::app()->user->isGuest || !Formatter::isMobiPhoneNumber($userPhone)){
	$cs->registerScript("rbt","
	function downloadrbt(rbt_name,artist_name,code,price,type){
		$('#rbt-download').show();
		$('#rbt-list').hide();
		return false;
	}
");
}else{
	$cs->registerScript("rbt","
	function downloadrbt(rbt_name,artist_name,code,price,type){
		$('.ui-dialog').css('width','400px');
		$('#rbt-download').show();
		$('#rbt-list').hide();
		$('#down_rbt_name').html(rbt_name);
		$('#down_rbt_artist').html(artist_name);
		$('#down_rbt_code').html(code);
		$('#down_rbt_price').html(price) ;
		$('#rbt_code').val(code);
		if(type=='buy'){
			$('#down_rbt_txt').html('Cài đặt nhạc chờ cho thuê bao bạn đang sử dụng: '+'<b>".Yii::app()->user->getState('msisdn')."</b>') ;
			$('#to_phone').val('".Yii::app()->user->getState('msisdn')."');
			$('#to_phone').css('display','none');
		}else{
			$('#down_rbt_txt').html('Nhập số điện thoại người nhận');
			$('#to_phone').val('');
		}
		return false;
	}
			
	function submit_rbt(){
		$.ajax({
			type: 'POST',
			url: '".Yii::app()->createAbsoluteUrl('/ajax/downloadRbt', array('id' => $song['id']))."',
			data: $('#rbt_form').serialize(),
			dataType: 'json',
			beforeSend: function() {
				$('#popup-loading').html('<img src=\"/touch/images/ajax_loading.gif\" />');
			},
			success: function(data) {
				$('#popup-loading').html('');
				$('#popup-message').show();
				$('#popup-message').html(data.message);
				$('#rbt-download').hide();
				
			},
			complete: function() {
				$('#popup-loading').html();
			},
			statusCode: {
				404: function() {
					alert('Lỗi kết nối');
					return false;
				}
			}
		});
		return false;
	}
	
");
}
?>
<a href="javascript:void(0)" class="popup_close">X</a>
<div id="popup_wr">
	<div class="popup_title">
		<span id="pop_title"><?php echo Yii::t("wap","Nhạc chờ");?></span>
	</div>
	<div class="popup_content">
	
<?php 

$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => "",
		'method' => 'post',
		'htmlOptions' => array (
				'class' => 'popupform',
				'id'=>'rbt_form',
		)
) );

?>
<?php if($rbts): ?>
<div class="box-white popup-box">
	<div id="popup-loading"></div>
	<div id="popup-message" style="color: #FF0000;padding:40px 10px; display:none"></div>
	<div id="rbt-list">
		<ul>
		<?php $i=0; foreach($rbts as $rbt):?>
			<li>
				<div class="zone-1">
					<div class="rbt-name width40"><?php echo Formatter::smartCut(CHtml::encode($rbt['name_song']), 40) ?> <span class="rbt-price">(<?php echo $rbt['price']?>Đ)</span></div>
					<div class="rbt-price width15">
						<span class="rbt-artist"><?php echo Formatter::smartCut(CHtml::encode($rbt['name_singer']), 14)?></span>
					</div>
				</div>
				<div class="zone-2">
					<div class="rbt-download width15"><a href="javascript:;" title="<?php echo Yii::t('web','Download'); ?>" class="icon_down_rbt"  onclick="downloadrbt('<?php echo $rbt['name_song'] ?>','<?php echo $rbt['name_singer'] ?>','<?php echo $rbt['code']?>','<?php echo $rbt['price']?>','buy')">Tải</a></div>
					<div class="rbt-gift width15"><a href="javascript:;" title="<?php echo Yii::t('web','Tặng'); ?>" class="icon_gift_rbt"  onclick="downloadrbt('<?php echo $rbt['name_singer'] ?>','<?php echo $rbt['name_singer'] ?>','<?php echo $rbt['code']?>','<?php echo $rbt['price']?>','gift')">Tặng</a>
				</div>

			</li>
		<?php $i++; endforeach;?>
		</ul>

	</div>
	<div id="rbt-download" style="display: none;">
		<div class="rbt_head">
			<?php if(Yii::app()->user->isGuest || !Formatter::isMobiPhoneNumber($userPhone)):?>
			<div class="popup-message">
			<?php echo Yii::t('web','Chức năng nhạc chờ chỉ áp dụng cho các tài khoản là thuê bao Mobifone'); ?>
			</div>
			<?php else:?>
			<div class="row"><h3 id="down_rbt_name"></h3></div>
			<div class="row color-989898"><?php echo Yii::t('web','Ca sỹ'); ?>: <span id="down_rbt_artist"></span></div>
			<div class="row color-989898"><?php echo Yii::t('web','Mã số'); ?>: <span id="down_rbt_code"></span></div>
			<div class="row color-989898"><?php echo Yii::t('web','Giá'); ?>: <span id="down_rbt_price"></span></div>
			<div class="row" id="">
				<span id="down_rbt_txt"></span>
				<input type="text" name="to_phone" id="to_phone" class="input-text" style="float: left; margin: 10px 0px; height: 30px; width: 90%;" />
			</div>
		</div>
		<div class="row submit hidden">
			<input type="hidden" name="rbt_code" id="rbt_code" value="" />
		</div>
		<div class="rbt_submit">
		<button id="sb_playlist" class="i-button button-dark " type="button" onclick="submit_rbt()">
			<?php echo Yii::t("web","Agree");?>
		</button>
		<?php

			/* echo CHtml::ajaxSubmitButton(Yii::t('web','Agree'),CHtml::normalizeUrl(array('song/rbt','render'=>false)),
				array(
					'dataType'=>'json',
					'beforeSend'=>'js: function() {
						$("#popup-loading").html(ajax_loading_content);
					}',
					'success'=>'js: function(data) {
						$("#popup-loading").html("");
						if(data.errorCode != 0){
							if(data.errorCode==1){
								$("#popup-message").html(data.message);
							}else{
								$("#popup-message").html("Transaction failed, please try again later");
							}
							console.log(data.message)
							$("#popup-message").removeClass("msg-success").addClass("msg-error");
						}else{
							$("#popup-message").html("Successful transactions");
							$("#popup-message").removeClass("msg-error").addClass("msg-success");
						}
					}'
					),
				array('id'=>'close-dialog','live' =>false,'class'=>'button-sub')); */

	?>
		</div>
	</div>
	<?php endif;?>
</div>
<?php else: ?>
<div class="padt20 padb20 padl10" style="padding: 30px">
	<p><?php echo Yii::t('web','Hệ thống không tìm thấy nhạc chờ nào tương ứng'); ?></p>
</div>
<?php endif;?>
<?php
$this->endWidget ();

?>
</div>
</div>
</div>