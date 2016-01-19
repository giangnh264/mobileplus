<?php
$artists = $total_results['artist']['results'];
?>

<?php if ($artists) : ?>
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
<?php endif;?>