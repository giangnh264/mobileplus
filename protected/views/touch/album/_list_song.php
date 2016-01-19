<!-- list song -->
<div class="box-content clear album-player">
    <ul class="song_list items-list" id="listSong">
        <?php
        $i=0;
        foreach($songsOfAlbum as $key => $song):
            $artist_name = Common::makeFriendlyUrl($song->artist_name);
            $link = Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
            $i++;
            ?>
            <li class="item item-in-list song-item-<?php echo ($i-1) ?>" id="item-<?php echo ($i-1) ?>">
                <a href="javascript:void(0)"> <span class="fll album_number"><?php echo $i;?></span>
                    <h3><?php echo CHtml::encode($song->name)?></h3>
                    <?php if(!empty($song->artist_name)):?>
                        <ul class="info">
                            <li><?php echo CHtml::encode($song->artist_name)?></li>
                        </ul>
                    <?php endif;?>
                </a>
                <div id="lyric-<?php echo $song->id ?>" style="display: none;">
                    <?php
                    if(isset($song->song_extra) && $song->song_extra->lyrics!=""){
                        $p = new CHtmlPurifier();
                        $p->options = array('HTML.ForbiddenElements' => array('p', 'span','a','script'));
                        $content = $p->purify($song->song_extra->lyrics);
                        $lyric = nl2br($content);
                    }else{
                        $lyric = Yii::t("wap","Lyric Updating");
                    }
                    ?>
                    <?php  echo $lyric; ?>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
</div>