<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl . "/touch/css/promotion.css");
$class = 'about';
?>

<?php include_once '_promotion.php'; ?>
<div class="promotion_content">
    <div class="about_title">
        <i class="icon_music"></i>
        <span>Nghe nhạc hay -  Trúng ngay Honda Lead</span>
    </div>
    <div class="about_content">
        <?php echo $content; ?>
    </div>
</div>
