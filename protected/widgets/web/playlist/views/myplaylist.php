<div class="box_title">
    <h2 class="name"><?php echo Yii::t('web','My Playlist'); ?></h2>
</div>
<div class="box_content">
    <ul class="bxh_album_list myplaylist item3-list">
        <?php
        $i=1;
        foreach ($playlists as $item) :
            $urlKey = ($item->url_key) ? $item->url_key : Common::makeFriendlyUrl(trim($item->name));
            $link = Yii::app()->createUrl("/playlist/view",array("id"=>$item->id,"title"=>$urlKey));

            $avatar = AvatarHelper::getAvatar("user", $item->user_id,"90");
            $altImg = $titleLink = $item->name;
            ?>
            <li id="myplaylist-<?php echo $item->id;?>">
                <a href="<?php echo $link;?>">
                    <img width="90" height="90" src="<?php echo $avatar;?>" alt="<?php echo $altImg;?>"/>
                </a>
                <h3 class="over-text"><a href="<?php echo $link;?>" title="<?php echo CHtml::encode($item->name);?>"><?php echo CHtml::encode($item->name);?></a></h3>
                <a href="javascript:;" class="edit" rel="<?php echo Yii::app()->createUrl('/xhrUser/editPlaylist', array('id'=>$item->id))?>"><span class="icon icon-edit">Edit</span></a>
                <a href="javascript:;" rel="<?php echo $item->id;?>" class="delete"><span class="icon icon-delete">Delete</span></a>
            </li>
            <?php $i++; endforeach;?>
    </ul>
</div>