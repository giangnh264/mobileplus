		<div class="artist_tab">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl("user/detail", 
                                    array("id" => $user->id, 
                                            "title" => Common::makeFriendlyUrl(trim($user->username))));?>" 
                        class="<?php echo ($tab == 'view') ? 'active':'';?>"><?php echo Yii::t("web", "Overview"); ?></a></li>
                <li>|</li>
                <li><a href="<?php echo Yii::app()->createUrl("user/detail", 
                                    array("id" => $user->id, 
                                            "title" => Common::makeFriendlyUrl(trim($user->username)),
                                            'tab'=>'song'));?>"  
                        class="<?php echo ($tab=='song')?'active':'';?>"><?php echo Yii::t("web", "Song"); ?></a></li>
                <li>|</li>
                <li><a href="<?php echo Yii::app()->createUrl("user/detail", 
                                    array("id" => $user->id, 
                                            "title" => Common::makeFriendlyUrl(trim($user->username)),
                                            'tab'=>'mv'));?>" 
                        class="<?php echo ($tab=='mv')?'active':'';?>"><?php echo Yii::t("web", "MV"); ?></a></li>
                <li>|</li>
                <li><a href="<?php echo Yii::app()->createUrl("user/detail", 
                                    array("id" => $user->id, 
                                            "title" => Common::makeFriendlyUrl(trim($user->username)),
                                            'tab'=>'playlist'));?>" 
                        class="<?php echo ($tab=='playlist')?'active':'';?>"><?php echo Yii::t("web", "Playlist"); ?></a></li>
                        
                <?php if($user->id == Yii::app()->user->getId()): ?>
                <li>|</li>                
                
                <li><a href="<?php echo Yii::app()->createUrl("user/edit", 
                                    array("id" => $user->id, 
                                            "title" => Common::makeFriendlyUrl(trim($user->username)),
                                            'tab'=>'setting'));?>" 
                        class="<?php echo ($tab=='setting')?'active':'';?>"><?php echo Yii::t("web", "Setting"); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>