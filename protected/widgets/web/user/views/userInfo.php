<div class="box_title">
	<h2 class="name"><a href="<?php echo $this->link;?>"><?php echo Yii::t("web", "Personal information"); ?></a></h2>
</div>
<div class="pt20">
	<ul class="user-info">
		<?php if (!empty($user->fullname)) :?>
		<li><b><?php echo Yii::t("web", "Fullname"); ?>: </b><span><?php echo $user->fullname;?></span></li>
		<?php endif; ?>

		<?php if (isset($user->user_extra->birthday)&& !empty($user->user_extra->birthday)) :?>
		<li><b><?php echo Yii::t("web", "Birthday"); ?>:</b>
			<span>
				<?php echo Formatter::formatDayOfWeek($user->user_extra->birthday); ?>
			</span>
		</li>
		<?php endif; ?>

		<?php if (isset($userSubscribe->package->name)) :?>
		<li><b><?php echo Yii::t('web', 'Package') ?>: </b><span><?php echo ($userSubscribe->package->name); ?></span></li>
		<?php endif; ?>

		<?php if (isset($user->user_extra->introduction) && !empty($user->user_extra->introduction)) :?>
			<li><b><?php echo Yii::t('web', 'Introduction') ?>: </b><span><?php echo ($user->user_extra->introduction); ?></span></li>
		<?php endif; ?>
	</ul>
</div>