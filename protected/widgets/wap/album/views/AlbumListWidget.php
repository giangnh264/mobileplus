
<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padB5 color-256DBA fs_15"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' album') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php
    if(isset($albumPages)) $number = $albumPages->getCurrentPage() * yii::app()->params['pageSize'] + 1;
    else $number = 1;
    foreach ($albums as $album) :
	$albumLink = yii::app()->createUrl('album/view', array('id' => $album->id, 'url_key' => Common::makeFriendlyUrl($album->name)));
    if(isset($options['col'])&&$options['col'])
        $albumLink = yii::app()->createUrl('album/view', array('id' => $album->id, 'url_key' => Common::makeFriendlyUrl($album->name), 'src'=>"{$options['col']}"));
	if ($album->id) {
		$avatarImage = CHtml::image(WapAlbumModel::model()->getThumbnailUrl(50, $album->id), 'avatar', array('class' => 'avatar'));
	} else {
		$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
	}
	?>
	<tr><td width="65px" onclick="document.location = '<?php echo $albumLink ?>'">
				<?php
			if ($type != "bxh")
				echo $avatarImage;
			else {
				if ($number < 4)
					$top = 'mv_top';
				else
					$top = '';
				echo '<div class="img_mv ' . $top . '">' . $avatarImage.'<span>'.$number++ . '</span></div>';
			}
			?>
		</td>
        <td class="itemwrap" onclick="document.location = '<?php echo $albumLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $albumLink ?>"><?php echo WapCommonFunctions::substring($album->name, ' ', 6);?></a>
            </p>

            <p class="m0 artistname">
                <?php
                $j=0;
                $artistList = explode(",", $album->artist_object);
                foreach ($artistList as $item):
                    $artists = explode("|", $item);
                    $urlKey =  Common::makeFriendlyUrl(trim($artists[1]));
                    $artistLink = Yii::app()->createUrl("artist/view", array("id" => $artists[0], "title" => $urlKey));
                    $artist_name = trim($artists[1]);
                    ?>
                    <a href="<?php echo $artistLink;?>"><?php  echo WapCommonFunctions::substring($artist_name, ' ', 6);?></a>
                    <?php if(count($artistList)>1 && $j<(count($artistList)-1)) echo ",";?>
                    <?php $j++;?>
                <?php endforeach;?>
            </p>
        </td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif;?>

<?php if (($numFound <= 0 && $objType == 'search')) : ?>
    <div class="borderTop">
        <div class="whiteline"></div>
    	<div class="bl_title padT5 padB5 color-256DBA"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' album') ?></div>
    </div>
<?php endif;?>

<?php
$action = Yii::app()->controller->getAction()->getId();
$controller = Yii::app()->controller->getId();
$layout=Yii::app()->controller->deviceLayout;
if ($type == "homepage" || $type == "noavatar"):
    if($albums && count($albums) > 0):
        if (empty($link))
            $link = "album";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        if($controller=='album' && $action=='index' && $layout=='default'){
        	$link .="?page=2";
        }
        $link = Yii::app()->params['base_url']. $link;
        echo "<a class='vg_more flr cl6' href='$link' >Xem thêm &raquo;</a>";
    endif;
else:?>
    <div class="padding clb <?php echo ($type=="ajax_paging")?"ajax_paging":""; ?>" data-link="<?php echo ($link)?$link:""?>">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $albumPages, 'current_paging' => $current_paging));
            ?>
        </center>
    </div>
<?php endif; ?>