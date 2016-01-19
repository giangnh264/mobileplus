<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div class="popup_title">
		<span id="pop_title"><?php echo Yii::t("wap","Genre");?></span>
	</div>
	<div class="popup_content">
		<ul class="list_genre">
                    <li><a href="<?php echo Yii::app()->createUrl("/search/list", array('content'=>$keyword, 'type'=>'song'));?>" ><?php echo Yii::t("wap","bài hát");?></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("/search/list", array('content'=>$keyword, 'type'=>'clip'));?>" ><?php echo Yii::t("wap","video");?></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("/search/list", array('content'=>$keyword, 'type'=>'album'));?>" ><?php echo Yii::t("wap","album");?></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl("/search/list", array('content'=>$keyword, 'type'=>'artist'));?>" ><?php echo Yii::t("wap","nghệ sĩ");?></a></li>
		</ul>
	</div>
</div>
