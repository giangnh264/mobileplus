<?php if(count($this->albums) > 0):?>

<?php if($this->option == 'box'):?>
    <?php if(!empty($this->pageTitle)):?>
		<div class="header_box">
			<h2 class="title vertical_align"><?php echo $this->pageTitle; ?></h2>&nbsp;&nbsp;&nbsp;
		</div>
    <?php endif;?>
<?php else:?>
    <div class="header_box">
        <h1 class="title"><?php echo $this->pageTitle;?></h1>
    </div>
<?php endif;?>
    <div class="content_box">
        <ul class="<?php echo ($this->option == 'box') ? (($this->itemInRow != 4) ? 'list_album artist_alb' : 'list_album album_page') : 'list_albums';?>" >
            <?php
            $i = 1;
            foreach ($this->albums as $album):
                $urlKey = isset($album->url_key) ? $album->url_key : Common::makeFriendlyUrl(trim($album->name));
                $link = Yii::app()->createUrl("album/view", array("id" => $album->id, "title" => $urlKey, "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))));
                if(isset($this->artist)){
                    $urlKey = ($this->artist->url_key) ? $this->artist->url_key : Common::makeFriendlyUrl(trim($this->artist->name));
                    $linkArtist = Yii::app()->createUrl("artist/view", array("id" => $this->artist->id, "title" => $urlKey));
                }
                else
                    $linkArtist = '#';
                
            ?>
                <li class="<?php if($i>0 &&  ($i % $this->itemInRow == 0)) echo 'marr_0'; if($i>0 &&  ($i % $this->itemInRow == 1)) echo ' clb'; ?>" style="<?php echo ($this->option == 'albumPage') ? 'margin-right: 10px' : ''; ?>">
                    <a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>">
                        <img src="<?php echo AvatarHelper::getAvatar("album", $album->id, 200) ?>" alt="<?php echo CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name); ?>" />
                    </a>
                    <div class="info">
                        <h3 class="alb_name">
                            <a href="<?php echo $link ?>" title="<?php echo $album->name;?>">
                            	<?php if($this->option == 'box'):?>
                            		<?php echo Formatter::substring($album->name, " ", 6, 14); ?>
                            	<?php else:?>
                            		<?php echo $album->name; ?>
                            	<?php endif;?>
                            </a>
                        </h3>
                        <h4 class="alb_aritis fs11 padt2">
                            <?php if($this->option == 'box'):?>
                                <a href="<?php echo $linkArtist;?>"><?php echo Formatter::substring($album->artist_name, " ", 6, 14); ?></a>
                            <?php else:?>
                            	<a href='<?php echo Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode($album->artist_name)));?>'>
                                	<?php echo Formatter::substring($album->artist_name, " ", 6, 20); ?>
                                </a>
                            <?php endif;?>
                        </h4>
                    </div>
                </li>
                <?php $i++;
            endforeach;
            ?>
        </ul>
    </div>
    <div class="readmore">
    	<a class="gray_color" style="float: right" href='<?php echo $this->moreLink?>' >
			<span class="vertical_align gray_color" ><?php echo Yii::t('web', 'More');?> <i class="icon icon_mt"></i></span>
		</a>
    </div>
<?php endif;?>