<?php
/* if ($album->id) {
	$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl("s4", $album->id), array('class' => 'avatar'));
} else {
	$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', array('class' => 'avatar'));
} */
$artist_name = $album->artist_name;
?>
<div class="vg_album">
	<div><img width="100%" style="margin: 0;" class="detail" src="<?php echo $radioAvatar; ?>" alt="chi tiết album" /></div>
	<div style="padding: 0 5px;">
	<h3 class="name"><?php echo WapCommonFunctions::substring($album->name, ' ', 6);?></h3>
	<p class="artist"><?php echo WapCommonFunctions::substring($artist_name, ' ', 6) ?></p>
	</div>
</div>
<?php
$this->widget ( 'application.widgets.touch.player.ListPlayer', array (
		'album' => $album,
		'songs'=>$songsOfAlbum
) );
?>
<div class="box_bxh horo">
    <div class="header_box">
		<h2 class="title">Cá tính âm nhạc khác</h2>
    </div>
    <div class="content_box">
        <ul class="more_alb">
            <?php
            foreach ($radioListOther as $value ):
                $avatar = RadioModel::model()->getAvatarUrl($value['id'],'s1');
            	$link = Yii::app()->createUrl('/personality/view', array('id'=>$value['id'], 'url_key'=>Common::url_friendly($value['name'])));
            	
                ?>
                <li class="col-md-4 col-md-2">
                	<div style="padding: 5px 5px 15px 5px">
                    <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($value['name']); ?>">
                    <img width="100%" src="<?php echo $avatar; ?>" alt="<?php echo CHtml::encode($value['name']); ?>" /></a>
                    <h3><a href="<?php echo $link;?>" title="<?php echo $value['name'];?>" class="subtext"><?php echo CHtml::encode($value['name']);?></a></h3>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>