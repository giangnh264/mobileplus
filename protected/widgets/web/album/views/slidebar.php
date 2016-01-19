<div class="box_title">
    <h2 class="name"><a href="<?php echo $this->link;?>"><?php echo $this->title;?></a></h2>
    <?php if(($this->type != 'artist') && !empty($this->type) && ($this->type != 'search')): ?>
    <div class="flr">
        <ul class="btn_ty">
            <li><a href="javascript:void(0)" class="pre load_album_new <?php echo (strtoupper($this->type)=="NEW")?" active":""?>"><?php echo Yii::t('web', 'New'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a href="javascript:void(0)" class="next load_album_hot <?php echo (strtoupper($this->type)=="HOT")?" active":""?>"><?php echo Yii::t('web', 'Hot'); ?></a></li>
        </ul>
    </div>
    <?php endif; ?>
</div>
<div class="box_content">
    <ul class="list_playlist">
        <?php if ($this->albumList):
        $i=0;
		foreach ($this->albumList as $album):
		    $urlKey = ($album->url_key)?$album->url_key:Common::makeFriendlyUrl(trim($album->name));
		    $link = Yii::app()->createUrl("album/view",array("id"=>$album->id,"title"=>Common::makeFriendlyUrl($urlKey), "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
            $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($album->artist_name)));
            $titleLink = $altImg = CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name);
		?>
            <li class="<?php if($i%4 == 3) echo 'marr_0'; else echo '';?>">
                <a href="<?php echo $link ?>"><img src="<?php echo AvatarHelper::getAvatar("album", $album->id,200)?>" alt="<?php echo $altImg; ?>"/></a>
                <div class="info">
                    <h3 class="name over-text"><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name);?>"><?php echo CHtml::encode($album->name);?></a></h3>
                    <p class="singer over-text">
                        <?php
                        $j=0;
                        $artistList = explode(",", $album->artist_object);
                        foreach ($artistList as $item):
                            $artists = explode("|", $item);
                            $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
                            $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
                            $artistName =trim($artists[1]);
                            ?>
                            <a href="<?php echo $artistLink;?>" title="<?php echo $artistName;?>"><?php echo $artistName;?>
                            </a>
                            <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                            <?php $j++;?>
                        <?php endforeach;?>
                    </p>
                </div>
                <a title="<?php echo CHtml::encode($album->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
            </li>
		<?php
        $i++;
        endforeach;?>
        <?php else:?>
        <p class="pt10"><?php echo Yii::t("web", "Not found anything!"); ?></p>
        <?php endif; ?>
    </ul>
</div>