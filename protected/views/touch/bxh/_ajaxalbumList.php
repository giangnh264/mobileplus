<li class="li-spacer" id="<?php echo ($pager->getCurrentPage() + 1) ?>">
    <input type="hidden" class="curent-page"
           value="<?php echo ($pager->getCurrentPage() + 1) ?>">
</li>
<?php
$i = $limit * $pager->getCurrentPage();
foreach ($topWeek as $album) :
    $i++;
    $link = Yii::app()->createUrl('album/view', array(
        'id' => $album->id,
        'url_key' => Common::makeFriendlyUrl($album->name),
        "artist"=>Common::makeFriendlyUrl(trim($album->artist_name))
    ));

    $artist_name = WapArtistModel::model()->findByPk($album->artist_id)->name;
    $avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl('s1', $album->id), 'avatar', array(
                'class' => 'avatar'
    ));
    ?>
    <li data-corners="false" data-shadow="false" data-iconshadow="true"
        data-wrapperels="div" data-icon="arrow-r" data-iconpos="right"
        data-theme="d"
        class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-d">
        <div class="ui-btn-inner ui-li">
            <div class="ui-btn-text">
                <span class="xbh-count-album index"><?php echo $i; ?></span> <a
                    class="i-list ui-link-inherit" href="<?php echo $link ?>"> <span
                        class="i-thumb-bxh album-thumb">
                            <?php echo $avatarImage; ?>		
                    </span>
                    <p class="bxh ui-li-desc subtext subtext"><?php echo CHtml::encode($album->name) ?></p>
                    <span class="i-artist-bxh subtext subtext"><?php echo $album->artist_name ?></span>
                </a>
            </div>
            <span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
        </div>
    </li>
<?php endforeach; ?>