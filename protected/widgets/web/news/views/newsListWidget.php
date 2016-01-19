
    <div class="box_title">
        <h2 class="name"><?php echo $title;?></h2>
    </div>
    <div class="box_content">
        <?php if ($news): ?>
        <ul class="list_news page_news">
            <?php foreach ($news as $new):
                $thumb = AvatarHelper::getAvatar("news", $new->id,"235");
                $link = Yii::app()->createUrl("news/view",array("id"=>$new->id,"title"=>Common::makeFriendlyUrl($new->title)));
                $title = CHtml::encode($new->title);
            ?>
            <li>
                <a class="news-thub-large" href="<?php echo $link ?>"><img alt="<?php echo $new->title ?>" src="<?php echo $thumb;?>"></a>
                <p class="date_post"><?php echo Formatter::formatDayOfWeek($new->created_time); ?></p>
                <h3><a class="news_title" href="<?php echo $link ?>"><?php echo $new->title?></a></h3>
                <p><?php echo Formatter::substring(htmlspecialchars($new->intro)," ", 20, 100);?></p>
                <a href="<?php echo $link ?>" class="view_more"><?php echo Yii::t("web", "Xem thêm"); ?></a>
            </li>
            <?php endforeach;?>
        </ul>
        <?php else:?>
            <p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
        <?php endif; ?>
    </div>
