<?php if (($numFound > 0 && $objType == 'search') || empty($objType)) : ?>
<?php if (($numFound > 0 && $objType == 'search')) : ?>
    <div class="bl_title padL10 padT5 padB5 fontB"><?php echo yii::t('wap', 'Tìm thấy ') . $numFound . yii::t('wap', ' video playlist') ?></div>
<?php endif;?>
<table class="tablelist">
    <?php
    
    if(isset($videoPlaylistPages)) $number = $videoPlaylistPages->getCurrentPage() * yii::app()->params['pageSize'] + 1;
    else $number = 1;
    foreach ($videoPlaylists as $videoPlaylist) :
		if ($videoPlaylist-> id != $exclude) :
		$videoPlaylistLink = yii::app()->createUrl('videoplaylist/view', array('id' => $videoPlaylist->id, 'url_key' => Common::makeFriendlyUrl($videoPlaylist->name)));
	    if(isset($options['col'])&&$options['col'])
	        $videoPlaylistLink = yii::app()->createUrl('videoplaylist/view', array('id' => $videoPlaylist->id, 'url_key' => Common::makeFriendlyUrl($videoPlaylist->name), 'src'=>"{$options['col']}"));
		if ($videoPlaylist->id) {
			$avatarImage = CHtml::image(WapVideoPlaylistModel::model()->getThumbnailUrl(50, $videoPlaylist->id), 'avatar', array('class' => 'avatar'));
		} else {
			$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
		}
		?>
		<tr><td width="65px" onclick="document.location = '<?php echo $videoPlaylistLink ?>'">
	            <?php
	            if ($type == "top")
	                echo '<div class="number alCenter fontB">' . $number++ . '</div>';
	            echo $avatarImage;
	            ?>
			</td>
	        <td class="itemwrap" onclick="document.location = '<?php echo $videoPlaylistLink ?>'">
	            <p class="m0 fontB">
	                <a href="<?php echo $videoPlaylistLink ?>"><?php echo WapCommonFunctions::substring($videoPlaylist->name, ' ', 6);?></a>
	            </p>
	
	            <p class="m0 artistname">
	            	<span>
	            	<?php $artistLink = yii::app()->createUrl('search/index', array('q' =>$videoPlaylist->artist_name));?>
	            		<a href="<?php echo $artistLink;?>"><?php echo CHtml::encode($videoPlaylist->artist_name); ?></a>
	            	</span>
	            </p>
	        </td>
		</tr>
	<?php
	 endif;
	 endforeach ?>
</table>
<?php endif;?>

<?php if (($numFound <= 0 && $objType == 'search')) : ?>
    <div class="borderTop">
        <div class="whiteline"></div>
        <div class="padL10 padB10 smallText fontB clb"><?php echo yii::t('wap', 'Không tìm thấy video playlist nào với từ khóa "' . $keyword . '". Xin vui lòng thử lại với từ khóa khác.') ?></div>
    </div>
<?php endif;?>

<?php
$action = Yii::app()->controller->getAction()->getId();
$controller = Yii::app()->controller->getId();
$layout=Yii::app()->controller->deviceLayout;
if ($type == "homepage"):
    if($videoPlaylists && count($videoPlaylists) > 0):
        if (empty($link)) $link = "videoPlaylist";
        $link = (substr($link, 0, 1) == "/")?substr($link, 1):$link;
        if($controller=='videoPlaylist' && $action=='index' && $layout=='default'){
        	$link .="?page=2";
        }
        $link = Yii::app()->createUrl("/$link");
        echo "<a class='vg_more flr cl6' href='$link' >Xem thêm &raquo;</a>";
    endif;
else:?>
    <div class="padding clb <?php echo ($type=="ajax_paging")?"ajax_paging":""; ?>" data-link="<?php echo ($link)?$link:""?>">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $videoPlaylistPages, 'current_paging' => $current_paging));
            ?>
        </center>
    </div>
<?php endif; ?>