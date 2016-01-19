<div id="Popup">
    <a href="javascript:void(0)" class="popup_close">X</a>
    <div id="popup_wr">
        <div class="popup_title">
            <span id="pop_title"><?php echo Yii::t("wap", "Notification"); ?></span>
        </div>
        <div class="popup_content">
            <div class="" style="padding: 10px; overflow: hidden;">
                <?php
                if ($type == "song") {
                    $text = "bài hát";
                    $action = "downloadSong";
                } else {
                    $text = "video";
                    $action = "downloadVideo";
                }
                if (!$nosub) {
                    $content = str_replace(":CONTENT", $text, Yii::app()->params["content_download"]);
                    $content = str_replace(":PRICE ", $obj->download_price, $content);
                } else {
                    $content = str_replace(":PRICE", $obj->download_price, Yii::app()->params["content_download_request"]);
                }

                echo $content;
                ?>

                <div class="clb">
                    <?php if (!$nosub): ?>
                        <div class="btn-popup btn-popup-green "
                             style="width: 45%; float: left;">
                            <a href="#download" onclick="downloadContent('<?php echo $obj->id ?>', '<?php echo $obj->code ?>', '<?php echo $action ?>', '')"						
                               class="" style="color: #FFF; display: block;"><?php echo Yii::t("wap", "Yes"); ?></a>
                        </div>

                        <div class="btn-popup btn-popup-green " onclick=" Popup.close();"
                             style="width: 45%; float: right;">
                            <a href="javascript:void(0)" style="color: #FFF"><?php echo Yii::t("wap", "No"); ?></a>
                        </div>
                    <?php else: ?>
                        <div class="btn-popup btn-popup-green " 
                             style="width: 45%; float: left;">
                            <a href="<?php echo Yii::app()->createUrl("account/package") ?>" style="color: #FFF"><?php echo Yii::t("wap", "Register"); ?></a>
                        </div>

                        <div class="btn-popup btn-popup-green "
                             style="width: 45%; float: right;">
                            <a href="#download" onclick="downloadContent('<?php echo $obj->id ?>', '<?php echo $obj->code ?>', '<?php echo $action ?>', '')"						
                               class="" style="color: #FFF; display: block;"><?php echo Yii::t("wap", "Download"); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>