<?php
$phone = yii::app()->user->getState('phone');
$list_phone = Yii::app()->params['ctkm']['phone_check'];
if($this->showPopupCTKM && in_array(Yii::app()->user->phone, $list_phone)){
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
            +'<a style="margin: 5px;display: inline;" class="button bt-actived" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($shareLink);?>">Chia sẻ</a>'
            +'</div>';
            Popup.alert(html, 'Khuyến mại', 'popup_ctkm');
        })
    </script>
<?php }?>
