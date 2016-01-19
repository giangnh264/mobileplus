<div class="box_title">
    <h2 class="name"><?php echo $this->title;?></h2>
    <div class="flr">
        <ul class="btn_ty">
            <li><a href="javascript:void(0)" class="pre load_video_new<?php echo ($this->district)?'_'.$this->district:'';?> <?php echo (strtoupper($this->type)=="NEW")?" active":""?>"><?php echo Yii::t('web','New');?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a href="javascript:void(0)" class="next load_video_hot<?php echo ($this->district)?'_'.$this->district:'';?> <?php echo (strtoupper($this->type)=="HOT")?" active":""?>"><?php echo Yii::t('web','Hot');?></a></li>
        </ul>
    </div>
</div>
<div class="box_content">
    <ul class="list_video">
        <?php
        $i = 0;
        if($videoList):
            foreach ( $videoList as $video ) :
                $urlKey = ($video->url_key) ? $video->url_key : Common::makeFriendlyUrl ( trim ( $video->name ) );
                $link = Yii::app ()->createUrl ( "video/view", array (
                    "id" => $video->id,
                    "title" => $urlKey,
                    'artist'=>Common::makeFriendlyUrl($video->artist_name)
                ) );
                $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($video->artist_name)));
                $titleLink = $altImg = CHtml::encode($video->name) . ' - ' . CHtml::encode($video->artist_name);
                ?>
                <li  class="<?php if($i%4 == 3) echo 'marr_0'; else echo '';?>">
                    <a href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("video", $video->id,200)?>" alt="<?php echo $altImg; ?>"/></a>
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
                                ?>
                                    <a href="<?php echo $artistLink;?>"><?php echo CHtml::encode( $artists[1]); ?></a>
                                <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                                <?php $j++;?>
                            <?php endforeach;?>
                        </p>

                    </div>
                    <a title="<?php echo CHtml::encode($video->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>

                </li>
            <?php
            $i++;
            endforeach;?>
        <?php else:?>
            <p><?php echo Yii::t('web','Not found anything'); ?></p>
        <?php endif;?>
    </ul>
</div>