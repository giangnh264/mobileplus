<ul class="list_bxh ovh" style="border-bottom: none;">
<?php
if ($data) :?>
<li>
	<div style="overflow: hidden;margin-bottom: 5px;">
	<a href="<?php echo Yii::app()->createUrl("collection/view",array("id"=>$collection->id,"title"=>Common::makeFriendlyUrl(CHtml::encode($collection->name)))); ?>" class="play_all"><span>playall</span></a>
	</div>
</li>
<?php	$i=1;
	foreach($data as $song):
	$urlKey = ($song->url_key)?$song->url_key:Common::makeFriendlyUrl($song->name);
	$link = Yii::app()->createUrl("song/view",array("id"=>$song->id,'title'=>trim($urlKey,"-")));
	?>
	<?php if($i==1):?>
		<li>
			<div class="chart-index chart-1st"><b>1</b></div>
			<div class="chart-content-1st">
				<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($song->name) . ' - ' . CHtml::encode($song->artist_name); ?>">
					<img width="50" src="<?php echo AvatarHelper::getAvatar("artist", $song->song_artist[0]->artist_id, 150)?>" alt="<?php echo CHtml::encode($song->name) . ' - ' . CHtml::encode($song->artist_name); ?>" />
				</a>
				<h3>
					<a href="<?php echo $link ?>" class="song_name"  title="<?php echo CHtml::encode($song->name)?>">
		                    <?php echo Formatter::smartCut(CHtml::encode($song->name), 13);?>
		             </a>
		        </h3>
		        <p class="song_aritis"><?php echo CHtml::encode($song->artist_name)?></p>
	        </div>
		</li>
	<?php else:?>
		<li class="padt10">
			<div class="chart-index chart-more">
				<?php echo ($i < 10) ? ' 0'.$i.'.' : ' '.$i.'.'; ?>
			</div>
			<div class="chart-content">
				<h3><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($song->name)?>">
	                <b><?php echo  Formatter::smartCut(CHtml::encode($song->name),20)?></b></a>
	            </h3>
				<span title="<?php echo CHtml::encode($song->artist_name) ?>">
					<?php echo Formatter::smartCut(CHtml::encode($song->artist_name), 25); ?>
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