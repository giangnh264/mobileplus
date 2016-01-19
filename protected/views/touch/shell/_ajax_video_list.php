<?php if($videos):?>
<?php
foreach ( $videos as $video) :
	$link = Yii::app ()->createUrl ( 'video/view', array (
			'id' => $video->id,
			'url_key' => Common::makeFriendlyUrl ( $video->name ),
			"artist"=>Common::makeFriendlyUrl(trim($video->artist_name))
	) );
	$name = explode("-", $video['name']);
	?>

<li class="item">
			<?php
	 	$avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video->id), 'avatar', array('class' => 'video-avatar','align'=>'left'));
	 	?>
	<a href="<?php echo $link;?>">
		<?php echo $avatarImage;?>
		<h3><?php echo Formatter::smartCut(CHtml::encode($video['name']), Yii::app()->params['limit_substring_title'], 0)?></h3>
		<ul class="info"><li>
		        	<?php
						/* $artists = explode(',', $video->artist_name);
                        $count = count($artists);
                        $i = 1;
                        $artist_name="";
                        foreach ($artists as $artist) {
                        	$artist = trim($artist);
                            $artist_name .= $artist;
                            if ($i < $count)
                            	$artist_name .= "&nbsp;-&nbsp;";
                            $i++;
                        } */
                        echo Formatter::smartCut($video['artist_name'], Yii::app()->params['limit_substring'], 0);
                    ?>
		        </li>
		</ul>
	</a>
</li>

<?php endforeach;?>
<?php else:?>
<div>Không tìm thấy video nào!</div>
<?php endif;?>