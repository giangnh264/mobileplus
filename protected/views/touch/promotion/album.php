<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<?php
if(count($albums)>0){
	$this->widget('application.widgets.touch.album.AlbumListWidget',array('albums'=>$albums));
}else{
	echo 'Không tìm thấy album nào';
}
?>

