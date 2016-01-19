<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerCssFile ( Yii::app ()->request->baseUrl . "/touch/css/promotion.css" );
?>
<?php include_once '_promotion.php';?>
<div class="promotion_content">
    <span class="selected_title">Danh sách trúng thưởng</span>
    <select class="chart_time_promotion fll" id="weeks" name="weeks">
        <?php foreach ( $list_week as $week) {
            $year = date('Y');
            $first_date = date("d/m/Y", Utils::getFirstDayOfWeek($year,$week));
            $end_date = date("d/m/Y", strtotime("+6 day", Utils::getFirstDayOfWeek($year,$week)));
            ?>
            <option <?php echo ($week == $current_week) ? 'selected="selected"' : ''; ?> value="<?php echo $week; ?>"><?php echo Yii::t('web', 'Từ ngày') . " " . $first_date  ?> - <?php echo $end_date ?></option>
        <?php }
        ?>
    </select>
    <div class="selected_title">Thông tin chi tiết</div>
    <table class="promotion_table">
        <tr class="bg_color">
            <th class="color_333" style="width: 5%;">STT</th>
            <th class="color_333" style="width: 25%;">Số thuê bao</th>
            <th class="color_333" style="width: 20%;">Tổng điểm</th>
            <th class="color_333" style="width: 40%;">Giải</th>
        </tr>

        <?php
        $i = 0;
        foreach ($data as $item):
        $i ++;
        $type  = "Nhì";
        if($i == 1){
            $type = 'Nhất';
        }
        ?>
            <tr align="right" class="new <?php if($i%2 == 0) echo 'bg_color'; else echo '';?>">
                <?php
                $list_phone = $item->user_phone;
                if($list_phone != $my_phone)
                {
                    $list_phone = substr($list_phone, 0, -2);
                    $list_phone = $list_phone . 'XX';
                }else{
                    $list_phone = $my_phone;
                }
                ?>
                <td><?php echo $i;?></td>
                <td><?php echo $list_phone;?></td>
                <td><?php echo number_format($item->point);?></td>
                <td><?php echo $type;?></td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
<script type="text/javascript">
    $('#weeks').change(function(){
        var week = $(this).val();
        var url = '/promotion/list/week/' + week;
        window.location.href = url;
    });
</script>