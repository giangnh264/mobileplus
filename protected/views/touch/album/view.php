<?php
if ($album->id) {
	$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl("s4", $album->id), $album->name,array('class' => 'avatar'));
} else {
	$avatarImage = CHtml::image('/touch/css/wap/images/icon/clip-50.png', '', array('class' => 'avatar'));
}
$artist_name = $album->artist_name;
?>
<div class="vg_album">
	<?php echo $avatarImage;?>
	<h3 class="name"><?php echo CHtml::encode($album->name);?></h3>
	<p class="artist subtext"><?php echo CHtml::encode($artist_name); ?></p>
</div>
<?php if($perLimit){?>
<div class="limit_content">
	<div class="msglimit">
		<?php
		echo $perLimit->msg_warning;
		?>
		<a class="underline" href="<?php echo Yii::app()->createUrl('account/package')?>">Đăng ký tại đây</a>
	</div>
</div>
	<?php
	$this->renderPartial("_list_song",compact("songsOfAlbum"));
	?>
<?php }elseif($deactive){
	$msg = Yii::app()->params['alert_content_limited'];
	$this->widget('application.widgets.touch.common.NotifyMessageWidget', array('msg'=>$msg,'type'=>'album'));
	$this->renderPartial("_list_song",compact("songsOfAlbum"));
}
else{?>
<?php 
$this->widget ( 'application.widgets.touch.player.ListPlayer', array (
		'album' => $album,
		'songs'=>$songsOfAlbum,
		'like'=>$like,
) );
?>
<?php }?>
<ul class="orther clb" style="overflow: hidden ; margin-top: -1px;">
	<li><a class="same active" onClick="LoadSame('<?php echo Yii::app()->createUrl('/album/loadAjax', array('s'=>'artist', 'id'=>$album->id, 'artist_id'=>$album->artist_id));?>');" href="javascript:void(0)"><?php echo Yii::t("wap","Same artist");?></a></li>
    <li class="line"><a href=''>|</a></li>
    <li><a class="same" onClick="LoadSame('<?php echo Yii::app()->createUrl('/album/loadAjax', array('s'=>'genre', 'id'=>$album->id, 'genre_id'=>$album->genre_id));?>');"
				href="javascript:void(0)"><?php echo Yii::t("wap","Same genre");?></a></li>
</ul>
<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerScript(
		'load-album-same',
		"function LoadSame(url){
		  $.ajax({
				'url':url,
				'success': function(data){
					$(\"#res-albums\").html(data);
				},
				'beforeSend':function(data){
					$(\"#res-albums\").html(\"<img width='55' src='".Yii::app()->request->baseUrl."/touch/images/ajax_loading.gif' />\");
				}
			  })
		return false;
		}",
		CClientScript::POS_END
);

$cs->registerScript(
		'load-active-tab',
		"$('a.same').click(function(){
			$('a.same').removeClass('active');
			$(this).toggleClass('active');
		});",
		CClientScript::POS_END
);
?>
<div id="res-albums">
<?php
	$this->widget('application.widgets.touch.album.AlbumListWidget',array('albums'=>$albumsSameArtist));
?>
</div>
