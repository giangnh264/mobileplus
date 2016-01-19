<?php
$cTitle = isset($cTitle)?$cTitle: Yii::t("wap","Tất cả thể loại");
$sTitle = isset($sTitle)?$sTitle: Yii::t("wap","Mới");
$c		= isset($c)?$c:0;
$s		= isset($s)?$s:"";
$type  	= isset($type)?$type:"";
$type2 	= isset($type2)?$type2:"status";
$params = array(
		'route'=>$route,
		's'=>$s,
		'name'=>CHtml::encode($cTitle)
);
if($type=='bxh'){
	if(isset($type)){
		$params['type'] = $type;
	}
	if(isset($s)){
		$params['s'] = $s;
	}
	$link1 = Yii::app()->createUrl('/ajax/getPopup').'?'.http_build_query($params);
}else{
	$link1 = Yii::app()->createUrl('/ajax/getPopup').'?'.http_build_query($params);
}
?>
<div class="pad10">
<div class="vg_option list-label mr-t-15 clearfix">
	<a href="<?php echo $link1;?>" class="opt_genre ajax_popup"><span class="fll"><?php echo Formatter::smartCut($cTitle,15,0); ?></span> <i class="vg_icon icon_11"></i></a>
	<a href="<?php echo Yii::app()->createUrl('/ajax/getPopup').'?'.http_build_query(array('route'=>$route, 'type'=>$type2, 'c'=>$c,'name'=>CHtml::encode($cTitle)));?>" class="opt_type ajax_popup"><span class="fll"><?php echo $sTitle; ?></span> <i class="vg_icon icon_11"></i></a>
</div>
</div>
