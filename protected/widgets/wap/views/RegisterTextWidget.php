<?php
if (!$userSub):
    echo '<div class="r">';
    if ($isPromotion) {
        echo '<p>Khuyến mại từ 23-8 Miễn phí đăng ký cho thuê bao mới. Nghe xem tải nhạc, video không giới hạn cước 3G=0</p>';
    } else {
        echo $registerText . "<br>";
    }
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->baseUrl . '/account/doRegister',
        'id' => 'subscribe-form',
        'enableAjaxValidation' => false,
            ));
    ?>
    <?php echo CHtml::hiddenField('phoneNumber', '') ?>
    <?php echo CHtml::hiddenField('id', 3) ?>
    <div class=""><?php echo CHtml::submitButton(Yii::t('chachawap', 'ĐĂNG KÝ'), array('class' => 'inputG fontB')); ?></div>
    <?php
    $this->endWidget();
    echo '</div>';
endif;
?>