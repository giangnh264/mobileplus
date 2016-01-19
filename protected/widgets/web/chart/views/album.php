<div class="box_title">
    <h2 class="name fs24"><?php echo Yii::t('web','Album chart'); ?> </h2>
</div>
<div class="box_content">
    <center>
        <ul class="btn_ty ajax_load">
            <li><a class="pre <?php if(strpos($code,'VN')!==false) echo "active"?>" href="javascript:;" rel="VN"><?php echo Yii::t('web','Việt nam'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a class="next <?php if(strpos($code,'EUR')!==false) echo "active"?>" href="javascript:;" rel="EUR"><?php echo Yii::t('web','US-UK'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a class="next <?php if(strpos($code,'KOR')!==false) echo "active"?>" href="javascript:;" rel="KOR"><?php echo Yii::t('web','Korean'); ?></a></li>
        </ul>
    </center>
    <ul class="bxh_album_list">
        <?php if($data):?>
        <?php
        $i=1;
        foreach($data as $album):
            if ($i<= $limit):
            $i++;
            $urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl($album->name);
            $link = Yii::app()->createUrl("album/view",array("id"=>$album->id,'title'=>trim($urlKey,"-"), "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
            $avatar = AvatarHelper::getAvatar("album", $album->id, 150);
            $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($album->artist_name)));
        ?>
        <li>
            <a href="<?php echo $link;?>">
                <img class="thumb" src="<?php echo $avatar;?>" alt="Album"/>
                <i class="alb_order"><?php echo $i - 1;?></i>
            </a>
            <h3 class="over-text"><a href="<?php echo $link;?>" title="<?php echo CHtml::encode($album->name);?>"><?php echo CHtml::encode($album->name);?></a></h3>

            <p class="over-text">
                <?php
                $j=0;
                $artistList = explode(",", $album->artist_object);
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