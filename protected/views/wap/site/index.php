<div class="clb">
	<div class="bl_title fontB">
		<a href="<?php echo Yii::app()->createUrl('song/list', array('type'=>'HOT'));?>"><?php echo Yii::t('wap','BÀI HÁT HOT'); ?></a>
	</div>
	<div class="bl_item">
            <?php
                $this->widget('application.widgets.wap.song.SongList',
								array(
										'songs' => $songs,
										'type' => 'homepage',
										'link' => Yii::app()->createUrl('song/list', array('s'=>'HOT')),
										'options'=>array(),
								));
            ?>
	</div>
</div>

<div class="clb">
	<div class="bl_title fontB">
		<a href="<?php echo Yii::app()->createUrl('album/list', array('s'=>'HOT'));?>"><?php echo Yii::t('wap','ALBUM HOT'); ?></a>
	</div>
	<div class="bl_item">
            <?php
                $this->widget('application.widgets.wap.album.AlbumList',
								array(
										'albums' => $albums,
										'type' => 'homepage',
										'link' => Yii::app()->createUrl('album/list', array('s'=>'HOT')),
										'options'=>array(),
								));
            ?>
	</div>
</div>
<div class="clb">
	<div class="bl_title fontB">
		<a href="<?php echo Yii::app()->createUrl('video/list', array('s'=>'HOT'));?>"><?php echo Yii::t('wap','VIDEO HOT'); ?></a>
	</div>
	<div class="bl_item">
            <?php
                $this->widget('application.widgets.wap.video.VideoList',
								array(
										'videos' => $videos,
										'type' => 'homepage',
										'link' => Yii::app()->createUrl('video/list', array('s'=>'HOT')),
										'options'=>array(),
								));
            ?>
	</div>
</div>


<div id="adv9" class="banner_ clb">
    <?php
    $arr = array();
    $rate = array();
    foreach($this->banners as $banner){
        if($banner['position'] == 9){
            $arr[]=$banner;
            $ra = $banner['rate']?$banner['rate']:1;
            $ra = (int) $ra;
            for($i=0;$i<$ra;$i++){
                $rate[] = $banner;
            }
        }
    }
    shuffle($rate);
    $item = rand(0, count($rate)-1);
    if(isset($rate[$item])&&$rate[$item]){
        $ban = $rate[$item];
        echo $ban['content'];
    }
    ?>
</div>
<?php
$horoscopes = WapRadioModel::model()->getHoroscopes(Yii::app()->params['horoscope']['parent_id'], 4);
if ($horoscopes) :?>
<div class=" clb">
    <div class="bl_title fontB"><a href="<?php echo Yii::app()->createUrl('/horoscopes/index')?>">ÂM NHẠC 12 CÁ TÍNH</a></div>
    <div class="bl_item">
        <?php
        $this->widget('application.widgets.wap.radio.RadioList', array('radios' => $horoscopes, 'type' => 'home_page'))
        ?>
    </div>
</div>
<?php endif; ?>

