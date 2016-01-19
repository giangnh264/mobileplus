<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/touch/css/promotion.css" );
?>
<?php include_once '_promotion.php';?>

<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/song') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Song"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Bài hát"); ?></span>
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
<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/song') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Video"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Video"); ?></span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
<?php
    $this->widget ( 'application.widgets.touch.video.VideoList', array (
        'videos' => $videos
    ) );
?>
</div>
<div class="item-box">
    <a href='<?php echo Yii::app()->createUrl('/song') ?>' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Album"); ?>'>
        <div class='head-label clearfix'>
            <span class='text'><?php echo Yii::t("wap", "Album"); ?></span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
<?php
$this->widget('application.widgets.touch.album.AlbumListWidget',array('albums'=>$albums));
?>
    </div>