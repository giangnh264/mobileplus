<div class="collapse-10">
    <div class='list-label mr-t-15 clearfix'>
        <a href='#' class='head left'>Thế giới có gì</a>
    </div>
</div>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<?php
if(count($videos)>0):
	$this->widget ( 'application.widgets.touch.video.VideoList', array (
			'videos' => $videos,
	) );
else:
?>
<p class="collapse-10 mr-t-5">Không tìm thấy video nào</p>
<?php endif; ?>
