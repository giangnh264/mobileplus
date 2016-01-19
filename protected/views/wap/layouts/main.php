<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/wap/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/wap/css/normal_phone.css" />
        <link rel="icon" type="image/png" href="<?php echo Yii::app()->request->getHostInfo(). '/img/fav.png';?>">
        <?php /*
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-27953546-23', 'auto');
            ga('send', 'pageview');

        </script>
        */?>
        
        <?php include('meta_tag.php'); ?>
        <?php
        if ($this->showPopupKm && $this->userSub == '') {
            if (!isset($_SESSION['already_popupkm'])) {
                $_SESSION['already_popupkm'] = 1;
                $this->redirect(Yii::app()->createUrl('/site/popupKm'));
            }
        }        
        if ($this->showPopup) {
            if (!isset($_SESSION['already_popupkm'])) {
                $_SESSION['already_popupkm'] = 1;
                $this->redirect(Yii::app()->createUrl('/site/popupDk'));
            }
        }
        ?>
    </head>
    <?php
    Yii::app()->controller->renderPartial('application.views.wap.layouts.body', array('cId' => $cId,
        'actionId' => $actionId,
        'content' => $content,
        'layout' => 'normal'
            )
    );
    ?>
</html>