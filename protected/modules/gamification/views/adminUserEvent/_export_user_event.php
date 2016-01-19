    <strong>Thời gian: Từ - <?php echo $first_date?>  đến <?php echo $end_date?></strong>
<div class="ovh">
    <span class="fontB">Tổng số điểm của bạn là:</span>
    <span class="color-red"><?php echo $point; ?></span>
</div>
<table class="promotion_table">
    <tr class="bg_color">
        <th class="color_333" style="width:20%;">Giao dịch</th>
        <th class="color_333" style="width:45%;">Gói/Mã nội dung</th>
        <th class="color_333" style="width:25%;">Thời gian</th>
        <th class="color_333" style="width:10%;">Điểm</th>
    </tr>

    <?php
    $i = 0;
    foreach ($dataProvider as $item):
        $i++;
        ?>
        <tr align="right" class="new <?php if ($i % 2 == 0) echo 'bg_color'; else echo '';?>">
            <td><?php echo $item->transaction_name;?></td>
            <td><?php echo $item->content_name?></td>
            <td><?php echo $item->created_time?></td>
            <td><?php echo $item->point?></td>
        </tr>
    <?php endforeach; ?>

</table>