<?php if(count($this->albums) > 0):?>
    <div class="content_box">
        <ul class="chart_album">
            <?php
            $i = 1;
            foreach ($this->albums as $album):
                $urlKey = isset($album->url_key) ? $album->url_key : Common::makeFriendlyUrl(trim($album->name));
                $link = Yii::app()->createUrl("album/view", array("id" => $album->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
                ?>
				<li class="<?php echo ($i>0 &&  ($i % 4 == 0)) ? 'marr_0' : '';?>">
					<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>">
						<img src="<?php echo AvatarHelper::getAvatar("album", $album->id, 200) ?>" alt="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>" />
					</a>
					<h3 class="padt10 over-text">
						<a href="<?php echo $link ?>" title="<?php echo $album->name;?>">
							<?php echo CHtml::encode($album->name); ?>
                        </a>
					</h3>
					
					<h4 class="padt2 over-text">
						<a href="<?php echo Yii::app()->createUrl('/search/index', array('q' => $album->artist_name)); ?>" title="<?php echo $video->video_artist[0]->artist_name;?>">
							<span class="gray_color"><?php echo CHtml::encode($album->artist_name); ?></span>
						</a>
					</h4>
					<div class="alb_order <?php echo ($i < 4) ? 'top3' : 'top4'; ?> ">
						<p><?php echo $i; ?></p>
						<a href="<?php echo $link ?>"><i class="icon icon_playalb"></i></a>
					</div>
				</li>
                <?php $i++;
            endforeach;
            ?>
        </ul>
    </div>
<?php else: ?>
	<p><?php echo Yii::t('web','Not found anything!');?></p>
<?php endif; ?>
