<div class="header_box marb0">
    <h2 class="title"><?php echo Yii::t('web','New'); ?></h2>&nbsp;&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("news");?>" class="fs11"><?php echo Yii::t('web','More'); ?>&nbsp;<i class="icon icon_mt"></i></a>
</div>
<div class="content_box artist_news">
    <ul class="ovh">
        <?php $i = 0; foreach($this->news as $new): 
                $link = Yii::app()->createUrl("news/view",array("id"=>$new->id,"title"=>Common::makeFriendlyUrl($new->title)));
        ?>
            <?php if($i < $this->limit):?>
            <li>
                <i class="icon icon_news"></i>
                <h3><a href="<?php echo $link ?>" class="news_title"><?php echo CHtml::encode($new->title) ?></a></h3>
                <p class="fs11"><?php echo date("d/m/Y H:i", strtotime($new->created_time)); ?></p>
            </li>  
            <?php endif;?>
        <?php $i++; endforeach; ?>
    </ul>
</div>
