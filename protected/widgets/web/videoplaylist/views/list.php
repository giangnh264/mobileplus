<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_videoplaylist.js");
?>
<div class="box_title">
    <h2 class="name"><?php echo ($this->title)?$this->title:'video playlist'; ?></h2>
    <?php if($this->type !='search' && $this->type !='byGenre'):?>
    <div class="flr">
        <ul class="btn_ty">
            <li><a href="javascript:void(0)" class="pre load_video_playlist_new <?php echo (strtoupper($this->type)=="NEW")?" active":""?>"><?php echo Yii::t('web', 'New'); ?></a></li>
            <li><i class="icon icon_s"></i></li>
            <li><a href="javascript:void(0)" class="next load_video_playlist_hot <?php echo (strtoupper($this->type)=="HOT")?" active":""?>"><?php echo Yii::t('web', 'Hot'); ?></a></li>
        </ul>
    </div>
    <?php endif;?>
</div>
<div class="box_content">
    <ul class="list_video_playlist">
          <?php if(count($videoplaylists) > 0):?>
        <?php
        $i=1; foreach ($videoplaylists as $item) :
            $urlKey = ($item->url_key) ? $item->url_key : Common::makeFriendlyUrl(trim($item->name));
            $link = Yii::app()->createUrl("videoplaylist/view", array(
                "id" => $item->id,
                "title" => $urlKey));
            $titleLink =$altImg= CHtml::encode($item->name).' - '.CHtml::encode($item->artist_name);
            $title = Formatter::smartCut($item->name, 16);
            $avatar=VideoPlaylistModel::model()->getAvatarUrl($item->id, 300);
            ?>
            <li  class="<?php if($i%4 == 0) echo 'marr_0'; else echo '';?>">
                <a href="<?php echo $link ?>"><img src="<?php echo $avatar;?>" alt="<?php echo $altImg; ?>"/></a>
                <div class="info">
                    <h3 class="name"><a title="<?php echo $titleLink;?>" href="<?php echo $link ?>"><?php echo Formatter::smartCut($item->name, 20); ?></a></h3>
                    <p class="singer"><a href="<?php echo $linkArtist;?>"><?php echo Formatter::smartCut($item->artist_name,20); ?></a></p>
                </div>
                <a title="<?php echo CHtml::encode($item->name); ?>" href="<?php echo $link ?>"><span class="circle-play"></span></a>
            </li>
        <?php $i++; endforeach;?>
            <?php else:?>
        <p class="pt10"><?php echo Yii::t("web", "Not found anything!"); ?></p>
        <?php endif; ?>
    </ul>
</div>

