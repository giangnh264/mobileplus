<div class="header_box marb0">
    <h3 class="title"><?php echo Yii::t('web', 'Ca sĩ tương tự');?></h3>&nbsp;&nbsp;&nbsp;<a href="#" class="fs11"><?php echo Yii::t('web', 'More');?> <i class="icon icon_mt"></i></a>
</div>
<div class="content_box artist_more">
    <ul class="ovh">
        <?php
        $i = 0;
        foreach ($this->artists as $artist):
            $link = Yii::app()->createUrl("artists/view", array("id" => $artist->id, "title" => Common::makeFriendlyUrl($artist->url_key)));
            ?>
        <?php if ($i < $this->limit): ?>
                <li class="<?php echo ($i % 2 == 1) ? 'marr_0' : '';?>">
                    <a href="<?php echo $link;?>"><img style="width: 120px; height: 120px;" src="<?php echo AvatarHelper::getAvatar("artist", $artist->id, 200); ?>" alt="<?php echo Yii::t('web', 'Artist');?>" /></a>
                    <a href="<?php echo $link;?>"><?php echo CHtml::encode($artist->name) ?></a>
                </li>
        <?php endif; ?>
<?php $i++; endforeach; ?>
    </ul>
</div>
