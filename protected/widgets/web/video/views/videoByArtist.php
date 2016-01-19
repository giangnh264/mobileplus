<?php
    $link = '#';
    if(isset($boxObj)){
        $urlKey = isset($boxObj->url_key) ? $boxObj->url_key : Common::makeFriendlyUrl(trim($boxObj->name));
        //$link = Yii::app()->createUrl("video/byartist", array("id" => $boxObj->id, "title" => $urlKey));

        $link = Yii::app()->createUrl("artist/view",array("id" => $boxObj->id,
					        								"title" => $urlKey,
					        								'tab'=>'mv'));

    }
?>
<div class="box_title">
    <h2 class="name fs24"><a title="Video <?php echo $artistName;?>" href="<?php echo $linkArtist;?>"><?php echo Yii::t("web", "Video"); ?> <?php echo Formatter::substring($artistName, " ", 5, 9);?></a></h2>
</div>
<div class="box_content">
    <ul class="bxh_album_list">
        <?php
        $max = min(count($videos), $limit);
        for ($i = 0; $i < $max; $i++):
            $video = $videos[$i];
            $artistName = $video->artist_name;
            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => Common::makeFriendlyUrl(trim($video->name)), "artist"=>Common::makeFriendlyUrl(trim($video->artist_name))));
            $avatar = AvatarHelper::getAvatar("video", $video->id, 100);
            $titleLink = $imgAlt = CHtml::encode($video->name) . ' - ' . CHtml::encode($artistName);
            $artistLink = $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($artistName)));
        ?>
        <li>
            <a title="<?php echo $titleLink;?>" href="<?php echo $link;?>">
                <img alt="<?php echo $imgAlt;?>" src="<?php echo $avatar;?>">
            </a>
            <h3 class="over-text"><a href="<?php echo $link;?>"><?php echo CHtml::encode($video->name);?></a></h3>
            <p><a href="<?php echo $artistLink;?>"><?php echo CHtml::encode($artistName);?></a></p>
        </li>
        <?php endfor; ?>
    </ul>
</div>