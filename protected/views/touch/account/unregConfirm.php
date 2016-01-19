<div class="vg_option">
	<a href="#" class="opt_genre"><span class="fll"><?php echo Yii::t("wap","Cancel package");?></span></a>
</div>
<div class="padB10">
	<?php if(Yii::app()->user->hasFlash('msg')):?>
            <div class="padT10">
	    	<?php
                    echo Yii::app()->user->getFlash('msg');
                    Yii::app()->user->setFlash('msg',null);
	    	?>
	    </div>
	<?php endif;?>
<br />
<div style="overflow: hidden; clear: both;">
	<a href="<?php echo Yii::app()->createUrl('account/unregisterPackage', array('package'=>$package->code));?>" class="button-dark btn-submit">Đồng ý</a>
	<a href="<?php echo Yii::app()->createUrl('site/index');?>" class="button-grey btn-submit">Hủy</a>
</div>
<br />
<br />
</div>