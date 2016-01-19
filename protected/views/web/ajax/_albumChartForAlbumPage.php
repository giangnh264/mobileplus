<ul class="list_bxh ovh" style="border-bottom: none;">
<?php
if ($data) :
	$i=1;
	foreach($data as $album):
	$urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl($album->name);
	$link = Yii::app()->createUrl("album/view",array("id"=>$album->id,'title'=>trim($urlKey,"-"), "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
	?>
	<?php if($i==1):?>
		<li>
			<div class="chart-index chart-1st"><b>1</b></div>
			<div class="chart-content-1st">
				<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name) . ' - ' . CHtml::encode($album->artist_name); ?>">
					<img width="50" src="<?php echo AvatarHelper::getAvatar("album", $album->id, 150)?>" alt="<?php echo CHtml::encode($album->name) . ' - ' . CHtml::encode($album->artist_name); ?>" />
				</a>
				<h3>
					<a href="<?php echo $link ?>" class="song_name"  title="<?php echo CHtml::encode($album->name)?>">
		                    <?php echo Formatter::smartCut(CHtml::encode($album->name), 17);?>
		             </a>
		        </h3>
		        <p class="song_aritis"><?php echo Formatter::smartCut(CHtml::encode($album->artist_name), 13); ?></p>
	        </div>
		</li>
	<?php else:?>
		<li class="padt10">
			<div class="chart-index chart-more">
				<?php echo ($i < 10) ? ' 0'.$i.'.' : ' '.$i.'.'; ?>
			</div>
			<div class="chart-content">
				<h3><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name)?>">
	                <b><?php echo Formatter::smartCut(CHtml::encode($album->name), 25) ?></b></a>
	            </h3>
				<span title="<?php echo CHtml::encode($album->artist_name) ?>">
					<?php echo Formatter::smartCut(CHtml::encode($album->artist_name), 25); ?>
	            </span>
	        </div>
		</li>
	<?php endif;?>
	<?php $i++;endforeach;?>
	</ul>
<?php
else :
	echo 'Dữ liệu đang cập nhật...';
endif; 
?>