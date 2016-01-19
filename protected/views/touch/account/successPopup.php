<div style="padding: 0px 5px;">
    <div class="fontB">
        <?php echo Yii::t('chachawap', 'Thông báo'); ?>
    </div>
    <div class="padT10 padL5">
        <?php
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
//        $expTime = date("d/m/Y", strtotime($userObj->expired_time));
//        echo Yii::t('wap', "Cảm ơn Quý khách đã đăng ký dùng thử dịch vụ Imuzik3G. Quý khách được dùng thử miễn phí dịch vụ Imuzik3G đến ngày {$expTime}. Hết thời gian dùng thử, nếu Quý khách chưa hủy dịch vụ, hệ thống tự động đăng ký gói cước Imuzik3G cho Quý khách (10.000đ/tháng). Quý khách được miễn phí toàn bộ cước data (3G/GPRS) phát sinh từ dịch vụ Imuzik3G. Liên hệ 1818 (200đ/p) để được hỗ trợ. Trân trọng cảm ơn");
        ?>
    </div>
</div>