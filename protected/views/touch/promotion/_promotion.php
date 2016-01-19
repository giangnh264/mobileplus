<?php
$controller = Yii::app()->controller;
$action = $this->action->id;
?>
<a href='#' class='wrap-head mr-t-15' title='<?php echo Yii::t("wap", "Khuyến mại"); ?>'>
    <div class='head-label clearfix'>
        <span class='text'><?php echo Yii::t("wap", "Khuyến mãi"); ?></span>
    </div><!-- End .head-label -->
</a>
<ul class="promotion_main">
    <li class="about <?php if($action == 'about') echo 'active'; else echo '';?>">
        <a class="icon_promotion" href="<?php echo Yii::app()->createUrl('promotion/about');?>">
        <?php if($action == 'about'):?>
            <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/about_active.png">
            <?php else:?>
            <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/about.png">
            <?php endif;?>
        </a>
        <div class="text_titile">Giới thiệu</div>
    </li>
    <li class="check <?php if($action == 'check') echo 'active'; else echo '';?>">
        <a class="icon_promotion" href="<?php echo Yii::app()->createUrl('promotion/check');?>">
            <?php if($action == 'check'):?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/check_active.png">
            <?php else:?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/check.png">
            <?php endif;?>
        </a>
        </a>

        <div class="text_titile">Tra cứu</div>
    </li>
    <li class="list <?php if($action == 'list') echo 'active'; else echo '';?>">
        <a class="icon_promotion" href="<?php echo Yii::app()->createUrl('promotion/list');?>">
            <?php if($action == 'list'):?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/list_active.png">
            <?php else:?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/list.png">
            <?php endif;?>
        </a>
        <div class="text_titile">Danh sách</div>
    </li>
    <li class="hotlist <?php if($action == 'hotlist') echo 'active'; else echo '';?>">
        <a class="icon_promotion" href="<?php echo Yii::app()->createUrl('promotion/hotlist');?>">
            <?php if($action == 'hotlist'):?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/hotlist_active.png">
            <?php else:?>
                <img src="<?php echo  Yii::app ()->request->baseUrl?>/touch/images/promotion/hotlist.png">
            <?php endif;?>
        </a>
        <div class="text_titile">HOT</div>
    </li>
</ul>