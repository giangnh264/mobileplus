<?php 
$this->renderPartial('/ajax/_filter_nav', array(
	'cTitle'=>$cTitle,
	'sTitle'=>$sTitle,
	'route'=>'/videoplaylist/index',
	'c'		=>$c
));
?>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<?php
$this->widget('application.widgets.touch.videoPlaylist.VideoPlaylistListWidget',array('videoPlaylists'=>$videoPlaylists, 'options'=>$options));
?>