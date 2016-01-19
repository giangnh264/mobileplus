    <!-- Thong tin tai khoan -->
    <div class="pad10">
        <div class="vg_option list-label mr-t-15 clearfix">
            <a href="#" class="opt_genre"><span class="fll"><?php echo Yii::t("wap", "User Infomation"); ?></span></a>
        </div>
    </div>
    <?php if (Yii::app()->user->hasFlash('msg')): ?>
        <div class="pad10"><?php
            echo Yii::app()->user->getFlash('msg');
            Yii::app()->user->setFlash('msg', NULL);
            ?></div>
    <?php endif; ?>
    <div class="account_infomation">
        <?php if ($userSub) : ?>
            <p class="m0"><?php echo Yii::t("wap", "Your current package :PACKAGE", array(':PACKAGE' => $userSub->package->name)); ?>
                .
                <?php if ($userSub->expired_time < date('Y-m-d H:i:s')): ?>
                    <?php echo Yii::t("wap", "Your package is out of date :DATE", array(':DATE' => date('H:i:s d/m/Y', strtotime($userSub->expired_time)))); ?>.
                <?php else: ?>
                    <?php echo Yii::t("wap", "Expiration date :DATE", array(':DATE' => date('H:i:s d/m/Y', strtotime($userSub->expired_time)))) ?>.
                <?php endif; ?>
            </p>
            <a id="yt0" href="<?php echo Yii::app()->createUrl('account/unregConfirm', array('id' => $userSub->package->id));?>" class="button-dark btn-submit"><?php echo Yii::t("wap", "Unregister");?></a>
        <?php else : ?>
            <p><?php echo yii::t('wap', 'Bạn đang không sử dụng gói cước nào') ?></p>
            <a id="yt0" href="<?php echo Yii::app()->createUrl('account/package');?>" class="button-dark btn-submit"><?php echo Yii::t("wap", "Register");?></a>
        <?php endif ?>
    </div>
