<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padL10 padT5 padB5 fontB"><?php echo yii::t('chachawap', 'Tìm thấy ') . $numFound . yii::t('chachawap', ' nhạc chuông') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php
    foreach ($ringtones as $ringtone) :
		if (!empty($ringtone->ringtone))
            $ringtone = $ringtone->ringtone;
        $ringtoneLink = yii::app()->createUrl('ringtone/view', array('id' => $ringtone->id, 'url_key' => Common::makeFriendlyUrl($ringtone->name)));
        $avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(50, $ringtone->artist_id), 'avatar', array('class' => 'avatar'));
	?>
	<tr><td width="65px">
            <?php if ($type != "noavatar"):
                    echo $avatarImage;
			endif; ?>
		</td>
        <td class="itemwrap" onclick="document.location = '<?php echo $ringtoneLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $ringtoneLink ?>"><?php echo WapCommonFunctions::substring($ringtone->name, ' ', 6);?></a>
            </p>

            <p class="m0 artistname">
                   <span><?php
                   if ($objType == 'search')
                        echo WapCommonFunctions::substring($ringtone->artist, ' ', 6);
                    else
                        echo WapCommonFunctions::substring($ringtone->artist_name, ' ', 6)
                           ?></span>
            <img class="statistic_icon" alt="nghe" src="/css/wap/images/new/nghe.png">
            <?php
                if ($objType == 'search'){
                    echo isset($ringtone->downloaded_count)?$ringtone->downloaded_count:0;
                }
                else{
                    if (isset($ringtone->ringtone_statistic[0]))
                        $ringtone->ringtone_statistic = $ringtone->ringtone_statistic[0];
                    if (isset($ringtone->ringtone_statistic) && !empty($ringtone->ringtone_statistic->downloaded_count)) {
                        echo $ringtone->ringtone_statistic->downloaded_count;
                    } else
                        echo "0";
                }
            ?>
            </p>
        </td>
    </tr>
	<?php endforeach ?>
</table>
<?php endif;?>

<?php if (($numFound <= 0 && $objType == 'search')) : ?>
    <div class="borderTop">
        <div class="whiteline"></div>
        <div class="padL10 padB10 smallText fontB clb"><?php echo yii::t('chachawap', 'Không tìm thấy nhạc chuông nào với từ khóa "' . $keyword . '". Xin vui lòng thử lại với từ khóa khác.') ?></div>
    </div>
<?php endif;?>
<?php
if ($type == "homepage" || $type == "noavatar"):
    if($ringtones && count($ringtones) > 0):
        if (empty($link))
            $link = "ringtone";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        echo "<a class='vg_more flr cl6' href='/$link' >Xem thêm &raquo;</a>";
    endif;
else:
    ?>
    <div class="padding clb">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $ringtonePages));

            ?>
        </center>
    </div>
<?php
endif;
?>