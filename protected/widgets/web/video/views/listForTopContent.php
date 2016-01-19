<?php if(count($this->datas) > 0):?>
<div class="box_album">
	<div class="box_title">
		<h2 class="name"><?php echo $this->pageTitle;?></h2>
	</div>
    <div class="box_content">
		<ul class="list_video">
			<?php
			$i = 0;
			foreach ( $this->datas as $item) :
				if (isset($item->videoInfo) && isset($this->topContent) && ($item->videoInfo->id != $this->detailId)):
					$urlKey = Common::makeFriendlyUrl(trim($this->topContent->name));
					$link = Yii::app()->createUrl("topContent/view", array("id" => $this->topContent->id, "title" => $urlKey, "ex_id"=>$item->videoInfo->id));

					?>
				<li>
					<a href="<?php echo $link ?>"
					title="<?php echo CHtml::encode($item->videoInfo->name) . ' - ' . CHtml::encode($item->videoInfo->artist_name); ?>"> <img
						src="<?php echo AvatarHelper::getAvatar("video", $item->videoInfo->id,200)?>"
						alt="<?php echo CHtml::encode($item->videoInfo->name) . ' - ' . CHtml::encode($item->videoInfo->artist_name); ?>" />
					</a>
					<div class="info">
						<h3 class="name over-text">
							<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->videoInfo->name)?>"><?php echo CHtml::encode($item->videoInfo->name); ?></a>
						</h3>
						<p class="singer over-text">
							<a href='<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>$item->videoInfo->artist_name));?>' title="<?php echo $item->videoInfo->artist_name ?>">
							<?php echo CHtml::encode($item->videoInfo->artist_name); ?></a>
						</p>
					</div>
				</li>
				<?php
					$i ++;
				endif;
			endforeach;?>
		</ul>
    </div>
</div>
<?php endif; ?>