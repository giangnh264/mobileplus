<?php if ($this->isSub){?>
<!-- <div class="padB10">-->
<?php 
	$user = WapUserSubscribeModel::model()->getByPhone(yii::app()->user->getState('msisdn'));
	/* if($user){
		echo '<div>Quý khách đang sử dụng gói cước <strong>'.PackageModel::model()->findByPk($user->package_id)->name.'</strong></div>';
		echo '<div>Thời hạn sử dụng đến hết ngày:  <strong>'.date('d/m/Y', strtotime($user->expired_time)).'</strong></div>';
	} */
?>
<!--</div>-->
<?php }?>
<?php 
//if (empty($this->isSub)){
if($packages):?>
	<ul class="song_list items-list">
    <?php 
    $i=0;
    foreach ($packages as $pack):
    $i++;
    ?>
        <li class="item <?php if($i==count($packages)) echo 'last_item';?>" style="padding: 10px 0">
			<table width="100%">
				<tr>
					<td class="width70">
						<div class="padL10 padT10">
							<strong style="font-size: 16px;"><?php echo $pack->name ?></strong>
							<div class="desc"><?php echo $pack->description; ?>.</div>
							<p class="desc">Để hủy soạn HUY <?php echo $pack->code ?> gửi 9166.</p>
						</div>
					</td>
					<td align="center" style="padding-left: 10px;">
						<?php if(!(isset($user) && $pack->id==$user->package_id)):?>
							<a class="btn-popup btn-popup-green bt_submit" href="<?php echo Yii::app()->createUrl('/account/doRegister', array('id'=>$pack->id));?>" ><?php echo Yii::t("wap","Đăng ký");?></a>
						<?php endif;?>

					</td>
				</tr>
			</table>
        </li>
    <?php endforeach;?>
    </ul>
<?php endif; ?>