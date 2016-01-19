<?php 
$this->renderPartial('/ajax/_filter_nav', array(
	'cTitle'=>$cTitle,
	'sTitle'=>$sTitle,
	'c'		=>$c,
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
if(count($songs)>0){
	$this->widget ( 'application.widgets.touch.song.SongList', array (
			'songs' => $songs,
                        'options'=>$options
	) );
}else{?>
	<div class="pad-10"><?php echo Yii::t("wap","Song not found");?></div>
<?php }
?>

