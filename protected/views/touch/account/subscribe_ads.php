<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('/account/subscribe'),
    'id' => 'subscribe-form',
    'enableAjaxValidation' => false,
        ));
?>
<div style="padding: 0px 5px;">
    <div class="fontB">
        <?php echo Yii::t('chachawap', 'Đăng ký Gói cước iMuzik3G'); ?>
    </div>
    <div class="padT10 padL5">
        <?php
        $flag = false;
        if (!empty($userObj)) {
            $isKM10days = false;
            if (time() > strtotime('2013-04-15') && time() < strtotime('2013-12-31 23:59:59') && Yii::app()->user->getState('msisdn')) {
                $isKM10days = WapUserTransactionModel::checkTrial10Days(Formatter::formatPhone(Yii::app()->user->getState('msisdn')));
            }
            if ($isKM10days && $userObj->status == 1) {
                $model = ConfigModel::getConfig('SUCCESS_10DAYS_TRIAL');
                $date_free = date('d/m/Y', time() + 24 * 3600 * 10);
                echo Yii::t('wap', $model, array('{DATE}' => $date_free));
            } else {
                echo Yii::t('wap', 'Chúc mừng Quý khách đã đăng ký thành công dịch vụ Imuzik 3G. Phí thuê bao 10.000đ/tháng, miễn phí data, miễn phí tải nhạc và video không giới hạn. Trân trọng cảm ơn!');
            }
        } else if (!empty($result) && $result->errorCode != 0) {
            echo $msg = Yii::t('wap', Yii::app()->params['subscribe'][$result->message]);
        } else {
            $flag = true;
            if ($isKm) {
                echo "Quý khách được khuyến mại 10 ngày dùng thử miễn phí dịch vụ Imuzik3G, miễn phí cước data (3G/GPRS), miễn phí nghe, tải nhạc chất lượng cao không giới hạn số lượng.";
            } else {
                echo $package->description;
            }
        }
        ?>
    </div>
    <?php if ($flag): ?>
        <div class="padL5 padT10 padB10">
            <input type="hidden" name="source" value="<?php echo $source; ?>"/>
            <input type="hidden" name="member" value="<?php echo $member; ?>"/>
            <?php echo CHtml::submitButton(Yii::t('chachawap', $isKm ? "ĐĂNG KÝ KHUYẾN MẠI" : "ĐĂNG KÝ")); ?>
            <?php echo CHtml::button(Yii::t('chachawap', 'Bỏ qua'), array('onclick' => 'goHome();')) ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget(); ?>