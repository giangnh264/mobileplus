<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<?php
if(count($videos)>0){
	$this->widget ( 'application.widgets.touch.video.VideoList', array (
			'videos' => $videos,
			'options' => $options,
	) );
}else{
	echo 'Không tìm thấy video nào';
}
?>

