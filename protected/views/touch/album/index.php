<?php 
$this->renderPartial('/ajax/_filter_nav', array(
	'cTitle'	=>	Yii::t('wap','Tất cả thể loại'),
	'sTitle'	=>	Yii::t('wap','Hot'),
	'route'		=>	'/album/list',
	'c'			=>	0
));
?>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo Yii::app()->createUrl("/album/list", array( 'c' => 0, 's' => 'HOT')); ?>">
<?php
$this->widget('application.widgets.touch.album.AlbumListWidget',array('albums'=>$arr_albums[0]['album']));
?>