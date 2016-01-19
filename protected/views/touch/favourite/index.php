<div class="pad10">
<div class="vg_option list-label mr-t-15 clearfix">
	<a href="#" class="opt_genre popup_inline" rel="dd"><span class="fll"><?php echo $sTitle ?></span>
		<i class="vg_icon icon_11"></i></a>
</div>
</div>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">

<div class=" clb">
	<div class="bl_item">
    <?php if ($s == "SONG"):?>
	    <?php
		    if($listfavourite):
		    $this->widget ( 'application.widgets.touch.song.SongList', array (
					'songs' => $listfavourite
			) );
                    else: echo Yii::t("wap","Song not found");
                    endif;

	    ?>
    <?php elseif($s=='ALBUM'):?>
    <?php
    if($listfavourite):
    	$this->widget ( 'application.widgets.touch.album.AlbumListWidget', array (
    			'albums' => $listfavourite
    	) );
    else: echo Yii::t("wap","Album not found");
	endif;

    ?>
	<?php elseif($s=='VIDEOPLAYLIST'):?>
		<?php
		if($listfavourite):
			$this->widget('application.widgets.touch.videoPlaylist.VideoPlaylistListWidget',array('videoPlaylists'=>$listfavourite, 'options'=>array()));


		else: echo Yii::t("wap","Video playlist not found");
		endif;

		?>
              <?php elseif($s=='VIDEO'):?>
    <?php
    if($listfavourite):
	    $this->widget ( 'application.widgets.touch.video.VideoList', array (
				'videos' => $listfavourite
		) );
	else: echo Yii::t("wap","Video not found");
	endif;
    ?>

    <?php endif;?>
    </div>
</div>

<div id="dd" style="display: none;">
	<div id="Popup">
		<a href="javascript:void(0)" class="popup_close">X</a>
		<div id="popup_wr">
			<div class="popup_title">
				<span id="pop_title"><?php echo Yii::t("wap","Favourite");?></span>
			</div>
			<div class="popup_content">
				<ul class="list_genre">
					<li><a href="<?php echo Yii::app()->createUrl("/favourite/index", array('s'=>'SONG'));?>"><?php echo Yii::t("wap","Favourite songs");?></a></li>
					<li><a href="<?php echo Yii::app()->createUrl("/favourite/index", array('s'=>'VIDEO'));?>"><?php echo Yii::t("wap","Favourite videos");?></a></li>
					<li><a href="<?php echo Yii::app()->createUrl("/favourite/index", array('s'=>'ALBUM'));?>"><?php echo Yii::t("wap","Favourite albums");?></a></li>
					<li><a href="<?php echo Yii::app()->createUrl("/favourite/index", array('s'=>'VIDEOPLAYLIST'));?>"><?php echo Yii::t("wap","Favourite video playlist");?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
