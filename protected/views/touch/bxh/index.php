<?php 
$this->renderPartial('/ajax/_filter_nav', array(
	'route'=>'/bxh/index',
	'cTitle'=>$cTitle,
	'sTitle'=>$sTitle,
	'c'	=>$c,
	's'	=>$s,
	'type'	=>'bxh',
	'type2'	=>'bxh_status'
));
?>
<input type="hidden" class="total-page"
	value="<?php echo $pager->getPageCount() ?>" />
<input type="hidden" class="curent-page"
	value="<?php echo ($pager->getCurrentPage() + 1)?>" />
<input type="hidden" class="curent-link"
	value="<?php echo $callBackLink ?>">

<div class=" clb">
    <div class="bl_item">
    <?php if ($s == 'SONG')
        $this->widget ( 'application.widgets.touch.bxh.SongList', array ('songs' => $topWeek, 'options'=>$options));
        ?>
        <?php if ($s == "VIDEO")
    $this->widget ( 'application.widgets.touch.bxh.VideoList', array ('videos' => $topWeek, 'options'=>$options) );
    ?>
    <?php if ($s == "ALBUM")
    $this->widget('application.widgets.touch.bxh.AlbumListWidget',array('albums'=>$topWeek, 'options'=>$options));
    ?>
    </div>
</div>
