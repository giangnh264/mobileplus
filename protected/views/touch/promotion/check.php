<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl . "/touch/css/promotion.css");
?>
<?php include_once '_promotion.php'; ?>
<div class="promotion_content">
    <div class="box-info">
        <?php
        if (!$is_login):
        ?>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'action' => Yii::app()->createUrl('/account/login'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <p>Vui lòng Đăng nhập bằng số thuê bao MobiFone để tra cứu điểm thưởng</p>
        <?php echo $form->textField($model, 'phone', array("placeholder" => Yii::t("wap", "Phone number"), "class" => "getpass")); ?>
        <div style="clear: both; text-align: center;">
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <?php echo $form->passwordField($model, 'password', array("placeholder" => Yii::t("wap", "Password"), "class" => "otp")); ?>
        <div style="clear: both; text-align: center;">
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <br/>

        <div class="row submit">
            <?php echo CHtml::link(Yii::t("wap", "Login"), "#", array("submit" => '#', 'class' => 'button-dark btn-submit width100')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php else: ?>
        <div class="promotion_hello">Chào <span class="color-red"><?php echo $phone; ?>,</span></div>
        <div class="ovh">
            <span class="fontB">Tổng số điểm của bạn là:</span>
            <span class="color-red"><?php echo $point; ?></span>
        </div>
        <div class="ovh pb10 pt10">
            <span class="selected_title fontB">Tra cứu điểm thưởng</span>
            <select class="chart_time_promotion fll" id="weeks" name="weeks">
                <?php foreach ($list_week as $week) {
                    $year = date('Y');
                    $first_date = date("d/m/Y", Utils::getFirstDayOfWeek($year, $week));
                    $end_date = date("d/m/Y", strtotime("+6 day", Utils::getFirstDayOfWeek($year, $week)));
                    ?>
                    <option <?php echo ($week == $current_week) ? 'selected="selected"' : ''; ?>
                        value="<?php echo $week; ?>"><?php echo Yii::t('web', 'Từ ngày') . " " . $first_date ?>
                        - <?php echo $end_date ?></option>
                <?php }
                ?>
            </select>
        </div>
        <div class="fontB">Thông tin chi tiết</div>
        <table class="promotion_table">
            <tr class="bg_color">
                <th class="color_333" style="width:20%;">Giao dịch</th>
                <th class="color_333" style="width:45%;">Gói/Mã nội dung</th>
                <th class="color_333" style="width:25%;">Thời gian</th>
                <th class="color_333" style="width:10%;">Điểm</th>
            </tr>
            <?php
            $i = 0;
            $point = 0;
            foreach ($dataProvider as $item):
                $point += $item->point;
                $i++;
                ?>
                <tr align="right" class="new <?php if ($i % 2 == 0) echo 'bg_color'; else echo '';?>">
                    <td><?php echo $item->transaction_name;?></td>
                    <td><?php echo $item->content_name?></td>
                    <td><?php echo $item->created_time?></td>
                    <td><?php echo $item->point?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="3" class="color_333" style="width:20%;">Điểm</th>

                <th class="color_333" style="width:10%;"><?php echo $point;?></php></th>
            </tr>
        </table>
    <?php endif; ?>
    <script type="text/javascript">
        $('#weeks').change(function () {
            var week = $(this).val();
            var url = '/promotion/check/week/' + week;
            window.location.href = url;
        });
    </script>