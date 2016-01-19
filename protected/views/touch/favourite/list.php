<div class=" clb">
	<div class="bl_item">
            <div class="search-head-label clearfix"><div class="wrr-head-search"><a href="<?php echo Yii::app()->createUrl('/favourite/index')?>"><?php echo Yii::t("wap","Favourite songs");?></a></div></div>
	<?php   if($listfavourite['song']) :
                $this->widget ( 'application.widgets.touch.song.SongList', array (
                                    'songs' => $listfavourite['song']
                    ) );
                ?>
                <div class="pad-10 clearfix"><a href="<?php echo Yii::app()->createUrl('/favourite/index')?>" class="readmore"><?php echo Yii::t("wap","More");?>&raquo;</a></div>
            <?php else :?>
                    <div class="search-head-label clearfix"><?php echo Yii::t("wap","Song not found");?></div>
            <?php endif;?>
 
    <div class="search-head-label clearfix"><div class="wrr-head-search"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'ALBUM'))?>"><?php echo Yii::t("wap","Favourite albums");?></a></div></div>
    <?php if($listfavourite['album']):
    	$this->widget ( 'application.widgets.touch.album.AlbumListWidget', array (
    			'albums' => $listfavourite['album']
    	) );?>
    	<div class="pad-10 clearfix"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'ALBUM'))?>" class="readmore"><?php echo Yii::t("wap","More");?>&raquo;</a></div>
    <?php else :?>
            <div class="search-head-label clearfix"><?php echo Yii::t("wap","Album not found");?></div>
    <?php endif;?>
    
    <div class="search-head-label clearfix"><div class="wrr-head-search"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'VIDEO'))?>"><?php echo Yii::t("wap","Favourite videos");?></a></div></div>
    <?php if($listfavourite['video']):
	    $this->widget ( 'application.widgets.touch.video.VideoList', array (
				'videos' => $listfavourite['video']
		) );?>
            <div class="pad-10 clearfix"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'VIDEO'))?>" class="readmore"><?php echo Yii::t("wap","More");?>&raquo;</a></div>
    <?php else :?>
            <div class="search-head-label clearfix"><?php echo Yii::t("wap","Video not found");?></div>
    <?php endif;?>


        <div class="search-head-label clearfix"><div class="wrr-head-search"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'VIDEOPLAYLIST'))?>"><?php echo Yii::t("wap","Favourite video playlist");?></a></div></div>
        <?php if($listfavourite['videoplaylist']):
            $this->widget('application.widgets.touch.videoPlaylist.VideoPlaylistListWidget',array('videoPlaylists'=>$listfavourite['videoplaylist'], 'options'=>array()));
            ?>
            <div class="pad-10 clearfix"><a href="<?php echo Yii::app()->createUrl('/favourite/index',array('s'=>'VIDEOPLAYLIST'))?>" class="readmore"><?php echo Yii::t("wap","More");?>&raquo;</a></div>
        <?php else :?>
            <div class="search-head-label clearfix"><?php echo Yii::t("wap","Video playlist not found");?></div>
        <?php endif;?>
    </div>
</div>