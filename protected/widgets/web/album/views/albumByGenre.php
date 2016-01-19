<?php 
    $link = '#';
    if(isset($boxObj)){
        $urlKey = ($boxObj->url_key)?$boxObj->url_key:Common::makeFriendlyUrl(trim($boxObj->name));
        $link = Yii::app()->createUrl("album/index",array("id"=>$boxObj->id,"title"=>$urlKey));
    }
?>

<div class="box_title pt20">
    <h2 class="name" title='<?php echo Yii::t('web', 'Album').$boxObj->name;?>'><?php echo Yii::t('web', 'Album'); ?> <?php echo Formatter::substring($boxObj->name, " ", 10, 40);?></h2>&nbsp;&nbsp;
        <?php /* <a href="<?php echo $link; ?>" class="fs11">Xem thêm <i class="icon icon_mt"></i></a> */ ?>
</div>
<div class="box_content">
    <ul class="list_artist">
        <?php
        $max = min(count($albums), $limit);
        for ($i = 0; $i < $max; $i++):
            $album = $albums[$i];
            $urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl(trim($album->name));
            $link = Yii::app()->createUrl("album/view", array("id" => $album->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
            $linkArtist = Yii::app()->createUrl("artist/view", array("id" => $album->artist_id, 'title'=>Common::makeFriendlyUrl(trim($album->artist_name))));
            ?>
            <li class="<?php if($i%2 == 1) echo 'marr_0'; else echo '';?>">
                <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>"><img src="<?php echo AvatarHelper::getAvatar("album", $album->id, 200); ?>" alt="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>" /></a>
                <div class="info_artist">
                    <h3 class="name over-text"><a href="<?php echo $link;?>" title="<?php echo $album->name;?>"><?php echo CHtml::encode($album->name);?></a></h3>
                </div>
                <a title="<?php echo CHtml::encode($album->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
            </li>
        <?php endfor; ?>
    </ul>
</div>
