<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
		<div class="popup_title">
			<span id="pop_title"><?php echo Yii::t("wap","Genre");?></span>
		</div>
		<div class="popup_content">
			<ul class="list_genre">
				<li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => $c,'type'=>'SONG'));?>" ><?php echo Yii::t("wap","bài hát");?></a></li>
				<li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => $c,'type'=>'VIDEO'));?>" ><?php echo Yii::t("wap","VIDEO");?></a></li>
				<li><a href="<?php echo URLHelper::makeUrlChart(array('genre' => $c,'type'=>'ALBUM'));?>" ><?php echo Yii::t("wap","ALBUM");?></a></li>
			</ul>
		</div>
	</div>
</div>
