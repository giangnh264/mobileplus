<div class="box_title clb">
    <h2 class="name font20"><?php echo $title;?></h2>
</div>

<div class="content_box">
    <ul class="more_alb">
        <?php
        $max = min(count($topContents), $limit);

        for ($i = 0; $i < $max; $i++):

            $contentItem = $topContents[$i];
            if($contentItem->type == 'album')
                $item = WebAlbumModel::model()->findByPk($contentItem->content_id);
            elseif($contentItem->type == 'video_playlist')
                $item = VideoPlaylistModel::model()->findByPk($contentItem->content_id);
            ?>

            <?php if(isset($item)):
                $urlKey = ($item->url_key)?$item->url_key:Common::makeFriendlyUrl(trim($item->name));
                $link = Yii::app()->createUrl("topContent/view", array("id" => $contentItem->id, "title" => $urlKey));
                if($contentItem->type == 'album'){
                    $linkArtist = Yii::app()->createUrl("artist/view", array("id" => $item->artist_id, 'title'=>Common::makeFriendlyUrl(trim($item->artist_name))));
                    $avatarSrc = TopContentModel::model()->getAvatarUrl($contentItem->id, $size="300");
//                    $avatarSrc = AvatarHelper::getAvatar($contentItem->type, $item->id, 300);
                    $avatarAlt = CHtml::encode($item->name).' - '.CHtml::encode($item->artist_name);
                }elseif($contentItem->type == 'video_playlist'){
                    if ($contentItem->id > 0) {
                        $avatarSrc = AvatarHelper::getAvatar("videoPlaylist", $contentItem->id ? $contentItem->id:0, 300);
                    } else {
                        $avatarSrc = '/images/avatar-default.png';
                    }
                    $avatarAlt = CHtml::encode($item->name);
                }
                ?>
                <?php if($topContent->content_id != $item->id):?>
                    <li class="top_content pt20">
                        <a href="<?php echo $link;?>" title="<?php echo CHtml::encode($item->name).' - '.CHtml::encode($item->artist_name); ?>">
                            <img style="width: 300px; height: 110px;" src="<?php echo $avatarSrc; ?>" alt="" />
                        </a>
                        <h3><a href="<?php echo $link;?>" class="top_content_name" title="<?php echo $item->name;?>"><?php echo Formatter::substring($item->name, " ", 7, 30);?></a></h3>
                        <?php if($contentItem->type == 'album'):?>
                            <h4 class="aritis"><a  class="top_content_artist" href="<?php echo $linkArtist;?>"><?php echo $item->artist_name;?></a></h4>
                        <?php endif;?>
                    </li>
            <?php endif;?>
            <?php endif;?>
        <?php endfor; ?>
    </ul>
</div>
