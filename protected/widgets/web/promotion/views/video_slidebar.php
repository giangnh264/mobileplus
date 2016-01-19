<div class="box_title">
    <h2 class="name"><a href="<?php echo $this->link;?>"><?php echo $this->title;?></a></h2>
</div>
<div class="box_content">
    <ul class="list_video_promotion">
        <?php
        $i = 0;
        if($this->videoList):
        foreach ( $this->videoList as $video ) :
        $urlKey = Common::makeFriendlyUrl ( trim ( $video->name ) );
        $link = Yii::app ()->createUrl ( "video/view", array (
            "id" => $video->id,
            "title" => $urlKey,
            "artist"=>Common::makeFriendlyUrl($video->artist_name)
        ) );
        $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($video->artist_name)));
        $titleLink = $altImg = CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name);
        ?>
        <li class="<?php if($i%5 == 4) echo 'marr_0'; else echo '';?>">
            <a href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("video", $video->id,200)?>" alt="<?php echo $altImg; ?>"/></a>
            <a title="<?php echo CHtml::encode($video->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
            <div class="info">
                <h3 class="name over-text"><a title="<?php echo $titleLink;?>" href="<?php echo $link ?>"><?php echo CHtml::encode($video->name); ?></a></h3>
                <p class="singer over-text">
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
            </div>
        </li>
        <?php
            $i++;
        endforeach;?>
        <?php else:?>
            <p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif;?>
    </ul>
</div>