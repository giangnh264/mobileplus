<ul class="bxh_album_list song_detail_list">
    <?php foreach ($songs as $song):
        $urlKey = !empty($song->url_key)?trim($song->url_key):Common::makeFriendlyUrl(trim($song->name));
        $artist_name = Common::makeFriendlyUrl($song->artist_name);
        $link = Yii::app()->createUrl("song/view",array("id"=>$song->id,"title"=>$urlKey, 'artist'=>$artist_name));
        $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->song_artist[0]->artist_name)));
        $artistId = $song->song_artist[0]->artist_id;
        $image = AvatarHelper::getAvatar("artist", $artistId,640);
        ?>
        <li>
            <a href="<?php echo $link ?>">
                <img src="<?php echo $image;?>" alt="<?php echo CHtml::encode($song->song_artist[0]->artist_name);?>">
            </a>
            <h3><a title="<?php echo CHtml::encode($song->name);?>" href="<?php echo $link;?>"><?php echo Formatter::smartCut(CHtml::encode($song->name),30);?></a></h3>
            <p>
        <?php
        //artist link new
        $j=0;
        $artistList = explode(",", $song->artist_object);
        foreach ($artistList as $item):
            $artists = explode("|", $item);
            $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
            $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
            //end artist link new
            ?>
                <a title="<?php echo CHtml::encode($artists[1]);?>" href="<?php echo $artistLink;?>"><?php echo Formatter::smartCut($artists[1], 20) ?>
                </a>
            <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
            <?php $j++;?>
        <?php endforeach;?>
            </p>
        </li>
    <?php endforeach;?>
</ul>