<?php
$this->pageLabel = Yii::t("admin",Yii::t('admin','Tra cứu khách hàng'));

?>
<div class="search-form">
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div><!-- search-form -->
<fieldset>
    <legend>Thông tin khách hàng</legend>
    <?php if($userInfo){?>
        <div class="row">
            <label>Số điện thoại:</label>
            <strong><?php echo $userInfo->user_phone;?></strong>
        </div>
        <div class="row">
            <label>Điểm:</label>
            <strong><?php echo $userInfo->point;?></strong>
        </div>
        <div class="row">
            <label>Thời gian cập nhật:</label>
            <strong><?php echo date('d/m/Y H:i:s', strtotime($userInfo->updated_time));?></strong>
        </div>
        <p><a href="<?php echo Yii::app()->createUrl('/gamification/adminUserEvent/index',array('adminUserEvent[user_phone]'=>$userInfo->user_phone))?>">Chi tiết sự kiện tham gia</a></p>
    <?php }elseif(isset($_GET['AdminUserModel']['user_phone'])){?>
        <p>Không tìm thấy thông tin của sdt: <strong><?php echo $_GET['AdminUserModel']['user_phone'];?></strong></p>
    <?php }?>
</fieldset>