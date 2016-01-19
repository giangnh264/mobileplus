<?php 
    $link = ($collection) ? Yii::app()->createUrl("videoplaylist/view",array("code"=>$collection->code)): '';
?>

<div class="box_title">
    <h2 class="name"><a href="<?php echo $link;?>"><?php echo Yii::t('web','Thế giới có gì?'); ?></a></h2>
</div>
<div class="box_content">
    <ul class="bxh_album_list">
        <?php
        $max = min(count($videos), $limit);
        for ($i = 0; $i < $max; $i++):
            $video = $videos[$i];
            $urlKey = isset($video->url_key) ? $video->url_key : Common::makeFriendlyUrl(trim($video->name));
            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl($video->artist_name)));
            $thumb = AvatarHelper::getAvatar("video", $video->id, 90);
            $altImg = CHtml::encode($video->name);
            $title = CHtml::encode($video->name);
            $artistName = CHtml::encode($video->artist_name);
            $artistLink = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($video->artist_name)));
        ?>
        <li>
            <a href="<?php echo $link;?>">
                <img class="video_avatar" src="<?php echo $thumb;?>" alt="<?php echo $altImg;?>"/>
            </a>
            <h3 class="over-text"><a href="<?php echo $link;?>"><?php echo $title;?></a></h3>
            <p class="over-text"><a href="<?php echo $artistLink;?>"><?php echo $artistName;?></a></p>
        </li>
        <?php endfor; ?>
    </ul>
</div>