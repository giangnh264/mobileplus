<?php $this->widget('application.widgets.touch.videoPlaylist.Slideshow', array('controller' => 'video'));?>

<input type="hidden" class="total-page"
	   value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	   value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	   value="<?php echo Yii::app()->createUrl("/video/list", array( 'c' => 0, 's' => 'HOT')); ?>">
<?php
$this->renderPartial('/ajax/_filter_nav', array(
	'route'=>'/video/list',
	'cTitle'=>Yii::t('wap','Tất cả thể loại'),
	'sTitle'=>Yii::t('wap','hot'),
	'c'	=>0
));?>
<?php
if(count($arr_videos[0]['video'])>0){

	$this->widget ( 'application.widgets.touch.video.VideoList', array (
		'videos' => $arr_videos[0]['video'],
		'options' => true,
		'type' => Yii::t('wap','hot'),
	) );
}else{
	echo 'Không tìm thấy video nào';
}
?>

