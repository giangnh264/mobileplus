<?php
$link = '#';
if(isset($boxObj)){
    $urlKey = isset($boxObj->url_key) ? $boxObj->url_key : Common::makeFriendlyUrl(trim($boxObj->name));
    $link = URLHelper::makeUrlGenre(array("type"=>'video','name'=>$boxObj->name,'id'=>$boxObj->id));
}
?>
<div class="box_title">
    <h2 class="name fs24"><a title="Video <?php echo $boxObj->name;?>" href="<?php echo $link;?>"><?php echo Yii::t("web", "Video"); ?> <?php echo Formatter::substring($boxObj->name, " ", 5, 15);?></a></h2>
</div>
<div class="box_content">
    <ul class="bxh_album_list video_list">
        <?php
        $max = min(count($videos), $limit);
        for ($i = 0; $i < $max; $i++):
            $video = $videos[$i];
            $artistName = $video->artist_name;
            $link = Yii::app()->createUrl("video/view", array("id" => $video->id, "title" => Common::makeFriendlyUrl(trim($video->name)),'artist'=>Common::makeFriendlyUrl(trim($artistName))));
            $avatar = AvatarHelper::getAvatar("video", $video->id, 100);
            $titleLink = $imgAlt = CHtml::encode($video->name) . ' - ' . CHtml::encode($artistName);
            $artistLink = $artistLink = Yii::app()->createUrl("/search") . "?" . http_build_query(array("q" => CHtml::encode($artistName)));
            ?>
            <li>
                <a title="<?php echo $titleLink;?>" href="<?php echo $link;?>">
                    <img class="video_avatar" alt="<?php echo $imgAlt;?>" src="<?php echo $avatar;?>">
                </a>
                <h3 class="over-text"><a href="<?php echo $link;?>"><?php echo CHtml::encode($video->name);?></a></h3>
                <p><a href="<?php echo $artistLink;?>"><?php echo CHtml::encode($artistName);?></a></p>
            </li>
        <?php endfor; ?>
    </ul>
</div>