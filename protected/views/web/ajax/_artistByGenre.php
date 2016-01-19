<div class="box_title">
<h2 class="name"><?php echo Yii::t('web', 'The same artist'); ?></h2>
</div>
<?php /* ?>&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app ()->createUrl ( "/artist/index", array ("id" => $artistDetail->genre_id, "exclusion" => $artistDetail->id));?>" class="fs11">Xem thêm <i class="icon icon_mt"></i></a> <?php */ ?>

<div class="content_box" >
    <ul class="radio_list">
        <?php for ($i = 0; $i < count($artists); $i++):
            $artist = $artists[$i];
            if ($artist->id != $exclusion) :
                $link = Yii::app()->createUrl("artist/view", array("id" => $artist->id));
                ?>
                <li class="<?php if($i%2 == 1) echo 'marr_0'; else echo '';?>">
                    <a href="<?php echo $link;?>">
                        <img style="width: 120px;" src="<?php echo AvatarHelper::getAvatar("artist", $artist->id, 120); ?>" alt="<?php echo $artist->name;?>" />
                    </a>
                    <p><a href="<?php echo $link;?>" title="<?php echo $artist->name;?>"><?php echo Formatter::substring(CHtml::encode($artist->name), " ", 3, 12);?></a></p>
                </li>
            <?php
            endif;
        endfor;
        ?>
    </ul>
</div>