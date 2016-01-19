<a title="Video Playlist" class="wrap-head mr-t-15" href="<?php echo Yii::app()->createUrl('/topContent');?>">
    <div class="head-label clearfix">
        <span class="text">Chủ đề âm nhạc</span>
        <span class="title"></span>
    </div><!-- End .head-label -->
</a>
<?php if($topContent):?>
    <div class="box_content">
        <ul class="collection_list items-list">
            <?php foreach($topContent as $item):
                if(isset($item) && $item['type'] == 'album'){
                    $albumInfo = AlbumModel::model()->findByPk($item['content_id']);
                    $artist_name = $albumInfo->artist_name;
                    $count = $albumInfo?count($albumInfo->song_count):0;
                }elseif(isset($item) && $item['type'] == 'video_playlist'){
                    $videoPlaylist = VideoPlaylistModel::model()->findByPk($item['content_id']);
                    $artist_name = $videoPlaylist->artist_name;
                    $count = $videoPlaylist?count($videoPlaylist->video_playlist_videos):0;
                }else
                    $count = 0;
                if($count > 0 && $item['id'] != 0):
                    $link = Yii::app()->createUrl("topContent/view",array("id"=>$item['id'],"title"=>Common::makeFriendlyUrl($item['name'])));
                    ?>
                    <?php if(isset($item)):?>

                    <li>
                        <a href="<?php echo $link ?>" class="a-top top-content-img">
                            <img \="" src="<?php echo TopContentModel::model()->getAvatarUrl($item['id']);?>">
                            <div class="hotlist-gradient"></div>
                            <div>
                                <p title="<?php echo CHtml::encode($item['name']);?>" href="<?php echo $link ?>" class="top-content-name"><?php echo $item['name'] ?></p>
                            </div>
                        </a>

                    </li>
                <?php endif;?>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>