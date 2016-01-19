<div class="box_title">
    <h2 class="name fs24"><?php echo Yii::t('web','Video chart'); ?></h2>
</div>
<div class="box_content">
    <center>
        <ul class="btn_ty ajax_load">
            <li><a href="javascript:;" class="pre <?php if(strpos($code,'VN')!==false) echo "active"?>" rel="VN"><?php echo Yii::t('web','Việt Nam'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a href="javascript:;" class="next <?php if(strpos($code,'CHAUMY')!==false) echo "active"?>" rel="EUR"><?php echo Yii::t('web','US-UK'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a href="javascript:;" class="next <?php if(strpos($code,'KOR')!==false) echo "active"?>" rel="KOR"><?php echo Yii::t('web','Korean'); ?></a></li>
        </ul>
    </center>
    <ul class="bxh_album_list bxh_video_list">
        <?php
        $i = 0;
        if($data):
            foreach ($data as $video):
            $i++;
            if ($i<= $limit):
            $urlKey = ($video->url_key) ? $video->url_key : Common::makeFriendlyUrl(trim($video->name));
            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl($video->artist_name)));
            if(isset($this->artist)){
                $urlKey = Common::makeFriendlyUrl(trim($video->artist_name));
            } else
            $thumb = AvatarHelper::getAvatar("video", $video->id, 's4');
            ?>
            <li>
                <a href="<?php echo $link;?>">
                    <img class="video_avatar" alt="<?php echo CHtml::encode($video->name);?>" src="<?php echo $thumb;?>">
                    <i class="alb_order"><?php echo $i;?></i>
                </a>
                <h3 class="over-text"><a href="<?php echo $link;?>" title="<?php echo CHtml::encode($video->name);?>"><?php echo CHtml::encode($video->name);?></a></h3>
                <p class="over-text">
                    <?php
                    $j=0;
                    $artistList = explode(",", $video->artist_object);
                    foreach ($artistList as $item):
                        $artists = explode("|", $item);
                        $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
                        $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
                        $artistName =trim($artists[1]);
                        ?>
                        <a href="<?php echo $artistLink;?>" title="<?php echo $artistName;?>"><?php echo $artistName;?>
                        </a>
                        <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                        <?php $j++;?>
                    <?php endforeach;?>
                </p>
            </li>
            <?php
            endif;
            endforeach;?>
        <?php else:?>
            <p><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif;?>
    </ul>
</div>
