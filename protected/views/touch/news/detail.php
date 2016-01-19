<?php if ($from != 'api'): ?>
    <div class="collapse-10">
        <div class='list-label mr-t-15 clearfix'>
            <a href='<?php echo Yii::app()->createUrl('/news'); ?>'
               class='head left'><?php echo Yii::t("wap", "News"); ?></a>
        </div>
    </div>
    <div class="news_info">
        <h3><?php echo CHtml::encode($news->title) ?></h3>

        <p><?php echo CHtml::encode($news->intro) ?></p>
    </div>
    <div class="news_content">
        <?php echo $news->content ?>
    </div>
<?php else: ?>
    <!DOCTYPE HTML PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.2//EN' 'http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml'>
			<head>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
			<style type="text/css">
            img {width: 100% !important}
            </style>
			</head>
			<body>
			<div id='adm_zone7300' style='clear: both;text-align: justify;'>
			 <div class="news_info">
                <h3><?php echo CHtml::encode($news->title) ?></h3>

                <p><?php echo CHtml::encode($news->intro) ?></p>
             </div>
                <div class="news_content">
                <?php echo $news->content ?>
            </div>
			</div>
			<body>
			</html>
<?php endif?>

