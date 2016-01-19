<div>
    <div class="box_title">
        <h2 class="name fs20"><?php echo Yii::t('web', 'Related playlists'); ?></h2>
    </div>
    <div class="box_content">
        <ul class="bxh_album_list">
            <?php
            $max = min(count($videoplaylists), $limit);
            for ($i = 0; $i < $max; $i++):
                $mvPlaylistItem = $videoplaylists[$i];
                $urlKey = ($mvPlaylistItem->url_key) ? $mvPlaylistItem->url_key : Common::makeFriendlyUrl(trim($mvPlaylistItem->name));
                $link = Yii::app()->createUrl("videoplaylist/view", array("id" => $mvPlaylistItem->id, "title" => $urlKey));
                ?>
                <li>
                    <a href="<?php echo $link; ?>">
                        <img alt="<?php echo CHtml::encode($mvPlaylistItem->name); ?>" src="<?php echo VideoPlaylistModel::model()->getAvatarUrl($mvPlaylistItem->id, 300); ?>">
                    </a>
                    <h3 class="over-text"><a href="<?php echo $link; ?>"><?php echo CHtml::encode($mvPlaylistItem->name); ?></a></h3>
                    <p class="over-text"><a href="<?php echo $link; ?>"><?php echo CHtml::encode($mvPlaylistItem->artist_name); ?></a></p>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>