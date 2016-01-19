<style>
    p{
        line-height: 15px;
    }
</style>
<?php
$this->pageLabel = Yii::t("admin",Yii::t('admin','Sự kiện tham gia khách hàng'));
?>

<div class="search-form">
    <div class="wide form">
        <form method="get" action="<?php echo Yii::app()->createUrl('/gamification/adminUserEvent/index');?>">
            <div class="row">
                <?php echo CHtml::label('Số điện thoại',''); ?>
                <?php echo CHtml::textField('adminUserEvent[user_phone]',$_GET['adminUserEvent']['user_phone']); ?>
            </div>
            <div class="fl">
                <div class="row created_time">
                    <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
                    <?php
                    $this->widget('ext.daterangepicker.input', array(
                        'name' => 'songreport[date]',
                        'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
                    ));
                    ?>
                </div>
            </div>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Search'); ?>
                <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
            </div>
            <input type="hidden" value="gamification/adminUserEvent/index" name="r">
        </form>
    </div
</div>
</div>
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
<div class="pagging">
    <?php
    $this->widget('CLinkPager',
        array(
            'pages'				=> $page,
            'maxButtonCount'	=> 10,
        ));
    ?>
</div>