<div class="box_title">
    <h2 class="name"><a href="<?php echo $this->link;?>"><?php echo Yii::t('web',$this->title);  ?></a></h2>
    <?php if ($this->type != 'artist' && $this->type !='search'): ?>
        <div class="flr mr-t-15">
            <ul class="btn_ty">
                <li><a class="video_playlist_prev" href="javascript:void(0)"><i class="icon icon_pre"></i></a></li>
                <li style="margin:0 0 0 10px !important"><a class="video_playlist_next" href="javascript:void(0)"><i class="icon icon_next"></i></a></li>
            </ul>
        </div>
    <?php endif; ?>
</div>
<div class="content_box">
	<div id="video_playlist_mask">
		<div id="video_playlist_contain">
		<?php
		$i=0;
		foreach ($this->List as $item):
		$urlKey = ($item->url_key)?$item->url_key:Common::makeFriendlyUrl(trim($item->name));
		$link = Yii::app()->createUrl("videoplaylist/view",array("id"=>$item->id,"title"=>$urlKey));
		if (fmod($i, 4) == 0){
			echo '<ul class="list_video_playlist video_playlist_page" style="width: 870px;float:left">';
		}
		?>

		<li class="<?php if($i%4 == 3) echo 'marr_0'; else echo '';?>">
			<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->name).' - '.CHtml::encode($item->artist_name); ?>">
				<img src="<?php echo AvatarHelper::getAvatar("videoPlaylist", $item->id,300)?>" width="200" alt="<?php echo CHtml::encode($item->name).' - '.CHtml::encode($item->artist_name); ?>" />
			</a>
			<div class="info">
				<h3 class="name over-text">
					<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->name);?>"><?php echo CHtml::encode($item->name);?></a>
				</h3>
				<p class="singer padt2 over-text">
					<a href='<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($item->artist_name)));?>' title="<?php echo CHtml::encode($item->artist_name); ?>"><?php echo CHtml::encode($item->artist_name); ?></a>
				</p>
			</div>
			<a title="<?php echo CHtml::encode($item->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
		</li>
		<?php
		if (fmod($i, 4) == 3 || $i==count($this->List)-1){
			echo '</ul>';
		}
		$i++; endforeach;?>
		</div>
	</div>
</div>