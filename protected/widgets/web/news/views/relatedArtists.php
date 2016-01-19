<div class="box_title clb">
    <h2 class="name font20"><?php echo $pageTitle; ?></h2>
</div>
<?php if(isset($artists) && count($artists) > 0):?>
<div class="box_content">
    <ul class="list_artist">
        <?php for ($i = 0; $i < count($artists); $i++):
            $artist = $artists[$i];
            if ($artist->id != $exclusion) :
                $link = Yii::app()->createUrl("artist/view", array("id" => $artist->id));
        ?>
            <li class="<?php if($i%2 == 1) echo 'marr_0'; else echo '';?>">
                <a href="<?php echo $link;?>">
                    <img style="width: 140px; height: 140px;" src="<?php echo AvatarHelper::getAvatar("artist", $artist->id, 140); ?>" alt="<?php echo $artist->name;?>" />
                </a>
                <div class="info_artist">
                    <h3><a href="<?php echo $link;?>" title="<?php echo $artist->name;?>"><?php echo Formatter::substring($artist->name, " ", 4, 16);?></a></h3>
                </div>
            </li>
        <?php
            endif;
            endfor;
        ?>
    </ul>
</div>
<?php else:?>
<p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
<?php endif;?>
