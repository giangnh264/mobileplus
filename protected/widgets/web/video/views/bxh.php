<?php if(count($this->videos) > 0):?>	
    <div class="content_box">
        <ul class="chart_mv">
            <?php
            $i = 0;
            foreach ($this->videos as $video):
                $urlKey = ($video->url_key) ? $video->url_key : Common::makeFriendlyUrl(trim($video->name));
                $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl($video->artist_name)));
                ?>
                <li class="<?php echo ($i % 3 == 2) ? 'marr_0' : '';?>">
					<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name); ?>">
						<img src="<?php echo AvatarHelper::getAvatar("video", $video->id, 225) ?>" alt="<?php echo CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name); ?>" />
					</a>
					<h3 class="padt10"> 
						<a href="<?php echo $link ?>" title="<?php echo $video->name;?>">
                           	<b><?php echo Formatter::substring($video->name, " ", 8, 25); ?></b>
                        </a>
                    </h3>
                    
					<h4 class="padt2">
						<a href="<?php echo Yii::app()->createUrl('/search/index', array('q' => $video->video_artist[0]->artist_name)); ?>" title="<?php echo $video->video_artist[0]->artist_name;?>">
							<span class="gray_color"><?php echo Formatter::substring($video->video_artist[0]->artist_name, " ", 8, 25); ?></span>
						</a>
					</h4>
					<div class="alb_order <?php echo ($i < 3) ? 'top3' : 'top4'; ?>">
						<p><?php echo $i+1; ?></p>
						<a href="<?php echo $link ?>"><i class="icon icon_playmv"></i></a>
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