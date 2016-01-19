<?php if($albums) : ?>
<div class="box_title">
    <h2 class="name" title="<?php echo 'Album '.$artistName;?>"><?php echo Yii::t('web', 'Album');?> <?php echo Formatter::substring($artistName, " ", 10, 40);?></h2>&nbsp;&nbsp;
</div>
<div class="box_content">
    <ul class="list_artist">
        <?php
        $max = min(count($albums), $limit);
        for ($i = 0; $i < $max; $i++):
            $album = $albums[$i];
            $urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl(trim($album->name));
            $link = Yii::app()->createUrl("album/view",array("id"=>$album->id,"title"=>$urlKey, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
            ?>
            <li <?php echo ($i%2 == 1) ? 'class="marr_0"' : ''; ?>>
                <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($album->name).' - ' . $artistName; ?>">
                    <img src="<?php echo AvatarHelper::getAvatar("album", $album->id, 200); ?>" alt="<?php echo CHtml::encode($album->name).' - '.$artistName; ?>" />
                </a>
                <div class="info_artist">
                    <h3 class="name"><a href="<?php echo $link;?>" title="<?php echo $album->name;?>"><?php echo Formatter::substring($album->name, " ", 4, 16);?></a></h3>
                    <?php /*<p class="singer"><?php echo date_format(new DateTime($album->created_time),'Y');?></p> */ ?>
                </div>
            </li>
        <?php endfor; ?>
    </ul>
</div>
<?php endif; ?>