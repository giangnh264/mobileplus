<div class="colum1 fll">
	<ul class="sub_chart ovh">
<!-- 		<li><h2><a href="#" class="chart_all <?php echo ($this->genre == '1') ? 'active' : ''; ?>"><i class="icon icon_song1"></i> Tất cả</a></h2></li> -->

		<li><h2><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'VN')); ?>" class="chart_vn <?php echo ($this->genre == 'VN') ? 'active' : ''; ?>"><i class="icon icon_song2"></i><?php echo Yii::t('web','Việt nam'); ?></a></h2></li>
		<!--<li><h2><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'KOR')); ?>" class="chart_kr <?php echo ($this->genre == 'KOR') ? 'active' : ''; ?>"><i class="icon icon_song3"></i><?php echo Yii::t('web','Korean'); ?></a></h2></li>-->
		<li><h2><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'EUR')); ?>" class="chart_qt <?php echo ($this->genre == 'EUR') ? 'active' : ''; ?>"><i class="icon icon_song4"></i><?php echo Yii::t('web','US-UK'); ?></a></h2></li>
	</ul>
	<?php /*
	<h2 class="title_chart">BXH Quốc Tế</h2>
	<ul class="sub_chart_qt ovh">
		<li><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'BILLBOARD')); ?>" <?php echo ($this->genre == 'BILLBOARD') ? 'class="active"' : ''; ?> ><i class="icon icon_billboard1"></i></a></li>
		<li><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'ITUNE')); ?>" <?php echo ($this->genre == 'ITUNE') ? 'class="active"' : ''; ?>><i class="icon icon_itunes1"></i></a></li>
		<li><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'MTV')); ?>" <?php echo ($this->genre == 'MTV') ? 'class="active"' : ''; ?>><i class="icon icon_mtv1"></i></a></li>
		<li><a href="<?php echo Yii::app()->createUrl('/chart/index',array('type'=>$this->type,'genre'=>'HAN')); ?>" <?php echo ($this->genre == 'HAN') ? 'class="active"' : ''; ?>><i class="icon icon_mnet1"></i></a></li>
	</ul>
	*/?>
</div>
