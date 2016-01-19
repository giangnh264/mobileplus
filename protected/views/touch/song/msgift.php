<div id="musicgift">
<?php
$artistLink = yii::app()->createUrl('artist/view', array('id' => $song->song_artist[0]->artist_id, 'url_key' => Common::makeFriendlyUrl($song->artist_name)));
?>
<div style="padding: 10px">
<div class="newlist toptext cusleftdiv infom">
    
    <h1><?php echo $song->name ?></h1>
    <div>Ca sĩ:&nbsp;<a href="<?php echo $artistLink ?>"><?php echo $song->artist_name ?></a></div>
    <div>MS:&nbsp;S<?php echo $song->code; ?></div>
    <div>
        <span class="img_wrap">Nghe</span>
        <a class="smallText" href="<?php echo yii::app()->createUrl('song/view', array('id' => $song->id, 'play' => 1)); ?>">(<?php echo $played_count ; ?>)</a>
    </div>
</div>

<div id="sendmsgift">
<div class="padL10 fleftfull">
	<?php 
        if ($send == 1 && $errorCode == 0) 
            echo '<div class="success">'.$errorDescription.'</div>';
        elseif ($errorCode != 0 && $send == 1) 
            echo "<span class='error'>".$errorDescription."</span>";
    ?>
</div>
    <?php $form = $this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl('song/msgift', array('id' => $song->id)),
            'id'=>'song-form',
            'enableAjaxValidation'=>false,
    )); ?>
    <?php echo CHtml::hiddenField('send', 1) ?>
    <div>Số điện thoại</div>
    <div class="padL10">
        <input type="text" id="receivePhone" name="receivePhone" maxlength ="20" />
    </div>
    
    <p class="padL10">Thời gian tặng quà (<span style="font-size:12px;">Theo mẫu "năm-tháng-ngày giờ:phút:giây". Ví dụ: <?php echo date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))))?></span>)</p>
    <p class="padL10">
        <input type="text" id="sendTime" name="sendTime" />
    </p>
    
<!--    <p class="padL10">Lời nhắn</p>
    <p class="padL10">
        <textarea id="message" name="message"></textarea>
    </p>-->
    <p class ="padL10 padR5 textbox_sent">
        <input class="button bt-actived" type="submit" value="Tặng qua tổng đài" name="yt0" class="btnRed">
    </p>
    <?php  $this->endWidget(); ?>
</div>
<div class="padL10" id="ms_description">
</div>
</div>
<!-- list songs have same singer -->

<?php if(isset($songsSameSinger) && count($songsSameSinger)):?>
<div id="res-video" class="vg_contentBody">
	<ul class="orther clb">
		<li style="width: 100%"><a class="same active"
			onClick="LoadSameArtist('<?php echo Yii::app()->createUrl('/song/loadAjax', array('s' => 'artist', 'id' => $song->id, 'artist_id' => $artistId)); ?>');"
			href="javascript:void(0)">Cùng ca sĩ</a></li>
	</ul>
</div>
<?php $this->widget('application.widgets.touch.song.SongList', array('songs' => $songsSameSinger)) ?>
<?php endif;?>

<!-- list songs have same genre -->

</div>
