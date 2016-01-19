<div class="box_title">
    <h2 class="name fs24"><?php echo Yii::t('web','Thế giới có gì'); ?></h2>
</div>
<div class="box_content">
    <ul class="bxh_album_list bxh_video_list">
        <?php
        $i = 0;
        if($data):
            foreach ($data as $video):
            $i++;
            if ($i<= $limit):
            $urlKey = ($video->url_key) ? $video->url_key : Common::makeFriendlyUrl(trim($video->name));
            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl(trim($video->artist_name))));
            if(isset($this->artist)){
                $urlKey = Common::makeFriendlyUrl(trim($video->artist_name));
                $linkArtist = Yii::app()->createUrl("artist/view", array("id" => $this->artist->id, "title" => $urlKey));
            } else
                $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($video->artist_name)));
            $thumb = AvatarHelper::getAvatar("video", $video->id, 's4');
            ?>
            <li>
                <a href="<?php echo $link;?>">
                    <img class="video_avatar" alt="<?php echo CHtml::encode($video->name);?>" src="<?php echo $thumb;?>">
                    <i class="alb_order"><?php echo $i;?></i>
                </a>
                <h3 class="over-text"><a href="<?php echo $link;?>" title="<?php echo CHtml::encode($video->name);?>"><?php echo CHtml::encode($video->name);?></a></h3>
                <p class="over-text"><a href="<?php echo $linkArtist;?>" title="<?php echo $video->artist_name;?>"><?php echo $video->artist_name;?></a></p>
            </li>
            <?php
            endif;
            endforeach;?>
        <?php else:?>
            <p><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif;?>
    </ul>
</div>
