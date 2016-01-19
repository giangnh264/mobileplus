<?php
$pager = $total_results['videoplaylist']['pages'];
$videos = $total_results['videoplaylist']['results'];
?>

<?php if($videos):?>
<?php
foreach ( $videos as $video) :
	$link = Yii::app ()->createUrl ( 'videoPlaylist/view', array (
			'id' => $video['id'],
			'url_key' => Common::makeFriendlyUrl ( $video['name'] )
	) );
        if(isset($options['col'])&&$options['col']){
            $link = Yii::app ()->createUrl ( 'videoPlaylist/view', array (
                'id' => $video['id'],
                'url_key' => Common::makeFriendlyUrl ($video['name']),
                'src'=>$options['col']
            ) );
        }
        $avatarImage = CHtml::image(WapVideoPlaylistModel::model()->getThumbnailUrl(100, $video['id']), 'avatar', array('class' => 'avatar'));
	?>

<li class="item">
			<a href="<?php echo $link ?>">
				<?php echo $avatarImage;?>
				<h3><?php echo Formatter::smartCut($video['name'], 50, 0);?></h3>
    			<ul class="info"><li><?php echo Formatter::smartCut($video['artist_name'], Yii::app()->params['limit_substring'], 0);?></li></ul>
			</a>
		</li>

<?php endforeach;?>
<?php else:?>
<li><?php echo Yii::t("wap","Video playlist not found");?></li>
<?php endif;?>