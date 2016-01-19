<div class="item-box">
        <a title="Bài hát độc quyền" class="wrap-head mr-t-15" href="<?php echo Yii::app()->createUrl('/shell/song')?>">
            <div class="head-label clearfix">
                <span class="text">BÀI HÁT ĐỘC QUYỀN</span>
                <span class="title"></span>
            </div><!-- End .head-label -->
        </a>
	<div class="item-content">
		<?php
		$this->widget ( 'application.widgets.touch.song.SongList', array (
				'songs' => $songs,
		) );
		?>
	</div>
</div>
<div style="clear: both"></div>
<div class="item-box">
	<a title="Bài hát độc quyền" class="wrap-head mr-t-15" href="<?php echo Yii::app()->createUrl('/shell/video')?>">
            <div class="head-label clearfix">
                <span class="text">VIDEO ĐỘC QUYỀN</span>
                <span class="title"></span>
            </div><!-- End .head-label -->
        </a>
	<div class="item-content">
		<?php if($videos){$i=0;?>
		<?php foreach ($videos as $value){?>
		<?php if($i%2==0){?><div class="item_row"><?php }?>
		<?php 
			$videoLink = Yii::app()->createUrl('video/view', array('id' => $value['id'], 'url_key' => Common::makeFriendlyUrl($value['name'])));
			$avatarImage = WapVideoModel::model()->getThumbnailUrl('s1', $value['id'])
			?>
			<div class="item">
			<a href="<?php echo $videoLink;?>">
				<div class="wrr-item-detail">
				<img src="<?php echo $avatarImage;?>" />
					<div class="info-nav">
						<p class="title"><?php echo Formatter::smartCut(CHtml::encode($value['name']), 15, 0);?></p>
						<p class="artist"><?php echo Formatter::smartCut(CHtml::encode($value['artist_name']), 15, 0);?></p>
					</div>
				</div>
			</a>
			</div>
		<?php $i++;?>
		<?php if($i%2==0 && $i!=0){
				echo "</div>"; 
			}else{
				echo '<div class="space"></div>';	
			}
		?>
		<?php }?>
		<?php }?>
	</div>
</div>
</div>
<div style="clear: both"></div>
<div class="item-box">
	<a title="Bài hát độc quyền" class="wrap-head mr-t-15" href="<?php echo Yii::app()->createUrl('/shell/album')?>">
            <div class="head-label clearfix">
                <span class="text">ALBUM ĐỘC QUYỀN</span>
                <span class="title"></span>
            </div><!-- End .head-label -->
        </a>
	<div class="item-content">
		<?php if($albums){$i=0;?>
		<?php foreach ($albums as $value){?>
		<?php if($i%2==0){?>
		<div class="item_row"><?php }?>
		<?php 
			$albumLink = Yii::app()->createUrl('album/view', array('id' => $value['id'], 'url_key' => Common::makeFriendlyUrl($value['name']),"artist"=>Common::makeFriendlyUrl(trim($value['artist_name']))));
			$avatarImage = WapAlbumModel::model()->getThumbnailUrl('s2', $value['id']);
			?>
			<div class="item">
				<a href="<?php echo $albumLink;?>">
				<div class="wrr-item-detail">
				<img src="<?php echo $avatarImage;?>" />
					<div class="info-nav">
						<p class="title"><?php echo Formatter::smartCut(CHtml::encode($value['name']), 15, 0);?></p>
						<p class="artist"><?php echo Formatter::smartCut(CHtml::encode($value['artist_name']), 15, 0);?></p>
					</div>
				</div>
				</a>
			</div>
		<?php $i++;?>
		<?php if($i%2==0 && $i!=0){
				echo "</div>"; 
			}else{
				echo '<div class="space"></div>';	
			}
		?>
		<?php }?>
		<?php }?>
		</div>
	</div>
</div>