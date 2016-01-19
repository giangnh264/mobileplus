<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/touch/js/jquery.datetimepicker.css"/ >
<script src="<?php echo Yii::app()->request->baseUrl ?>/touch/js/jquery.datetimepicker.js"></script>

<div id="login-wifi" class="box-info">
        <?php if (!empty($user_sub)): ?>
            <?php echo Yii::t("wap","Bạn đang dùng {PACKAGE}", array('{PACKAGE}'=>$user_sub->package->name));?>
            <?php $title = Yii::t("wap","Change the package");?>
            <br>
        <?php else: ?>
            <?php $title = Yii::t("wap","Register");?>
            <?php $packages = WapPackageModel::model()->findAllByAttributes(array('status' => 1)); ?>
            <ul class="song_list">
                <?php
                $i = 0;
                foreach ($packages as $pack):
                    $i++;
                    ?>
                    <li class="item <?php if ($i == count($packages)) echo 'last_item'; ?>" style="padding: 10px 0">
                        <div>
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'action' => Yii::app()->baseUrl . '/account/doRegister',
                                'id' => 'subscribe-form-pack-' . $pack->id,
                                'enableAjaxValidation' => false,
                            ));
                            ?>
                            <?php echo CHtml::hiddenField('phoneNumber', '') ?>
                            <?php echo CHtml::hiddenField('id', $pack->id) ?>
                            <table width="100%">
                                <tr>
                                    <td class="width70">
                                        <div class="padL10 padT10">
                                            <strong style="font-size: 16px;"><?php echo $pack->name ?></strong>
                                            <div class="desc"><?php echo $pack->description; ?></div>
                                            <p class="desc">Để hủy soạn HUY <?php echo $pack->code ?> gửi 9166.</p>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <div class="btn-popup btn-popup-green bt_submit" ><?php echo Yii::t("wap","Register");?></div>
                                    </td>
                                </tr>
                            </table>

                            <?php $this->endWidget(); ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
     <?php if (!empty($user_sub)): ?>
        <div class="change-package">
            <a class="button-dark btn-submit width100" href="<?php echo Yii::app()->createUrl('account/package');?>"><?php echo CHtml::encode(Yii::t("wap", "Thay đổi gói cước"));?></a>
        </div>
     <?php endif; ?>
    <div class="user_info">
        <h3 class="title4"><?php echo Yii::t("wap","User Information");?></h3>
    </div>

    <div id="res-form2"></div>
    <?php if ($error_success != ""): ?>
    <div  class="errorMessage_sucess">
        <div><?php echo $error_success; ?></div>
    </div>
    <?php endif;?>
    <?php if ($error != ""): ?>
        <div style="clear: both; text-align: center;">
            <div class="errorMessage"><?php echo $error; ?></div>
        </div>
    <?php endif ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'info-form',
        'action' => "",
        'method' => 'post',
        'htmlOptions' => array(
            'class' => 'profile-form1'
        )
    ));
    ?>
    <div class="row input_s2">
        <?php echo CHtml::textField("Profile[username]", $user->username, array('style' => 'text-align: center')) ?>
    </div>
    <div class="row input_s2 background_color_gray">
        <?php echo CHtml::textField("Profile[phone]", $user->phone, array('disabled' => 'disabled', 'style' => 'text-align: center')) ?>
    </div>
    <div class="row input_s2">
        <?php echo CHtml::textField("Profile_birthday", isset($user_extra->birthday) ? date('d/m/Y', strtotime($user_extra->birthday)) : "", array('placeholder' => Yii::t("wap","Date of birth (dd/mm/yyyy)"),'autofocus'=>($forcus == 'birthday')? true : false)) ?>
    </div>
    <?php
    echo CHtml::dropDownList('Profile[genre]', $user->gender, array(
        '1' => Yii::t("wap","Male"),
        '2' => Yii::t("wap","Famale")
            ), array(
        'empty' => Yii::t('wap','Sex'),
    ));
    ?>
    <div class="row input_s2">
        <?php echo CHtml::textField("Profile[email]", $user->email, array('placeholder' =>Yii::t("wap","Email"),'autofocus'=>($forcus == 'email')? true : false)) ?>
    </div>
    <?php
    $address = array(
        'An Giang' => 'An Giang',
        'Bạc Liêu' => 'Bạc Liêu',
        'Bắc Cạn' => 'Bắc Cạn',
        'Bắc Giang' => 'Bắc Giang',
        'Bắc Ninh' => 'Bắc Ninh',
        'Bến Tre' => 'Bến Tre',
        'An Giang' => 'An Giang',
        'Bình Dương' => 'Bình Dương',
        'Bình Định' => 'Bình Định',
        'Bình Phước' => 'Bình Phước',
        'Bình Thuận' => 'Bình Thuận',
        'Cà Mau' => 'Cà Mau',
        'Cao Bằng' => 'Cao Bằng',
        'Cần Thơ' => 'Cần Thơ',
        'Đà Nẵng' => 'Đà Nẵng',
        'Đắc Lắc' => 'Đắc Lắc',
        'Đắc Nông' => 'Đắc Nông',
        'Điện Biên' => 'Điện Biên',
        'Đồng Nai' => 'Đồng Nai',
        'Đồng Tháp' => 'Đồng Tháp',
        'Gia Lai' => 'Gia Lai',
        'Hà Giang' => 'Hà Giang',
        'Hà Nam' => 'Hà Nam',
        'Hà Nội' => 'Hà Nội',
        'Hà Tĩnh' => 'Hà Tĩnh',
        'Hải Dương' => 'Hải Dương',
        'Hải Phòng' => 'Hải Phòng',
        'Hậu Giang' => 'Hậu Giang',
        'Hòa Bình' => 'Hòa Bình',
        'Hưng Yên' => 'Hưng Yên',
        'Khánh Hòa' => 'Khánh Hòa',
        'Kiên Giang' => 'Kiên Giang',
        'Kon Tum' => 'Kon Tum',
        'Lai Châu' => 'Lai Châu',
        'Lạng Sơn' => 'Lạng Sơn',
        'Lào Cai' => 'Lào Cai',
        'Lâm Đồng' => 'Lâm Đồng',
        'Long An' => 'Long An',
        'Nam Định' => 'Nam Định',
        'Nghệ An' => 'Nghệ An',
        'Ninh Bình' => 'Ninh Bình',
        'Ninh Thuận' => 'Ninh Thuận',
        'Phú Thọ' => 'Phú Thọ',
        'Phú Yên' => 'Phú Yên',
        'Quảng Bình' => 'Quảng Bình',
        'Quảng Nam' => 'Quảng Nam',
        'Quảng Ngãi' => 'Quảng Ngãi',
        'Quảng Ninh' => 'Quảng Ninh',
        'Quảng Trị' => 'Quảng Trị',
        'Sóc Trăng' => 'Sóc Trăng',
        'Sơn La' => 'Sơn La',
        'Tây Ninh' => 'Tây Ninh',
        'Thái Bình' => 'Thái Bình',
        'Thái Nguyên' => 'Thái Nguyên',
        'Thanh Hóa' => 'Thanh Hóa',
        'Thừa Thiên Huế' => 'Thừa Thiên Huế',
        'Tiền Giang' => 'Tiền Giang',
        'TPHCM' => 'TPHCM',
        'Trà Vinh' => 'Trà Vinh',
        'Tuyên Quang' => 'Tuyên Quang',
        'Vĩnh Long' => 'Vĩnh Long',
        'Vĩnh Phúc' => 'Vĩnh Phúc',
        'Vũng Tàu' => 'Vũng Tàu',
        'Yên Bái' => 'Yên Bái'
    );
    echo CHtml::dropDownList('Profile[address]', $user->address, $address, array(
        'empty' => Yii::t("wap","City"),
    ));
    ?>
    <br />
    <div class="row submit">
        <?php echo CHtml::link(Yii::t("wap", "Cập nhật"), "#", array("submit" => "#",  'class' => 'button-dark btn-submit width100')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <div class="user_info">
        <h3 class="title4"><?php echo Yii::t("wap","Change password");?></h3>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'change-pass-form',
        'action' => "",
        'method' => 'post',
        'htmlOptions' => array(
            'class' => 'profile-form3'
        )
    ));
    ?>
    <div id="res-form3"></div>
    <?php if ($error2 != ""): ?>
        <div style="clear: both; text-align: center;">
            <div class="errorMessage"><?php echo $error2; ?></div>
        </div>
    <?php endif ?>
    <?php if (Yii::app()->user->hasFlash('change_pass_status')) { ?>
        <div class="success"><?php
            echo Yii::app()->user->getFlash('change_pass_status');
            Yii::app()->user->setFlash('change_pass_status', null);
            ?>
        </div>
    <?php } ?>
    <div class="row input_s2">
        <?php echo CHtml::passwordField("Profile2[password]", "", array('placeholder' =>Yii::t("wap","Old Password"),'autofocus'=>($forcus == 'password')? true : false)) ?>
    </div>
    <div class="row input_s2">
        <?php echo CHtml::passwordField("Profile2[password_new]", "", array('placeholder' =>Yii::t("wap","New Password"),'autofocus'=>($forcus == 'password_new')? true : false)) ?>
    </div>
    <div class="row input_s2">
        <?php echo CHtml::passwordField("Profile2[password_new_retype]", "", array('placeholder' =>Yii::t("wap","Confirm New Password"),'autofocus'=>($forcus == 'password_new_retype')? true : false)) ?>
    </div>
    <input type="hidden" name="Profile2[phone]" value="<?php echo $user->phone; ?>" />
    <br />
    <div class="row submit">
        <?php echo CHtml::link(Yii::t("wap", "Cập nhật"), "#", array("submit" => "#",  'class' => 'button-dark btn-submit width100')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    jQuery('#Profile_birthday').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

</script>