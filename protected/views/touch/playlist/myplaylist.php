<div class="pad10">
	<div class="vg_option list-label">
	<a href="#" class="opt_genre"><span class="fll"><?php echo Yii::t("wap","My playlist");?></span></a>
	</div>
</div>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<div class="nav-filter">
</div>
<?php
$this->widget('application.widgets.touch.playlist.MyPlaylistWidget',array('playlist'=>$playlist));
?>
