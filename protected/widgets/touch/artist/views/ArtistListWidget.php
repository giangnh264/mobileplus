<?php if ($artists) : ?>
<div class="ct_list_box">
	<ul class="artist_list items-list">
    <?php 
    $i=0;
    foreach ($artists as $artist) : 
    $i++;
    ?>
        <?php
            $artistLink = yii::app()->createUrl('artist/view', array('id' => $artist['id'], 'url_key' => Common::makeFriendlyUrl($artist['name'])));
            if ($artist['id'])
            {
                $avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl('s4', $artist['id']), 'avatar', array('class' => 'avatar', 'width'=>'82'));
            }
            else
            {
                $avatarImage = CHtml::image('/css/wap/images/icon/artist-50.png', 'avatar', array('class' =>'avatar'));
            }
        ?>
			<li class="item <?php if($i==count($artists)) echo 'last_item';?>">
				<a href="<?php echo $artistLink ?>"><?php echo $avatarImage ?>
                            <h3 class="subtext"><?php echo CHtml::encode($artist['name']) ?></h3>
                            <ul class="info">
                            <li>
                                <div><?php echo (isset($artist['song_count'])?$artist['song_count']:0) . yii::t('chachawap', ' Bài hát') ?></div>                            
                                <div><?php echo (isset($artist['video_count'])?$artist['video_count']:0) . yii::t('chachawap', ' Video') ?></div>                           
                                <div><?php echo (isset($artist['album_count'])?$artist['album_count']:0) . yii::t('chachawap', ' Album') ?></div>                            
                            </li>
                            </ul>
				</a>
			</li>
    <?php endforeach ?>
</ul>
</div>
<?php endif;?>

<?php if (($numFound <= 0 && $objType == 'search')) : ?>
    <div class="borderTop">
        <div class="whiteline"></div>
        <div class="padL10 padB10 smallText fontB clb"><?php echo yii::t('chachawap', 'Không tìm thấy nghệ sĩ nào với từ khóa "' . $keyword . '". Xin vui lòng thử lại với từ khóa khác.') ?></div>
    </div>
<?php endif;?>
