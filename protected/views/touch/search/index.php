<?php
$res = $total_results[$search_type];
$pager = $res['pages'];
$callBackLink = Yii::app()->createUrl('search/loadAjax',array('q'=>$keyword, 'type'=>$search_type));

switch ($search_type){
	case "song":
		$title =  Yii::t("wap",'Song');
		break;
	case "clip":
		$title =  Yii::t("wap",'Video');
		break;
	case "album":
		$title =  Yii::t("wap",'Album');
		break;
	case "artist":
		$title =  Yii::t("wap",'Artist');
		break;
        case "videoplaylist":
		$title =  Yii::t("wap",'Video Playlist');
		break;
}

?>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">
<div class="pad10">
<div class="vg_option list-label mr-t-15 clearfix">
	<a href="<?php echo Yii::app()->createUrl('/ajax/getPopupFilterSearch', array('route'=>'', 'keyword'=>$keyword));?>" class="opt_genre ajax_popup"><span class="fll"><?php echo $title; ?></span> <i class="vg_icon icon_11"></i></a>
</div>
</div>

<?php
if(count($res['results'])==0){
	echo '<div class="msg" style="padding: 10px;font-size: 13px">Không tìm thấy kết quả nào phù hợp với từ khóa</div>';
}
else{
	switch ($search_type){
		case "song":
			$this->widget ( 'application.widgets.touch.song.SongList', array (
			'songs' => $res['results'],
			'type'=>'search'
					));
					break;
		case "clip":
			$this->widget ( 'application.widgets.touch.video.VideoList', array (
			'videos' => $res['results'],
			'type'=>'search'
					) );
					break;
		case "album":
			$this->widget('application.widgets.touch.album.AlbumListWidget',array(
			'albums'=>$res['results'],
			'type'=>'search'
					));
					break;
		
		case "artist":
			$this->widget('application.widgets.touch.artist.ArtistList',array(
			'artists' => $res['results'],
			'type'=>'artist'
					));
					break;
                case "videoplaylist":
			$this->widget('application.widgets.touch.videoPlaylist.VideoPlaylistListWidget',array(
			'videoPlaylists' => $res['results'],
				'type'=>'search'
					));
					break;
}
}


?>
