<?php 
$cTitle = isset($cTitle)?$cTitle: Yii::t("wap","All Genres");;
$sTitle = isset($sTitle)?$sTitle: Yii::t("wap","New");;
$c		= isset($c)?$c:0;
$s		= isset($s)?$s:"";
$type  	= isset($type)?$type:"";
$type2 	= isset($type2)?$type2:"status";
$params = array(
		'route'=>$route
);
if($type=='bxh'){
	if(isset($type)){
		$params['type'] = $type;
	}
	if(isset($s)){
		$params['s'] = $s;
	}
	$link1 = Yii::app()->createUrl('/ajax/getPopup', $params);
}else{
	$link1 = Yii::app()->createUrl('/ajax/getPopup', $params);
}
?>
<div class="vg_option">
	<a href="<?php echo $link1;?>" class="opt_genre ajax_popup"><span class="fll"><?php echo $cTitle; ?></span> <i class="vg_icon icon_11"></i></a>
	<a href="<?php echo Yii::app()->createUrl('/ajax/getPopup', array('route'=>$route, 'type'=>$type2, 'c'=>$c));?>" class="opt_type ajax_popup"><span class="fll"><?php echo $sTitle; ?></span> <i class="vg_icon icon_11"></i></a>
</div>
