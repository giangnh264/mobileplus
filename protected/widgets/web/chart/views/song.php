<div class="box_title">
    <h2 class="name fs24"><?php echo Yii::t('web','Song chart'); ?></h2>
</div>
<div class="box_content">
    <center>
        <ul class="btn_ty ajax_load">
            <li><a class="pre <?php if(strpos($code,'VN')!==false) echo "active"?>" href="javascript:;" rel="VN"><?php echo Yii::t('web','Việt Nam'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a class="next <?php if(strpos($code,'EUR')!==false) echo "active"?>" href="javascript:;" rel="EUR"><?php echo Yii::t('web','US-UK'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a class="next <?php if(strpos($code,'KOR')!==false) echo "active"?>" href="javascript:;" rel="KOR"><?php echo Yii::t('web','Korean'); ?></a></li>
        </ul>
        <p class="playApp"><a style="margin-top: 0px; margin-left: 115px;" class="btn_playall" href="<?php echo Yii::app()->createUrl("collection/view",array("id"=>$collection->id,"title"=>Common::makeFriendlyUrl(CHtml::encode($collection->name)))); ?>"><i class="icon icon_All"></i><?php echo Yii::t('web', 'Play All')?></a></p>
    </center>
    <ul class="bxh_song_list">
        <?php if($data):?>
        <?php
            $i=0;
            foreach($data as $song):
                $i++;
                $songName = CHtml::encode($song->name);
                $artistName = CHtml::encode($song->artist_name);
                $urlKey = Common::makeFriendlyUrl($song->name);
                $link = Yii::app()->createUrl("song/view",array("id"=>$song->id,"title"=>$urlKey, 'artist'=>Common::makeFriendlyUrl($song->artist_name)));
                //$artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->artist_name)));
        ?>
        <li>
            <span class="number <?php echo str_replace(array(1,2,3),array('one','tow','three'), $i)?>"><?php echo $i<10?'0'.$i:$i;?></span>
            <i class="icon icon_s"></i>
            <h3 class="over-text"><a href="<?php echo $link;?>" title="<?php echo $songName;?>"><?php echo $songName;?></a></h3>
            <p class="over-text">
                <?php
                $j=0;
                $artistList = explode(",", $song->artist_object);
                foreach ($artistList as $item):
                    $artists = explode("|", $item);
                    $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
                    $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
                ?>
                <a href="<?php echo $artistLink;?>" title="<?php echo $artistName;?>"><?php echo $artistName;?>
                </a>
                    <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                    <?php $j++;?>
                <?php endforeach;?>
            </p>
        </li>
        <?php endforeach;?>
            <?php else:?>
            <p><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif;?>
    </ul>
</div>