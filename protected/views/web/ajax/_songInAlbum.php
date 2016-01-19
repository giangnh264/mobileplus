<div class="album_song">
    <a href="<?php echo Yii::app()->createUrl("album/view", array("id" => $album->id, "title" => $album->url_key, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));?>">
        <img src="<?php echo AvatarHelper::getAvatar("album", $album->id, 200) ?>" alt="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>" />
        <div class="hover">
            <i class="icon_play"></i>
        </div>
    </a>

    <div class="album_song_info">
        <h3 class="name over-text"><a title="<?php echo CHtml::encode($album->name)?>" ><?php echo CHtml::encode($album->name)?></a></h3>
        <p class="singer over-text"><a title="<?php echo CHtml::encode($album->artist_name)?>" ><?php echo CHtml::encode($album->artist_name)?></a></p>
    </div>
</div>


<ul class="bxh_album_list song_detail_list mart20">
    <?php foreach ($songs as $song):
        $urlKey = Common::makeFriendlyUrl(trim($song->song->name));
        $artist_name = Common::makeFriendlyUrl($song->artist_name);
        $link = Yii::app()->createUrl("song/view",array("id"=>$song->song_id,"title"=>$urlKey, 'artist'=>$artist_name));
        $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($song->song->artist_name)));
        $artistId = SongArtistModel::model()->findByAttributes(array('song_id'=>$song->song->id))->artist_id;
        $image = AvatarHelper::getAvatar("artist", $artistId,640);
        ?>
        <li>
            <a href="<?php echo $link ?>">
                <img src="<?php echo $image;?>" alt="<?php echo CHtml::encode($song->song->artist_name);?>">
            </a>
            <h3><a title="<?php echo CHtml::encode($song->song->name);?>" href="<?php echo $link;?>"><?php echo Formatter::smartCut(CHtml::encode($song->song->name),30);?></a></h3>
            <p><a title="<?php echo CHtml::encode($song->song->artist_name);?>" href="<?php echo $artistLink;?>"><?php echo Formatter::smartCut($song->song->artist_name, 20) ?></a></p>
        </li>
    <?php endforeach;?>
</ul>