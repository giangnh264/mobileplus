<div id="Popup">
	<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
		<div class="popup_title">
			<span id="pop_title">Thông báo</span>
		</div>
		<div class="popup_content">
			<div class="" style="padding: 10px; overflow: hidden;">
				<?php echo Yii::app()->params["error_limit"]?>
				<div class="clb">
					<div class="btn-popup btn-popup-green "
						style="width: 45%; float: left;">
						<?php /*<a href="<?php echo Yii::app()->createUrl("account/login") ?>"
							class="" style="color: #FFF; display: block;" onclick="alert(document.URL);"  >Đăng nhập</a>
						*/?>
						<a href="javascript:void(0)"
							class="" style="color: #FFF; display: block;" onclick="window.location.href= '<?php echo Yii::app()->createUrl("account/login") ?>?back='+document.URL"  >Đăng nhập</a>
							
					</div>

					<div class="btn-popup btn-popup-green " onclick=" Popup.close();"
						style="width: 45%; float: right;">
						<a href="javascript:void(0)" style="color: #FFF">Bỏ qua</a>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>
