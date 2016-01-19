<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padB5 color-256DBA fs_15"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' nghệ sĩ') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php $count = 1; $number = $artistPages->getCurrentPage() * yii::app()->params['pageSize'] + 1; ?>
    <?php foreach ($artists as $artist) : ?>
        <?php
            $artistLink = yii::app()->createUrl('artist/view', array('id' => $artist->id, 'url_key' => Common::makeFriendlyUrl($artist->name)));
            if ($artist->id)
            {
                $avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(50, $artist->id), 'avatar', array('class' => 'avatar'));
            }
            else
            {
                $avatarImage = CHtml::image('/css/wap/images/icon/artist-50.png', 'avatar', array('class' =>'avatar'));
            }
        ?>
                <tr>
                    <td style="width:60px"><a href="<?php echo $artistLink ?>"><?php echo $avatarImage ?></a></td>
                    <td>
                        <a href="<?php echo $artistLink ?>">
                            <div class="fontB padT10 padL10"><?php echo WapCommonFunctions::substring($artist->name, ' ', 6) ?></div>
                            <div class="subinfoText padB10 padL10">
                                <?php   echo (isset($artist->song_count)?$artist->song_count:0) . yii::t('wap', ' bài hát') ?>                            
                            </div>
                        </a>
                    </td>
                </tr>
    <?php endforeach ?>
</table>
<?php endif;?>

<?php if (($numFound <= 0 && $objType == 'search')) : ?>
    <div class="borderTop">
        <div class="whiteline"></div>
        <div class="bl_title padT5 padB5 color-256DBA"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' nghệ sĩ') ?></div>
    </div>
<?php endif;?>
<?php
if ($type == "homepage"):    
    if($artists && count($artists) > 0):
        if (empty($link))
            $link = "";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        if(Yii::app()->controller->id == "search"){
        	$link = "/".$link;
        }
        echo "<a class='vg_more flr cl6' href='$link' >Xem thêm &raquo;</a>";
        echo "    <div class='clb'></div>
    		";
    endif;
else:
    ?>
    <div class="padding clb">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $artistPages));
            
            ?>
        </center>
    </div>
<?php
endif;
?>