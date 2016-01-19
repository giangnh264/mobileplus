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
		<h3 class="subtext"><?php echo CHtml::encode($video['name'])?></h3>
		<ul class="info subtext"><li>
		        	<?php
                        echo CHtml::encode($video['artist_name']);
                    ?>
		        </li>
		</ul>
	</a>
</li>

<?php endforeach;?>
<?php else:?>
<div class="pad-10"><?php echo Yii::t("wap","Video not found");?></div>
<?php endif;?>