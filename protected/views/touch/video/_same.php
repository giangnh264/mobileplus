<input type="hidden" class="total-page"	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"	value="<?php echo $callBackLink ?>">

<ul class="video_list items-list">
<?php
	$this->renderPartial("_ajaxList",array('videos'=>$videos,'pager'=>$pager));
?>
</ul>