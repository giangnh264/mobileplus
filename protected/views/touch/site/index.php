<div class="home_slide" style="margin-bottom: 10px;" >
    <?php
    $newsEvent = NewsEventModel::model()->getEventByChannel('web');
    $data = array();
    $i = 0;
    foreach ($newsEvent as $value) {
        $data[$i]['avatar'] = AvatarHelper::getAvatar('newsEvent', $value->id, 's1');
        $data[$i]['link'] = NewsEventModel::model()->getEventLink($value);
        $data[$i]['title'] = $value->name;
        $data[$i]['desc'] = '';
        $i++;
    }
    $this->widget('application.widgets.touch.slideshow.SlideshowWidget', array('data' => $data));
    ?>
</div>

<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/videoplaylist') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Video Playlist"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Video Playlist"); ?></span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
        <?php if ($video_playlist) {
            $i = 0;
            ?>
            <?php foreach ($video_playlist as $value) { ?>
                    <?php if ($i % 2 == 0) { ?>
                    <div class="item_row"><?php } ?>
                    <?php
                    $videoPlaylistLink = yii::app()->createUrl('videoplaylist/view', array('id' => $value['id'], 'url_key' => Common::makeFriendlyUrl($value['name'])));
                    $avatarImage = WapVideoPlaylistModel::model()->getThumbnailUrl('s2', $value['id']);
                    ?>
                    <div class="item">
                        <a href="<?php echo $videoPlaylistLink; ?>">
                            <div class="wrr-item-detail">
                                <img src="<?php echo $avatarImage; ?>" />
                                <div class="info-nav">
                                    <p class="title subtext"><?php echo CHtml::encode($value['name']); ?></p>
                                    <p class="artist subtext"><?php echo CHtml::encode($value['artist_name']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                    <?php
                    if ($i % 2 == 0 && $i != 0) {?>
                        </div>
                     <?php } else {?>
                        <div class="space"></div>
                     <?php }
                    } 
                } ?>
</div>


<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/album') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Album"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Album"); ?></span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
        <?php if ($albums) {
            $i = 0;
            ?>
                <?php foreach ($albums as $value) { ?>
                    <?php if ($i % 2 == 0) { ?>
                    <div class="item_row"><?php } ?>
                    <?php
                    $albumLink = yii::app()->createUrl('album/view', array('id' => $value['id'], 'url_key' => Common::makeFriendlyUrl($value['name']),"artist"=>Common::makeFriendlyUrl(trim($value['artist_name']))));
                    $avatarImage = WapAlbumModel::model()->getThumbnailUrl('s2', $value['id']);
                    ?>
                    <div class="item">
                        <a href="<?php echo $albumLink; ?>">
                            <div class="wrr-item-detail">
                                <img src="<?php echo $avatarImage; ?>" />
                                <div class="info-nav">
                                    <p class="title subtext"><?php echo CHtml::encode($value['name']); ?></p>
                                    <p class="artist subtext"><?php echo CHtml::encode($value['artist_name']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                    <?php
                    if ($i % 2 == 0 && $i != 0) {
                        echo "</div>";
                    } else {
                        echo '<div class="space"></div>';
                    }
                    ?>
    <?php } ?>
<?php } ?>
        </div>
    </div>
</div>
<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/video') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Video"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Video"); ?></span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
        <?php if ($videos) {
            $i = 0;
            ?>
            <?php foreach ($videos as $value) { ?>
                <?php if ($i % 2 == 0) { ?><div class="item_row"><?php } ?>
                <?php
                $videoLink = Yii::app()->createUrl('video/view', array('id' => $value['id'], 'url_key' => Common::makeFriendlyUrl($value['name']),"artist"=>Common::makeFriendlyUrl(trim($value['artist_name']))));
                $avatarImage = WapVideoModel::model()->getThumbnailUrl('s1', $value['id'])
                ?>
                    <div class="item">
                        <a href="<?php echo $videoLink; ?>">
                            <div class="wrr-item-detail">
                                <img src="<?php echo $avatarImage; ?>" />
                                <div class="info-nav">
                                    <p class="title subtext"><?php echo CHtml::encode($value['name']); ?></p>
                                    <p class="artist subtext"><?php echo CHtml::encode($value['artist_name']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; ?>
                    <?php
                    if ($i % 2 == 0 && $i != 0) {
                        echo "</div>";
                    } else {
                        echo '<div class="space"></div>';
                    }
                    ?>
    <?php } ?>
<?php } ?>
        </div>
    </div>
    <div class="item-box">
        <a href='<?php echo Yii::app()->createUrl('/song') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Song"); ?>'>
            <div class='head-label clearfix'>
                <span class='text'><?php echo Yii::t("wap", "Song hot"); ?></span>
                <span class='title'></span>
            </div><!-- End .head-label -->
        </a>
        <div class="item-content">
            <?php
            $this->widget('application.widgets.touch.song.SongList', array(
                'songs' => $songs,
            ));
            ?>
        </div>
    </div>
    <div style="clear: both"></div>
    <?php if(false): ?>
    <div class="item-box">
        <a href='<?php echo Yii::app()->createUrl('/news') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "News"); ?>'>
            <div class='head-label clearfix'>
                <span class='text'><?php echo Yii::t("wap", "News"); ?></span>
                <span class='title'></span>
            </div><!-- End .head-label -->
        </a>
        <div class="item-content">
            <div style="padding: 5px;">
                <?php
                $link = Yii::app()->createUrl('news/detail', array('id' => $news[0]->id, 'url_key' => Common::makeFriendlyUrl($news[0]->title)));
                $avatarImage = WapNewsModel::model()->getThumbnailUrl('s3', $news[0]->id);
                if ("/images/no-image.jpg" == $avatarImage) {
                    $avatarImage = Yii::app()->homeUrl . $avatarImage;
                }
                ?>
                <div class="item_row item_lead">
                    <div class="item marr_5">
                        <a href="<?php echo $link; ?>"><img src="<?php echo $avatarImage; ?>"/></a>
                    </div>
                    <div>
                            <a href="<?php echo $link; ?>">
                                <h4 class="title" style="font-weight: bold"><?php echo CHtml::encode(Formatter::smartCut($news[0]->title,50)); ?></h4>
                                <p class="time-news">(<?php echo date('d/m H:i', strtotime($news[0]->created_time)); ?>)</p>
                            </a>
                    </div>
                    <div class="intro"><?php echo CHtml::encode(Formatter::smartCut($news[0]->intro,110)); ?></div>
                </div>
                <?php
                for ($i = 1; $i < count($news); $i++) {
                    $item = $news[$i];
                    $link = Yii::app()->createUrl('news/detail', array('id' => $item->id, 'url_key' => Common::makeFriendlyUrl($item->title)));
                    ?>
                    <div class="item_row news_row <?php if ($i == count($news) - 1) echo 'last_item'; ?>">
                        <a href="<?php echo $link; ?>" title=" <?php echo CHtml::encode($item->title) ?>">
                            <h4 class="title"><?php echo CHtml::encode($item->title); ?></h4>
                            <p class="time-news subtext">(<?php echo date('d/m H:i', strtotime($item->created_time)); ?>)</p>
                        </a>
                    </div>
    <?php
}
?>
            </div>
        </div>
    </div>
    <div style="clear: both"></div>
    <?php endif;?>
    <div class="item-box">
        <a class="wrap-head mr-t-15" title="Âm nhạc 12 cá tính" href="<?php echo Yii::app()->createUrl('/horoscopes/index')?>">
        <div class="head-label clearfix">
            <span class="text">Âm nhạc 12 cá tính</span>
            <span class="title"></span>
        </div>
        </a>
        <div class="item-content">
            <div style="overflow: hidden; padding-left: 5px;">
                <a href="<?php echo Yii::app()->createUrl('/horoscopes/index')?>">
                    <img width="75" src="/touch/images/horocopes.png" style="float: left; margin-right: 5px;border-radius: 4px;" />
                    <p class="title" style="color: #006CB8; font-size: 14px;"><?php echo Yii::app()->params['horoscope']['title']?></p>
                    <p style="color: #777"><?php echo Yii::app()->params['horoscope']['intro']?></p>
                </a>
            </div>
        </div>
    </div>