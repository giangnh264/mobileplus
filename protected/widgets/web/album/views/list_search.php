<?php if(count($this->albums) > 0):?>

    <div class="header_box">
        <h2 class="title"><?php echo $this->pageTitle;?></h2>&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->moreLink?>" class="fs11"><?php echo Yii::t("web", "More"); ?><i class="icon icon_mt"></i></a>
    </div>
    <div class="content_box">
        <ul class="list_album ">
            <?php
            $i = 0;
            foreach ($this->albums as $album):
                $urlKey = isset($album->url_key) ? $album->url_key : Common::makeFriendlyUrl(trim($album->name));
                $link = Yii::app()->createUrl("album/view", array("id" => $album->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
                ?>

                <li>
					<a href="<?php echo $link ?>" title="<?php echo  CHtml::encode($album->name) . ' - ' . CHtml::encode($album->artist_name)?>">
						<img src="<?php echo AvatarHelper::getAvatar("album", $album->id,200)?>" width="160" alt="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>" />
					</a>
					<div class="info">
						<h3 class="alb_name"><a href="<?php echo $link ?>"><?php echo Formatter::substring($album->name, " ", 4, 18); ?></a></h3>
						<h4 class="alb_aritis"><a href='<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($album->artist_name)));?>'><?php echo Formatter::substring($album->artist_name, " ", 3, 35); ?></a></h4>
					</div>
				</li>
                <?php $i++;
            endforeach;
            ?>
        </ul>
    </div>
<?php endif;?>