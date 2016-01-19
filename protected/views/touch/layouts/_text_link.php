<?php $phone = yii::app()->user->getState('msisdn');?>
<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
if(!($controller == 'account' && in_array($action, array('login','package')))){
    if(!$this->userPhone){?>
        <p class="pad-10" style="text-align: left;padding-left: 10px;"><a class="c_red" href="<?php echo Yii::app()->createUrl('/account/login');?>"><?php echo 'Quý khách vui lòng đăng nhập tại đây hoặc chuyển sang truy cập bằng 3G/GPRS của MobiFone'; ?></a></p>
    <?php }else {
        if(!$this->userSub){
            $is_km = UserSubscribeModel::model()->checkPromotion($phone);
            if($is_km){?>
                <p class="pad-10" style="text-align: left;padding-left: 10px;"><a class="c_red" href="<?php echo Yii::app()->createUrl('/account/welcome');?>"><?php echo 'MIỄN PHÍ 5 ngày nghe xem tải không giới hạn. Miễn cước data 3G/GPRS. Đăng ký ngay!'; ?></a></p>
            <?php }else{?>
                <p class="pad-10" style="text-align: left;padding-left: 10px;"><a class="c_red" href="<?php echo Yii::app()->createUrl('/account/welcome');?>"><?php echo 'Nghe nhạc thả ga – Miễn cước data 3G/GPRS. Đăng ký ngay!'; ?></a></p>
            <?php }
        }else{
            $textlink = TextLinkModel::model()->checkTextlink($controller);
            if(!empty($textlink)){?>
                <p class="pad-10" style="text-align: left; padding-left: 10px;" ><a href="<?php echo $textlink[0]->url?>" class="c_red"><?php echo $textlink[0]->name?></a></p>
            <?php
            }
        }
    }
}
?>
<?php
if($this->showPopupCTKM  && false){
    $_SESSION['already_popup_ctkm'] = true;
    $cookie = new CHttpCookie('showPopupCTKm', 1);
    $cookie->expire = time() + 60 * 60 * 24 * $day;
    Yii::app()->request->cookies['showPopupCTKm'] = $cookie;
    $popup_content = HtmlModel::model()->findbyPk(27)->content;
    $link = Yii::app()->createUrl('/promotion/about');;
    $shareLink = Yii::app()->request->getHostInfo().Yii::app()->request->baseUrl . $link;
    ?>
    <script type="text/javascript">
        $(function(){
            html =
                '<?php echo $popup_content?>'
                +'<div class="pk-btn" style="text-align: center">'
                +'<a style="margin: 5px;display: inline;" class="button bt-actived" href="<?php echo $link?>">Tham gia</a>'
                +'<a style="margin: 5px;display: inline;" class="button" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>">Chia sẻ</a>'
                +'</div>';
            Popup.alert(html, 'Khuyến mại', 'popup_ctkm');
        })
    </script>
<?php }else{
    if($this->showPopupKm && !isset(Yii::app()->session['src'])):
        $link_reg = Yii::app()->createUrl('/account/doRegister',array("id"=>1));
        ?>
        <script type="text/javascript">
            $(function(){
                html =
                    '<p class="padB10"><strong style="color:#f42621">Amusic</strong> – CTKM dành cho thuê bao VIP: <strong style="color:#f42621">MIỄN PHÍ</strong> 5 ngày nghe, xem, tải các bài hát, Clip ca nhạc HOT chất lượng cao nhất. Đặc biệt, <strong style="color:#f42621">Miễn cước 3G/GPRS</strong>.</p>'
                    +'<div class="pk-btn" style="text-align: center">'
                    +'<a style="margin: 5px;display: inline;" class="button" href="javascript:void(0);" onclick="ClosePopup(\'popup_km\')">Đóng</a>'
                    +'<a style="margin: 5px;display: inline;" class="button bt-actived" href="javascript:void(0);" onclick="RegisterPopupKm()">Đồng ý</a>'
                    +'</div>';
                Popup.alert(html, 'Thông báo', 'popup_km');
            })
        </script>
    <?php
    elseif($this->showPopup && !isset(Yii::app()->session['src'])):
        $link_reg = Yii::app()->createUrl('/account/doRegister',array("id"=>1));
        ?>
        <script type="text/javascript">
            $(function(){
                html =
                    '<p class="padB10"><strong style="color:#f42621">Amusic</strong> – Cổng âm nhạc Đặc biệt của MobiFone! <strong style="color:#f42621">Nghe, xem, tải không giới hạn</strong> các bài hát, Clip ca nhạc HOT nhất hiện nay. Đặc biệt, <strong style="color:#f42621">Miễn cước 3G/GPRS.</strong></p>'
                    +'<div class="pk-btn" style="text-align: center">'
                    +'<a style="margin: 5px;display: inline;" class="button" href="javascript:void(0);" onclick="ClosePopup(\'popup_not_km\')">Đóng</a>'
                    +'<a style="margin: 5px;display: inline;" class="button bt-actived" href="javascript:void(0);" onclick="RegisterPopup()">Đồng ý</a>'
                    +'</div>';
                Popup.alert(html, 'Thông báo', 'popup_not_km');
            })
        </script>
    <?php endif;?>
<?php }?>
