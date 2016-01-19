<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
		<div class="popup_title">
                    <span id="pop_title"><?php echo Yii::t("wap","Genre");?></span>
		</div>
		<div class="popup_content">
                    <ul class="list_genre">
                        <li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => 'VN','type'=>  strtoupper($s)));?>"><?php echo Yii::t("wap","BXH VIỆT NAM");?></a></li>
                        <li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => 'EUR','type'=>  strtoupper($s)));?>"><?php echo Yii::t("wap","BXH ÂU MỸ");?></a></li>
                        <li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => 'KOR','type'=>strtoupper($s)));?>"><?php echo Yii::t("wap","BXH CHÂU Á");?></a></li>
                    </ul>
		</div>
	</div>
</div>
