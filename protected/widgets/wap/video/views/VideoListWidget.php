<?php if($type=='api'):?>
<table class="videolist tablelist">
<?php
$params = "";
$i = 0;
foreach ($videos as $video):
if($i>=3) break;
$params = (!empty($video->source))?$video->source->params:"";
$i++
 ?>
  <tr>
    <td width="100px"><img src="<?php echo $video->thumb_url ?>" class="avatar" alt="avatar" /></td>
    <td class="itemwrap" onclick="">
            <p class="m0 fontB vapi">
                <a href="<?php echo $video->link?>" target="_blank" ><?php echo WapCommonFunctions::substring($video->title, ' ', 9);//$video->title ?></a>
            </p>
            <img class="statistic_icon" src="<?php echo Yii::app()->request->baseUrl?>/css/wap/images/new/xem.png">
            <?php echo $video->total_download?>
         </td>
  </tr>
  <?php endforeach;?>
</table>
<?php
	$params = json_decode($params,true);
	if(!empty($params) && isset($params['viewmore'])){
		echo "<a class='vg_more flr cl6' href='{$params['viewmore']}' target='_blank'>Xem thêm &raquo;</a>";
	}
?>


<?php else:?>


<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padB5 color-256DBA fs_15"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' video') ?></div>
<?php endif;?>
<table class="videolist tablelist">
    <?php
    $currentPage = Yii::app()->request->getParam('pv', 1);
    $number = ($currentPage - 1) * yii::app()->params['pageSize'] + 1;
    foreach ($videos as $video) :
	$videoLink = yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name)));
    if(isset($options['col'])&&$options['col'])
        $videoLink = yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name)));
    if(isset($options['display_type']) && $options['display_type'] == 'VIDEO_COLLECTION')
    	$videoLink = yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name), 'src' => $options['display_type']));
    if(isset($options['display_type']) && $options['display_type'] == 'VIDEO_PLAYLIST')
    	$videoLink = yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name), 'src' => $options['display_type'], 'playlist' => $options['videoPlaylistId']));
	if ($video->id) {
            $avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video->id), 'avatar', array('class' => 'avatar'));
        } else {
            $avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
        }
	?>
	<tr><td width="100px" onclick="document.location = '<?php echo $videoLink ?>'">
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

        <td class="itemwrap" onclick="document.location = '<?php echo $videoLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $videoLink ?>"><?php echo WapCommonFunctions::substring($video->name, ' ', 6);?></a>
            </p>

            <p class="m0 artistname">
                <?php
                $j=0;
                $artistList = explode(",", $video->artist_object);
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
    	<div class="bl_title  padT5 padB5 color-256DBA"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' video') ?></div>
    </div>
<?php endif;?>

<?php
$action = Yii::app()->controller->getAction()->getId();
$controller = Yii::app()->controller->getId();
$layout=Yii::app()->controller->deviceLayout;
if ($type == "homepage" || $type == "noavatar"):
    if($videos && count($videos) > 0):
        if (empty($link))
            $link = "video";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        if($controller=='video' && $action=='index' && $layout=='default' && (isset($options['col'])&&$options['col']&&$options['col']!='VIDEO_COLLECTION')){
            $link .="?page=2";
        }

        $link = Yii::app()->params['base_url']. $link;
        echo  "<a class='vg_more flr cl6' href='$link' >Xem thêm &raquo;</a>";
    endif;
elseif ($type == "bxh"):
    $currentS = Yii::app()->request->getParam('ps', '');
    $currentS = htmlentities($currentS);
    if (!empty($currentS))
        $link = '?ps=' . $currentS . '&';
    else
        $link = '?';
    ?>
<?php else: ?>
    <div class="padding clb <?php echo ($type=="ajax_paging")?"ajax_paging":""; ?>" data-link="<?php echo ($link)?$link:""?>">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $videoPages, 'current_paging' => $current_paging));
            ?>
        </center>
    </div>
<?php endif; ?>
<?php endif; ?>