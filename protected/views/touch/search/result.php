<?php
$res = $total_results;

?>

<?php
	//$totalCount = ($res['song']['numFound']+$res['album']['numFound']+$res['clip']['numFound']+$res['rbt']['numFound']);
	
	echo '<div class="pad-10"><span style="color: #006CB8;font-weight: bold;font-size: 16px">'.Yii::t("wap","Results for your search").':</span> "'. CHtml::encode($keyword).'"</div>';
	//echo '<div class="pad10">Tìm được '.number_format($totalCount).' kết quả</div>';
	
	if($res['song']['numFound']>0){
		echo '<div class="search-head-label clearfix"><div class="wrr-head-search">('.$res['song']['numFound'] . ' ' . Yii::t("wap","Bài hát").')</div></div>';
		$this->widget ( 'application.widgets.touch.song.SongList', array (
				'songs' => $res['song']['results'],
				'type'=>'search'
		));
                if($res['song']['numFound']>5){
		echo '<div class="pad-10 clearfix"><a href="'.Yii::app()->createUrl('/search/list', array('q'=>$keyword, 'type'=>'song')).'" class="readmore">'. Yii::t("wap","See more") .' &raquo;</a></div>';
	}
        }else{
            echo '<div class="search-head-label clearfix"><div class="wrr-head-search">'. Yii::t("wap","Song not found")  .'</div></div>';
        }
	
	if($res['album']['numFound']>0){
		echo '<div class="search-head-label clearfix"><div class="wrr-head-search">('.$res['album']['numFound'] .' ' . Yii::t("wap","albums"). ')</div></div>';
		$this->widget('application.widgets.touch.album.AlbumListWidget',array(
				'albums'=>$res['album']['results'],
				'type'=>'search'
		));
                if($res['album']['numFound']>5){
		echo '<div class="pad-10 clearfix"><a href="'.Yii::app()->createUrl('/search/list', array('q'=>$keyword, 'type'=>'album')).'" class="readmore">'. Yii::t("wap","See more") .' &raquo;</a></div>';
	}
        }else{
            echo '<div class="search-head-label clearfix"><div class="wrr-head-search">'. Yii::t("wap","Album not found")  .'</div></div>';
        }
	
	//Clip
	if($res['clip']['numFound']>0){
		echo '<div class="search-head-label clearfix"><div class="wrr-head-search">('.$res['clip']['numFound'] . ' ' . Yii::t("wap","Videos") .')</div></div>';
		$this->widget ( 'application.widgets.touch.video.VideoList', array (
				'videos' => $res['clip']['results'],
				'type'=>'search'
		));
                if($res['clip']['numFound']>5){
		echo '<div class="pad-10 clearfix"><a href="'.Yii::app()->createUrl('/search/list', array('q'=>$keyword, 'type'=>'clip')).'" class="readmore">'. Yii::t("wap","See more") .' &raquo;</a></div>';
	}
	}else{
            echo '<div class="search-head-label clearfix"><div class="wrr-head-search">'. Yii::t("wap","Video not found")  .'</div></div>';
        }
	
	//Artist
	if($res['artist']['numFound']>0){
		echo '<div class="search-head-label clearfix"><div class="wrr-head-search">('.$res['artist']['numFound'] . ' ' .Yii::t("wap","Ca sĩ") . ')</div></div>';
		$this->widget ( 'application.widgets.touch.artist.ArtistList', array (
				'artists' => $res['artist']['results'],
				'type'=>'search'
		));
                if($res['artist']['numFound']>5){
		echo '<div class="pad-10 clearfix"><a href="'.Yii::app()->createUrl('/search/list', array('q'=>$keyword, 'type'=>'artist')).'" class="readmore">'. Yii::t("wap","See more") .' &raquo;</a></div>';
	}
	}else{
            echo '<div class="search-head-label clearfix"><div class="wrr-head-search">'. Yii::t("wap","Artist not found")  .'</div></div>';
        }
	
        
        if($res['videoplaylist']['numFound']>0){
		echo '<div class="search-head-label clearfix"><div class="wrr-head-search">('.$res['videoplaylist']['numFound'] .' ' . Yii::t("wap","video playlist") .')</div></div>';
		$this->widget ( 'application.widgets.touch.videoPlaylist.VideoPlaylistListWidget', array (
				'videoPlaylists' => $res['videoplaylist']['results'],
				'type'=>'search'
		));
                if($res['videoplaylist']['numFound']>5){
		echo '<div class="pad-10 clearfix"><a href="'.Yii::app()->createUrl('/search/list', array('q'=>$keyword, 'type'=>'videoplaylist')).'" class="readmore">'. Yii::t("wap","See more") .' &raquo;</a></div>';
	}
	
	}else{
            echo '<div class="search-head-label clearfix"><div class="wrr-head-search">'. Yii::t("wap","Video playlist not found")  .'</div></div>';
        }
	
?>
