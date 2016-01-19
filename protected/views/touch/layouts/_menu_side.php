<aside class='menu-list hidden'>
    <div class='m-title clearfix'>
        <div class='m-logo left'><a class='logo-n' href="<?php echo Yii::app()->createUrl('/site/index');?>"></a></div>
    </div>
    <?php if (!$this->userPhone):?>
    <div class='m-link clearfix'>
        <div class='m-login'>
            <span class='lock'></span>
            <a href='<?php echo Yii::app()->createUrl('/account/login')?>'><?php echo Yii::t("wap","Login");?></a>
        </div>
    </div>
        <div class='m-link clearfix'>
        <div class='m-login'>
            <span class='regis'></span>
            <a href='<?php echo Yii::app()->createUrl('/account/create')?>'><?php echo Yii::t("wap","Tạo tài khoản");?></a>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($this->userPhone):?>
    <p class='message-login'>
        <?php
            $user_name = UserModel::model()->findByAttributes(array('phone'=>$this->userPhone))->username;
            $user_name = isset($user_name) ? $user_name : $this->userPhone;
        ?>
        <?php echo Yii::t("wap","Hi");?>: <a class='mobile' href="<?php echo Yii::app()->createUrl('/account/view')?>"><?php echo $user_name;?></a>
    </p>
    <?php endif; ?>
            <?php if ($this->userPhone && !$this->userSub):?>
        <div class='m-login-new'>
            <a href='<?php echo Yii::app()->createUrl('account/package');?>' class='rp'><?php echo Yii::t("wap","Đăng ký gói cước");?></a>
        </div>
        <?php endif; ?>
    <p class='m-label'>
        <?php echo Yii::t("wap","Music Online");?>
    </p>
    
    <ul>
        <li class="<?php if($controller=='promotion') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/promotion/about')?>' class='clearfix'>
                <span class='ic icon_shell'></span>
                <span class='text'><?php echo Yii::t("wap","Khuyến mại HOT");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='shell') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/shell')?>' class='clearfix'>
                <span class='ic icon_shell'></span>
                <span class='text'><?php echo Yii::t("wap","Nhạc độc quyền");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='video') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/video')?>' class='clearfix'>
                <span class='ic video-n'></span>
                <span class='text'><?php echo Yii::t("wap","Video");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='bxh') echo 'active'?>">	
            <a href='<?php echo Yii::app()->createUrl('/bxh')?>' class='clearfix'>
                <span class='ic rank'></span>
                <span class='text'><?php echo Yii::t("wap","Bảng xếp hạng");?></span>
            </a>
        </li>
      <!--  <li class="item_news <?php /*if($controller=='news') echo 'active'*/?>">
            <a href='<?php /*echo Yii::app()->createUrl('/news')*/?>' class='clearfix'>
                <span class='ic mnews'></span>
                <span class='text' style="margin-left: 25px"><?php /*echo Yii::t("wap","News");*/?></span>
            </a>
        </li>-->

        <li class="item_songs <?php if($controller=='song') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/song')?>' class='clearfix'>
                <span class='ic song'></span>
                <span class='text'><?php echo Yii::t("wap","Song");?></span>
            </a>
        </li>
        <li  class="<?php if($controller=='album') echo 'active'?>">	
            <a href='<?php echo Yii::app()->createUrl('/album')?>' class='clearfix'>
                <span class='ic album'></span>
                <span class='text'><?php echo Yii::t("wap","Album");?></span>
            </a>
        </li>
       <!-- <li  class="<?php /*if($controller=='genre') echo 'active'*/?>">
            <a href='<?php /*echo Yii::app()->createUrl('/genre')*/?>' class='clearfix'>
                <span class='ic icgenre'></span>
                <span class='text'><?php /*echo Yii::t("wap","Thể loại");*/?></span>
            </a>
        </li>-->
       <li  class="<?php if($controller=='topContent') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/topContent')?>' class='clearfix'>
                <span class='ic topcontent'></span>
                <span class='text'><?php echo Yii::t("wap","Chủ đề âm nhạc");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='videoplaylist') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl("/videoplaylist/index");?>' class='clearfix'>
                <span class='ic world'></span>
                <span class='text'><?php echo Yii::t("wap","Video Playlist");?></span>
            </a>
        </li>
    </ul>
    <?php if ($this->userPhone):?>
    <p class='m-label'>
        <?php echo Yii::t("wap","Personal");?>
    </p>
    <ul>
        <li class="<?php if($controller=='playlist') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/playlist/myPlaylist')?>' class='clearfix'>
                <span class='ic playlist'></span>
                <span class='text'><?php echo Yii::t("wap","My Playlist");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='favourite') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/favourite/list')?>' class='clearfix'>
                <span class='ic fav'></span>
                <span class='text'><?php echo Yii::t("wap","Favourite");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='account' && $action=='index') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/account/view')?>' class='clearfix'>
                <span class='ic myinfo'></span>
                <span class='text'><?php echo Yii::t("wap","User Infomation");?></span>
            </a>
        </li>
        <?php 
        	$cIP = isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$_SERVER["SERVER_ADDR"];
        	$cIP = explode(".", $cIP);
        	if($cIP != "10"):
        ?>
        <li>
            <a href='<?php echo Yii::app()->createUrl('/account/logout')?>' class='clearfix'>
                <span class='ic logout'></span>
                <span class='text'><?php echo Yii::t("wap","Logout");?></span>
            </a>
        </li>
        <?php endif;?>
    </ul>
    <?php endif;?>
    <p class='m-label'>
        <?php echo Yii::t("wap","Services Infomation");?>
    </p>
    <ul>
        <li class="items_about <?php if($controller=='account' && $action=='guide') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/html/index', array('url_key'=>'gioi-thieu'))?>' class='clearfix'>
                <span class='ic intro'></span>
                <span class='text'><?php echo Yii::t("wap","About");?></span>
            </a>
        </li>
        
        <?php if($this->deviceOs == "IOS" || $this->deviceOs == "ANDROIDOS"):?>
         <li class="items_download <?php if($controller=='site' && $action=='appDownload') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/site/appDownload')?>' class='clearfix'>
                <span class='install'></span>
                <span class='text'><?php echo Yii::t("wap","Tải ứng dụng");?></span>
            </a>
        </li>       
        <?php endif;?>
        <li class="items_about <?php if($controller=='account' && $action=='guide') echo 'active'?>">
        <a href='<?php echo Yii::app()->createUrl('/html/index', array('url_key'=>'gia-cuoc'))?>' class='clearfix'>
                <span class='ic ic-package'></span>
                <span class='text'><?php echo Yii::t("wap","Gói cước");?></span>
            </a>
        </li>
    </ul>
</aside>
