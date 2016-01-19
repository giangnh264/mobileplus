<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padL10 padT5 padB5 fontB"><?php echo yii::t('chachawap', 'Tìm thấy ') . $numFound . yii::t('chachawap', ' nhạc chờ') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php
    foreach ($ringbacktones as $rbt) :
	if(!empty($rbt->rbt_id))
		$id = $rbt->rbt_id;
	else
		$id = $rbt->id;
	if (!empty($rbt->rbt))
		$rbt = $rbt->rbt;
	$rbtLink = yii::app()->createUrl('ringbacktone/view', array('id' => $id, 'url_key' => Common::makeFriendlyUrl($rbt->name)));
	$avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(50, $rbt->artist_id), 'avatar', array('class' => 'avatar'));
	?>
	<tr><td width="65px">
            <?php if ($type != "noavatar"):
                    echo $avatarImage;
			endif; ?>
		</td>
        <td class="itemwrap" onclick="document.location = '<?php echo $rbtLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $rbtLink ?>"><?php echo WapCommonFunctions::substring($rbt->name, ' ', 6);?></a>
            </p>

            <p class="m0 artistname">
                   <span><?php
                   if ($objType == 'search')
                        echo WapCommonFunctions::substring($rbt->artist, ' ', 6);
                    else
                        echo WapCommonFunctions::substring($rbt->artist_name, ' ', 6);
                    ?></span>
            <img class="statistic_icon" alt="nghe" src="/css/wap/images/new/nghe.png">
            <?php
                if ($objType == 'search'){
                    echo isset($rbt->downloaded_count)?$rbt->downloaded_count:0;
                }else{
                    if (isset($rbt->rbt_statistic[0]))
                        $rbt->rbt_statistic = $rbt->rbt_statistic[0];
                    if (isset($rbt->rbt_statistic) && !empty($rbt->rbt_statistic->downloaded_count)) {
                        echo $rbt->rbt_statistic->downloaded_count;
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
        <div class="padL10 padB10 smallText fontB clb"><?php echo yii::t('chachawap', 'Không tìm thấy nhạc chờ nào với từ khóa "' . $keyword . '". Xin vui lòng thử lại với từ khóa khác.') ?></div>
    </div>
<?php endif;?>
<?php
if ($type == "homepage" || $type == "noavatar"):
    if($ringbacktones && count($ringbacktones) > 0):
        if (empty($link))
            $link = "ringbacktone";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        echo "<a class='vg_more flr cl6' href='/$link' >Xem thêm &raquo;</a>";
    endif;
else:
    ?>
    <div class="padding clb">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $ringbacktonePages));

            ?>
        </center>
    </div>
<?php
endif;
?>