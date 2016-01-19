<body>
    <div id="header">
        <div class="fll" id="chachalogo"><a href="<?php echo Yii::app()->createUrl('/site');?>/"><img alt="logo" src="<?php Yii::app()->request->baseUrl; ?>/wap/images/Logo.png"/></a></div>
        <div class="flr" id="header-nav">
            <?php
            if(!function_exists("checkCurrentMenu")){
            	function checkCurrentMenu($menu, $cId, $actionId){
            		if(($menu == $cId && $actionId != "grid") || ($menu == $cId . '/' . $actionId)){
            			return 'selected';
            		}
            		return '';
            	}
            }
            ?>
            <div class="icon_user nav_icon ">
            <a href='<?php echo Yii::app()->createUrl("account/login")?>'></a></div>
        </div>
    </div>
    <?php if(isset($_GET['type']) && $cId == 'genre')
	    {
	    	$cId = $_GET['type'];
	    }
    ?>
 <div class="clb topmenu">
            <table>
                <tr>
                    <td class="<?php echo checkCurrentMenu("site", $cId, $actionId)?>">
                    	<a title='' href='<?php echo Yii::app()->createUrl("site")?>' class="home-ico">&nbsp; &nbsp;&nbsp;&nbsp;</a>
                    </td>
                    <td class="<?php echo checkCurrentMenu("song", $cId, $actionId)?>">
                    	<a title='' href='<?php echo Yii::app()->createUrl("song")?>'>Bài hát</a>
                    </td>
                    <td class="<?php echo checkCurrentMenu("video", $cId, $actionId)?>">
                    	<a title='' href='<?php echo Yii::app()->createUrl("video")?>'>Video</a>
                    </td>
                    <td class="<?php echo checkCurrentMenu("album", $cId, $actionId)?>">
                    	<a title='' href='<?php echo Yii::app()->createUrl("album")?>'>Album</a>
                    </td>
                    <td class="<?php echo checkCurrentMenu("bxh", $cId, $actionId)?>">
                    	<a title='' href='<?php echo Yii::app()->createUrl("bxh")?>'>BXH</a>
                    </td>
                    <td class="<?php echo checkCurrentMenu("shell", $cId, $actionId)?>">
                        <a title='' href='<?php echo Yii::app()->createUrl("shell")?>'>Độc quyền</a>
                    </td>
                </tr>
            </table>
    </div>
        <?php if(!($cId == "apps" && $actionId == "index") && !($cId == "account" && $actionId == "view") && !($cId == "account" && $actionId == "register")) :?>
    <div class="clb pad10" id="vg_top">
        
        <?php
        if($this->showPopupKm):
               $_SESSION['already_popupkm'] = 1;
               $cookie = new CHttpCookie('showPopupKm', 1);
               $cookie->expire = time() + 60 * 60 * 24 * 15;
               Yii::app()->request->cookies['showPopupKm'] = $cookie;
               $link_reg = Yii::app()->createUrl('/account/packageInfo');
       ?>
        <?php endif?>
        <?php
        $phone = Yii::app()->user->getState('msisdn');
        if ($phone) :?>
            <p class="padT10"><span><?php echo Yii::t('wap', 'Chào mừng '); ?></span><span class="welcome_phone"><?php echo $phone; ?></span></p>
        <?php endif; ?>
        <?php $package  = Yii::app()->user->getState('userSub');
        if(!$package):?>
            <?php
            if(Yii::app()->user->getState('msisdn')):
                if($this->promotion_realtime ): ?>
                    <p class="padT10"><a class="message_register" href="<?php echo yii::app()->createUrl('/account/register')?>"><?php echo yii::t('wap', 'MIỄN PHÍ 5 ngày nghe xem tải không giới hạn. Miễn cước data 3G/GPRS. Đăng ký ngay!'); ?></a></p>
                    <?php else:?>
                    <p class="padT10"><a class="message_register" href="<?php echo yii::app()->createUrl('/account/register')?>"><?php echo yii::t('wap', 'Nghe nhạc thả ga - Miễn cước data 3G/GPRS. Đăng ký ngay!'); ?></a></p>
                    <?php endif;?>
            <?php else:?>
                <p class="padT10"><a class="message_register" href="<?php echo yii::app()->createUrl('/account/login')?>"><?php echo yii::t('wap', 'Quý khách vui lòng đăng nhập tại đây hoặc chuyển sang truy cập bằng 3G/GPRS của MobiFone!'); ?></a></p>
            <?php endif;?>
        <?php endif;?>
        <?php
        $textlink = TextLinkModel::model()->checkTextlink($controller);
        if(!empty($textlink)):?>
            <p class="padT10"><a class="message_register" href="<?php echo $textlink[0]->url?>"><?php echo $textlink[0]->name; ?></a></p>
        <?php
        endif;
        ?>
        <?php if (!($cId == "site" && $actionId == "grid")):?>
                <?php
			            $form = $this->beginWidget('CActiveForm', array(
		                'action' => Yii::app()->createUrl('/search/index'),
		                'id' => 'search-form',
		                'method' => 'GET',
		                'enableAjaxValidation' => false,
                    ));
		
            ?>
            <?php if(isset($_GET['search']) && ($_GET['search'] == 1 && Yii::app()->session["search"] == true)):?>
	            <div style="clear: both; text-align: center;">
                	<div class="errorMessage" style="font-size: 12px; color:#256dba">Vui lòng nhập từ khóa để tìm kiếm</div>     
                </div>
               <?php else:Yii::app()->session["search"] = false; ?>
		            <?php endif;?>
	            <?php if(!($cId == 'account' && $actionId == 'view')):?>
			<div id="search" class="search">
	            <div class="bgsearch">
	                <div class="pd-input">
	                    <input type="text" name="q" id="content" class="input-search" value="">
						<img alt="icon-search" src="<?php echo Yii::app()->request->baseUrl ?>/wap/images/search-icon.png">
	                    <input type="submit" id="btnSearch" class="btn-search" value="&nbsp">
	                </div>
	            </div>
	        </div>
			<?php endif;?>
            <?php $this->endWidget(); ?>
            <p class="vg_tags">
                <span id="search_suggest">
                    <?php
                    $searchText = Yii::app()->params['SEARCH_SUGGEST_WAP'];
                    if ($searchText) {
                        $arr = explode("|", $searchText);
                        $arText = array();
                        foreach ($arr as $ar) {
                            $ar = trim($ar);
                            if ($ar != "") {
                                $key = str_replace(" ", "+", $ar);
                                $link =  Yii::app()->createUrl("/search/index?q=$key&yt0=");
                                $arText[] = "<a href='$link'>$ar</a>";
                            }
                        }
                        $res = implode(" | ", $arText);
                        echo $res;
                    }
                    ?>
                </span></p>
        <?php endif; ?>
    </div>
    <?php if ((!($cId == "site" && $actionId == "grid")) && !($cId == 'account' && $actionId != 'index')):?>
    <div id="adv8" class="banner_ clb">
	<?php
        $arr = array();
        $rate = array();
        foreach($this->banners as $banner){
            if($banner['position'] == 8){
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
    <?php endif; ?>
	<?php endif;?>
	<div class="mL10 mR10">
	    <?php echo $content;?>
	</div>
    <?php if (!($cId == "site" && $actionId == "grid")): ?>
        <div class="clb pad10 padT35" id="vg_top">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl('/search/index'),
                'id' => 'search-form',
                'method' => 'GET',
                'enableAjaxValidation' => false,
                    ));
            ?>
             <?php if(!($cId == 'account' && $actionId == 'view') && !($cId == 'account' && $actionId == 'register')):?>
			<div id="search" class="search">
	            <div class="bgsearch">
	                <div class="pd-input">
	                    <input type="text" name="q" id="content" class="input-search" value="<?php
						$keyword = Yii::app()->request->getParam('content', '');
						$keyword = strip_tags($keyword);
						echo $keyword
						?>">
                            		<img alt="icon-search" src="<?php echo Yii::app()->request->baseUrl ?>/wap/images/search-icon.png">
	                    <input type="submit" id="btnSearch" class="btn-search" value="&nbsp">
	                </div>
	            </div>
	        </div>
			<?php endif;?>
            <?php $this->endWidget(); ?>

        </div>
        <div id="adv10" class="banner_ clb ">
            <?php
                $arr = array();
                $rate = array();
                foreach($this->banners as $banner){
                    if($banner['position'] == 10){
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
    <?php endif; ?>
	<div class="clb nav_bottom" id="footer">
            <center>
                <table class="table0" style="text-align: center">
                    <tr>
                        <td class="border-right <?php echo checkCurrentMenu("site", $cId, $actionId)?>"><a class="smallText" href="<?php echo Yii::app()->createUrl("/site")?>">Trang chủ&nbsp;</a></td>
                        <td class="border-right"><a class="smallText" href="<?php echo Yii::app()->createUrl('/html/index', array('url_key'=>'gioi-thieu'))?>">Giới thiệu&nbsp;</a></td>
                        <?php /* 
                        <td><a class="smallText" href="<?php echo Yii::app()->createUrl("/account/Application")?>">Tải ứng dụng</a></td>
                        */ ?>
                        <td>
	                        <img class="img-top-footer" src="<?php echo Yii::app()->request->baseUrl; ?>/wap/images/Shape-1.png" alt="top"/>
	                        <a class="smallText top-web" href="javascript:void(0)" onclick="window.scrollTo(0, 0);">Top</a>
                        </td>
                        
                    </tr>
                </table>
                <p style="color:#fff; display: none" class="m0 smallText">&copy; 2009 - 2012 Vinaphone</p>
            </center>
            <div id="sy1"></div>
        	<div id="sy2"></div>
	</div>
	<div class="clb" id = "copyright">
			<ul>
                <li class="copyright_text">© Phát triển bởi Vega Corporation</li>
                <li>Cơ quan chủ quản: Công ty Cổ phần Bạch Minh (Vega Corporation).</li>
                <li>Địa chỉ: P804, tầng 8, tòa nhà V.E.T, 98 Hoàng Quốc Việt, Nghĩa Đô, Cầu Giấy, Hà Nội.</li>
                <li>Số Giấy chứng nhận ĐKKD: 0101380911</li>
                <li>Email: info@vega.com.vn</li>
                <li>Tel: 04 37554190/ Fax: (04) 37554190</li>
                <li>Người chịu trách nhiệm nội dung: Bà Nguyễn Thu Dung</li>
                <li>Đơn vị phối hợp thanh toán: MobiFone</li>
            </ul>
	</div>
        
</body>