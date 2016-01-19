<div class="h_header">
<div class="wr2">
	<h3><?php echo Yii::app()->params['horoscope']['title']?></h3>
	<?php echo Yii::app()->params['horoscope']['full']?>
</div>
</div>
<div class="h_body">
<div class="wr2">
<?php if($radioList){?>
<?php 
$i=0;
foreach ($radioList as $value){
	$avatar = RadioModel::model()->getAvatarUrl($value['id'],'s1');
	$link = Yii::app()->createUrl('/personality/view', array('id'=>$value['id'], 'url_key'=>Common::url_friendly($value['name'])));
	$albumName = WapRadioModel::model()->getAlbumByRadio($value['id']);
?>
<?php if($i%4==0){?><div class="h_row"><?php }?>
<div class="h_item">
	<a href="<?php echo $link;?>">
	<div class="wrr-item-detail">
		<img width="100%" src="<?php echo $avatar;?>" />
		<p class="ht_title"><?php echo $value['name'];?></p>
		<div class="album_name"><p><?php echo $albumName;?></p></div>
	</div>
	</a>
</div>
<?php $i++;?>
<?php if($i%4==0 && $i!=0){?></div><?php }else{?>
<div class="h_space"></div>
<?php }?>
<?php
}?>
<?php }?>
</div>
</div>
