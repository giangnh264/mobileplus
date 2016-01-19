<div class="box_title pt20">
	<h2 class="name"><a href="<?php echo $this->link;?>"><?php echo $pageTitle;?></a></h2>
</div>
<div class="box_content">
	<ul class="list_playlist">
		<?php if ($playlists):
			$i=0;
			foreach ($playlists as $item):
				$link = Yii::app()->createUrl("/playlist/view",array("id"=>$item->id,"title"=>$item->url_key));
				$titleLink = $altImg = CHtml::encode($item->name);
				?>
				<li class="<?php if($i%4 == 3) echo 'marr_0'; else echo '';?>">
					<a href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("user", $item->user_id,200)?>" alt="<?php echo $altImg; ?>"/></a>
					<div class="info" >
						<h3 class="name over-text" style="color: #fff"><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->name);?>"><?php echo CHtml::encode($item->name);?></a></h3>
						<?php /*<p class="singer over-text"><a href="<?php echo $linkArtist;?>" title="<?php echo $titleLink; ?>"><?php echo CHtml::encode($item->artist_name); ?></a></p> */?>
					</div>
				</li>
				<?php
				$i++;
			endforeach;?>
		<?php else:?>
			<p class="pt10"><?php echo Yii::t("web", "Not found anything!"); ?></p>
		<?php endif; ?>
	</ul>
</div>

