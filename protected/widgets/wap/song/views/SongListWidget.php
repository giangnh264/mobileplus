<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padB5 color-256DBA fs_15 padT15"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' bài hát') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php
    $currentPage = Yii::app()->request->getParam('ps', 1);
    $number = ($currentPage - 1) * yii::app()->params['pageSize'] + 1;
    foreach ($songs as $song) :
    if($type != "auto_play_song"){
            $songLink = yii::app()->createUrl('song/view', array('id' => $song->id,'url_key' => Common::makeFriendlyUrl($song->name)));
    }
    else
        $songLink = yii::app()->createUrl('song/charge', array('id' => $song->id, 'autoplay' => 1,'action'=>'playSong'));

    if(isset($options['col'])&&$options['col']){
        if($type != "auto_play_song"){
            $songLink = yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'src'=>"{$options['col']}"));
        }
        else
            $songLink = yii::app()->createUrl('song/charging', array('id' => $song->id, 'autoplay' => 1, 'src'=>"{$options['col']}"));
    }
	$avatarImage = '<i class="icon_music"></i>';//CHtml::image('/css/wap/images/icon_song_40x40.pngdfgf', 'avatar', array('class' => 'avatar'));
	$width = ($type == "bxh")?"40px":"65px";
    ?>
	<tr height="55px"><td width="<?php echo $width;?>" onclick="document.location = '<?php echo $songLink ?>'">
            <?php
            if ($type != "bxh")
                echo $avatarImage;
            else {
                if ($number < 4)
                    $top = 'top';
                else
                    $top = '';
                echo '<div class="vg_number fontB ' . $top . '">' . $number++ . '</div>';
            }
            ?>
		</td>

        <td class="itemwrap" onclick="document.location = '<?php echo $songLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $songLink ?>"><?php echo WapCommonFunctions::substring($song->name, ' ', 6);?></a>
            </p>
            <p class="m0 artistname">
                <?php
                $j=0;
                $artistList = explode(",", $song->artist_object);
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
    	<div class="bl_title padT5 padB5 color-256DBA"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' bài hát') ?></div>
    </div>
<?php endif;?>

<?php
$action = Yii::app()->controller->getAction()->getId();
$controller = Yii::app()->controller->getId();
$layout=Yii::app()->controller->deviceLayout;
    if ($type == "homepage"):
        if($songs && count($songs) > 0):
            if (empty($link))
                $link = "song";
            if($controller=='song' && $action=='index'){
            	$link .="&page=2";
            }
            $link = Yii::app()->params['base_url'] . $link;
            echo "<a class='vg_more flr cl6' href='$link' >Xem thêm &raquo;</a>";
        endif;
    elseif ($type == "bxh"):
        $currentV = Yii::app()->request->getParam('pv', '');
        $currentV = htmlentities($currentV);
        if (!empty($currentV))
            $link = '?pv=' . $currentV . '&';
        else
            $link = '?';
        ?>

    <?php else: ?>
        <div class="padding clb <?php echo ($type=="ajax_paging")?"ajax_paging":""; ?>" data-link="<?php echo ($link)?$link:""?>">
            <center>
                <?php
                if($link=='song/hot'){
                	$current_paging=isset($_GET['page'])?$_GET['page']:1;
                }
                $this->widget('application.widgets.wap.common.Paging', array('pages' => $songPages, 'current_paging' => $current_paging));
                ?>
            </center>
        </div>
    <?php
    endif;
?>