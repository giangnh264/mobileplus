<div class="collapse-10">
    <div class='list-label mr-t-15 clearfix'>
        <a href='#' class='head left'><?php echo Yii::t("wap","News");?></a>
    </div>
</div>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">

<?php
$this->widget ( 'application.widgets.touch.news.NewsListWidget', array (
		'news' => $news
) );
?>