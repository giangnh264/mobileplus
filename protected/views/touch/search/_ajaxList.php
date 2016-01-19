<?php
switch ($search_type)
{
	case "song":
		$this->renderPartial('_ajaxListSong',array('total_results'=>$total_results));
		break;
	case "clip":
		$this->renderPartial('_ajaxListVideo',array('total_results'=>$total_results));
		break;
	case "album":
		$this->renderPartial('_ajaxListAlbum',array('total_results'=>$total_results));
		break;
	
	case "artist":
		$this->renderPartial('_ajaxListArtist',array('total_results'=>$total_results));
		break;
        case "videoplaylist":
		$this->renderPartial('_ajaxListVideoPlaylist',array('total_results'=>$total_results));
		break;
}