<?php
$pager = $total_results['clip']['pages'];
$videos = $total_results['clip']['results'];
?>

<?php if($videos):?>
<?php
foreach ( $videos as $video) :
	$link = Yii::app ()->createUrl ( 'video/view', array (
			'id' => $video['id'],
			'url_key' => Common::makeFriendlyUrl ( $video['name'] ),
			"artist"=>Common::makeFriendlyUrl(trim($video->artist_name))
	) );
	$name = explode("-", $video['name']);
	?>

<li class="item">
			<?php
	 	$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video['id']), 'avatar', array('class' => 'video-avatar','align'=>'left'));
	 	?>
	<a href="<?php echo $link;?>">
		<?php echo $avatarImage;?>
		<h3><?php echo CHtml::encode($video['name'])?></h3>
		<ul class="info"><li>
		        	<?php
						$artists = explode(',', $video['artist_name']);
                        $count = count($artists);
                        $i = 1;
                        foreach ($artists as $artist) {
                        	$artist = trim($artist);
                            echo $artist;
                            if ($i < $count)
                            	echo "&nbsp;-&nbsp;";
                            $i++;
                        }
                    ?>
		        </li>
		</ul>
	</a>
</li>

<?php endforeach;?>
<?php else:?>
<li><?php echo Yii::t("wap","Video not found");?></li>

<?php endif;?>