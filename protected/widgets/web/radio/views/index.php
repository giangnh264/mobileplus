<div class="box_title">
    <h2 class="name fs24 "><?php echo Yii::t('web', 'Radio'); ?></h2>
</div>
<?php $time_full = Common::getTime();
?>
<div class="box_content">
    <p class="radio_info"><?php echo Yii::t('web', 'Bây giờ là {timePoint} {dayOfWeek}, mời các bạn nghe nhạc', array('{timePoint}'=>$time_full['timePoint'], '{dayOfWeek}'=>$time_full['dayOfWeek'])); ?></p>
    <ul class="radio_list">
        <?php
        $i=0;
        foreach ($radios as $value){
        $avatarUrl = RadioModel::model()->getAvatarUrl($value->id,'s3');
        $link = Yii::app()->createUrl('/horoscopes/view', array('id'=>$value->id, 'title'=>Common::url_friendly($value->name)));
        ?>
        <li <?php echo ($i%2==1) ? 'style="margin-left: 20px;"' : ''; ?>>
            <a href="<?php echo $link; ?>"><img src="<?php echo $avatarUrl; ?><?php // echo images/radio1.png; ?>" alt="radio"/></a>
            <p class="over-text"><a href="<?php echo $link; ?>" title="<?php echo CHtml::encode($value->name);?>"><?php echo CHtml::encode($value->name);?></a></p>
        </li>
        <?php $i++; }?>
    </ul>
</div>