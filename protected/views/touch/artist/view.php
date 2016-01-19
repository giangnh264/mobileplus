<!-- dispaly artist detail page -->
<div class="artist_page pad-10 mgr-t-10">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td valign="top">
                <?php
                    if ($artist->id)
                    {
                        $avatarImage = CHtml::image(WapArtistModel::model()->getThumbnailUrl(75, $artist->id), 'avatar', array('width' => '75px', 'height' => '75px', 'class'=>'avatar'));
                    }
                    else
                    {
                        $avatarImage = CHtml::image('/css/wap/images/icon/artist-75.png', 'avatar', array('width' => '94px', 'height' => '94px'));
                    }
                    echo $avatarImage;
                ?>
            </td>
            <td valign="top">
            	<div class="ct-info" >
                    <h3><?php echo CHtml::encode($artist->name) ?></h3>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="cvartist">
	<div id="cvct"><?php if(empty($artist->description)) echo Yii::t("wap",'Updating'); else echo $artist->description;?></div>
	<div class="viewcv" style="text-align: center;cursor: pointer;"><span><?php echo Yii::t("wap","Xem tiểu sử");?></span> <i><img src="<?php echo Yii::app()->request->baseUrl?>/touch/images/down.png" /></i></div>
</div>
<?php if(isset($result['song']) && count($result['song'])>0):?>
<div class="item-box-content">
    <a href='<?php echo Yii::app()->createUrl('/song/artistList', array('artist_id'=>$artist->id))?>' class='wrap-head mr-t-15' title='Bài hát'>
        <div class='head-label clearfix'>
            <span class='text'>Bài hát</span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
    <?php
	$this->widget ('application.widgets.touch.song.SongList', array ('songs' => $result['song']));
	?>
    </div>
</div>
<?php endif;?>
<?php if(isset($result['album']) && count($result['album'])>0):?>
<div class="item-box-content">
    <a href='<?php echo Yii::app()->createUrl('/album/artistList', array('artist_id'=>$artist->id))?>' class='wrap-head mr-t-15' title='Album'>
        <div class='head-label clearfix'>
            <span class='text'>Album</span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
    	<?php $this->widget('application.widgets.touch.album.AlbumListWidget', array('albums' => $result['album'])) ?>
    </div>
</div>
<?php endif;?>
<?php if(isset($result['video']) && count($result['video'])>0):?>
<div class="item-box-content">
    <a href='<?php echo Yii::app()->createUrl('/video/artistList', array('artist_id'=>$artist->id))?>' class='wrap-head mr-t-15' title='Video'>
        <div class='head-label clearfix'>
            <span class='text'>Video</span>
            <span class='title'></span>
        </div><!-- End .head-label -->
    </a>
    <div class="item-content">
    	<?php $this->widget('application.widgets.touch.video.VideoList', array('videos' => $result['video'])) ?>
    </div>
</div>
<?php endif;?>
<script>
$(".viewcv").click(function() {
	var text = $(".viewcv").find("span").text();
	if(text=='Xem tiểu sử'){
		text ='Thu gọn';
		var img = '<img src="<?php echo Yii::app()->request->baseUrl?>/touch/images/up.png" />';
	}else{
		text ='Xem tiểu sử';
		var img = '<img src="<?php echo Yii::app()->request->baseUrl?>/touch/images/down.png" />';
	}
	$(".viewcv").find("span").text(text);
	$(".viewcv").find("i").html(img);
	$( "#cvct" ).toggle();
  	//$( "#cvct" ).toggleClass('c_scv');
});
</script>