<?php 
$this->renderPartial('/ajax/_filter_nav', array(
	'cTitle'=>Yii::t("wap","Tất cả thể loại"),//'Tất cả thể loại',
	'sTitle'=>'Hot',
	'route'=>'/song/list'
));
?>
        	
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">

<?php
$this->widget ( 'application.widgets.touch.song.SongList', array (
		'songs' => $arr_songs[0]['song'],
) );
?>

