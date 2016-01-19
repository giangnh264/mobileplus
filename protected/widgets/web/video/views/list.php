<?php if(count($this->videos) > 0):?>
<?php if($this->option == 'box'):?>
<div class="box_video">
    <?php if(!empty($this->pageTitle)):?>
		<div class="header_box">
			<h2 class="title vertical_align"><?php echo $this->pageTitle;?></h2>&nbsp;&nbsp;&nbsp;
			<?php if ($this->moreLink): ?>
			<a href='<?php echo $this->moreLink; ?>' >
				<span class="fs11 vertical_align gray_color" ><?php echo Yii::t('web', 'More'); ?> <i class="icon icon_mt"></i></span>
			</a>
			<?php endif; ?>
		</div>
    <?php endif;?>
<?php else:?>
<div class="box_album">
    <div class="header_box mart0">
        <h1 class="title"><?php echo $this->pageTitle;?></h1>
    </div>
<?php endif;?>
    <div class="content_box">
        <ul class="list_video <?php echo ($this->option == 'box') ? '' : 'list_videos';?>">
            <?php
            $i = 0;
            foreach ($this->videos as $video):
            	if(isset($video) && ($video->id != $this->mvDetailId) && ($this->limit == 0 || ($this->limit > 0 && $i < $this->limit))):
	                $urlKey = ($video->url_key) ? $video->url_key : Common::makeFriendlyUrl(trim($video->name));
                        if($this->playlistId == 0)
                            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl($video->artist_name)));
                        else
                            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, 'playlistId' => $this->playlistId, "artist"=>Common::makeFriendlyUrl($video->artist_name)));
	                if(isset($this->artist)){
	                    $urlKey = ($this->artist->url_key) ? $this->artist->url_key : Common::makeFriendlyUrl(trim($this->artist->name));
	                    $linkArtist = Yii::app()->createUrl("artist/view", array("id" => $this->artist->id, "title" => $urlKey));
	                } else
	                    $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($video->artist_name)));

	                ?>
	                <li class="<?php if($i % 4 == 3) echo 'marr_0'; ?> <?php if($i % 4 == 0) echo 'clb'; ?>">
	                    <a href="<?php echo $link ?>" title="<?php echo CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name); ?>">
	                        <img src="<?php echo AvatarHelper::getAvatar("video", $video->id, 200) ?>" alt="<?php echo CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name); ?>" />
	                        <?php if(VideoModel::model()->isHD($video->profile_ids)):?>
							<span class="hd">HD</span>
							<?php endif;?>
	                    </a>
	                    <div class="info">
	                        <h3 class="video_name padt5">
	                            <a href="<?php echo $link ?>"
	                               title="<?php echo $video->name;?>"><?php echo $video->name; ?>
	                            </a>
	                        </h3>
	                        <h4 class="video_aritis fs11 padt2">
	                            <?php if($this->option == 'box'):?>
	                                <a href="<?php echo $linkArtist;?>" title="<?php echo $video->artist_name?>"><?php echo Formatter::substring($video->artist_name, " ", 8, 22); ?></a>
	                            <?php else:?>
	                                <a href="<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>$video->artist_name));?>" title="<?php echo $video->artist_name ?>">
									<?php echo Formatter::smartCut($video->artist_name, 22); ?></a>
	                            <?php endif;?>
	                        </h4>
	                    </div>
	                </li>
	                <?php $i++;
                endif;
            endforeach;
            ?>
        </ul>
    </div>
</div>
<?php endif; ?>