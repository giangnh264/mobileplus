<div class="box_title">
    <a href="<?php echo Yii::app()->createUrl('/horoscopes/index');?>">
        <h2 class="name" title=''><?php echo Yii::t('web', 'Âm nhạc 12 cá tính'); ?></h2>&nbsp;&nbsp;
    </a>
</div>

<div class="box_content">
    <ul class="radio_list">
        <?php
        $i=0;
        foreach ($radioList as $value ):
            $avatarUrl = RadioModel::model()->getAvatarUrl($value->id,640);
            $link = Yii::app()->createUrl('/horoscopes/view', array('id'=>$value->id,'title'=>Common::url_friendly(CHtml::encode($value->name))));
            ?>
            <li <?php echo ($i%2 == 1) ? 'style="margin-left: 20px;"' : ''; ?>>
                <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($value->name); ?>">
                    <img src="<?php echo $avatarUrl; ?>" alt="<?php echo CHtml::encode($value->name); ?>" /></a>
                <p class="over-text"><a href="<?php echo $link; ?>" title="<?php echo CHtml::encode($value->name);?>"><?php echo CHtml::encode($value->name);?></a></p>
            </li>
            <?php
            $i++;
        endforeach; ?>
    </ul>
</div>
