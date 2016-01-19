<?php if(isset($users) && count($users) > 0):?>
    <div class="box_title clb pt10">
        <h2 class="name font20"><?php echo $boxName;?></h2>
    </div>
    <div class="box_content">
        <ul class="user_list">
            <?php
            $max = min(count($users), $limit);
            for ($i = 0; $i < $max; $i++):
            	$user = $users[$i];
            	if(isset($user) && isset($user->id)):                
                $link = Yii::app()->createUrl("user/detail", array("id" => $user->id));
                ?>
                <li class="<?php if($i%3 == 2) echo 'marr_0'; else echo '';?>">
                    <a href="<?php echo $link;?>">
                        <?php
                        if(!file_exists(WebUserModel::model()->getAvatarPath($user->id))){
                            $thumb = Yii::app()->request->baseUrl.'/web/images/default.png';
                        }else{
                            $thumb = WebUserModel::model()->getThumbnailUrl(90, $user->id);
                        }
                        ?>
                        <img style="width: 90px; height: 90px;"
                             src="<?php echo $thumb; ?>" alt="<?php echo CHtml::encode($user->fullname);?>" />
                    </a>
                    <p class="over-text"><a href="<?php echo $link;?>" title="<?php echo CHtml::encode($user->fullname);?>"><?php echo CHtml::encode($user->fullname);?></a></p>
                </li>
                <?php endif;?>
            <?php endfor; ?>
        </ul>
    </div>
<?php endif;?>