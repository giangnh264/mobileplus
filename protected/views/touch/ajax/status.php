<div id="Popup">
<a href="javascript:void(0)" class="popup_close icon-pl-close"></a>
	<div id="popup_wr">
	<div class="popup_title">
		<span id="pop_title"><?php 
			if($route=='bxh/index' && $route=='favourite/index'){
				echo Yii::t('wap','Genre');
			}else if($route == '/album/list'){
				$type = 'album';
				echo Yii::t('wap','Xu hướng');
			}else if($route == '/video/list'){
				$type = 'video';
				echo Yii::t('wap','Xu hướng');
			}else{
                                $type = 'song';
				echo Yii::t('wap','Xu hướng');
			}?>
		</span>
	</div>
	<div class="popup_content">
		<ul class="list_genre">
		<?php if ($route =='bxh/index' ):?>
        <li><a href="<?php echo Yii::app()->createUrl("$route", array('id'=>$c, 'type'=>'SONG'));?>"><?php echo Yii::t('wap','Song')?></a></li>
		<li><a href="<?php echo Yii::app()->createUrl("$route", array('id'=>$c, 's'=>'VIDEO'));?>"><?php echo Yii::t('wap','Video')?></a></li>
		<li><a href="<?php echo Yii::app()->createUrl("$route", array('id'=>$c, 's'=>'ALBUM'));?>"><?php echo Yii::t('wap','Album')?></a></li>
		<?php elseif ($route =='favourite/index' ):?>
        <li><a href="<?php echo Yii::app()->createUrl("$route", array('id'=>$c, 's'=>'SONG'));?>"><?php echo Yii::t('wap','Song')?></a></li>
		<li><a href="<?php echo Yii::app()->createUrl("$route", array('id'=>$c, 's'=>'VIDEO'));?>"><?php echo Yii::t('wap','Video')?></a></li>
		<?php else:?>
        <li><a href="<?php echo URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$name,'id'=>$c,'gt'=>'new'));?>"><?php echo Yii::t('wap','New')?></a></li>
		<li><a href="<?php echo URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$name,'id'=>$c,'gt'=>'hot'));?>"><?php echo Yii::t('wap','Hot')?></a></li>
		<?php endif;?>
		</ul>
	</div>
	</div>
</div>
