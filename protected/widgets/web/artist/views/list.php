    <ul class="list_artist">
        <?php
        $i = 0;
        foreach ($this->artists as $artist):
        	if ($artist->id != $this->exclusion) :
            $urlKey = ($artist->url_key) ? $artist->url_key : Common::makeFriendlyUrl(trim($artist->name));
            $link = Yii::app()->createUrl("artist/view", array("id" => $artist->id, "title" => $urlKey));
            $user_id = (Yii::app()->user->isGuest) ? 0: Yii::app()->user->getId();
            $isArtistLiked = WebArtistFanModel::model()->isLiked($user_id, $artist->id);
            $songIds = explode(",", $artist->song_ids,5);
            ?>

            <li class="sitem">
                <a href="<?php echo $link ?>" title="<?php echo $artist->name ?>">
                    <img src="<?php echo AvatarHelper::getAvatar("artist", $artist->id, 200); ?>" alt="<?php echo $artist->name ?>" width="130" height="130" />
                </a>
                <h2>
                    <a href="<?php echo $link ?>" title="<?php echo $artist->name; ?>"><?php echo $artist->name; ?></a>
                </h2>
                <p>
                    <?php echo Formatter::substring(strip_tags($artist->description), " ", 40, 200); ?>
                </p>

                <ul class="songaritis song_artist ovh" id="songForArtistInfo_<?php echo $artist->id;?>">
                <?php $i=0;
                foreach($songIds as $song){
                	if($i>=4) break;
                	echo '<li class="song_artist_'.$song.'"></li>';
                	$i++;
                }
                ?>
                </ul>
            </li>
            <?php
            $i++;
            endif;
        endforeach;
        ?>
    </ul>
<?php
if($this->type != 'search'): ?>
    <input type="hidden" id="artist_ids" value="<?php echo $this->artistIds;?>"/>
<?php endif;?>