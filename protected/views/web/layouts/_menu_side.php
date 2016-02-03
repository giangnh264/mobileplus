<aside class='menu-list hidden'>
    <?php $controller = Yii::app()->controller->id;?>
    <ul>
        <li style="position: relative">
            <form id="search-form" class="pd-input" action="<?php echo Yii::app()->createUrl('/product/search')?>" method="get">
                <i class="icon_wap_search"></i>
                <input type="text" placeholder="Từ khóa tìm kiếm" name="q" id="content-search" class="input-search autocomplete ui-autocomplete-input" value="" autocomplete="off">
            </form>
        </li>
        <li class="<?php if($controller=='index') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/index')?>' class='clearfix'>
                <span class='text'><?php echo Yii::t("web","Trang chủ");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='product') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/product')?>' class='clearfix' style="float: left;">
                <span class='text'><?php echo Yii::t("web","Sản phẩm");?></span>
            </a>
            <i id="product_more" class="product_showmore"></i>
        </li>
        <li class="product_child hidden">
            <a href='<?php echo Yii::app()->createUrl('/product/index', array('channel'=>'web', 'order'=>1))?>' class='clearfix'>
                <span class='text' style="margin-left: 25px; text-transform: none;"><?php echo Yii::t("web","Dành cho Web");?></span>
            </a>
        </li>
        <li class="product_child hidden">
            <a href='<?php echo Yii::app()->createUrl('/product/index', array('channel'=>'app', 'order'=>1))?>' class='clearfix'>
                <span class='text' style="margin-left: 25px; text-transform: none;"><?php echo Yii::t("web","Dành cho Mobile");?></span>
            </a>
        </li>
        <li class="<?php if($controller=='about') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/about')?>' class='clearfix'>
                <span class='text'><?php echo Yii::t("web","Giới thiệu");?></span>
            </a>
        </li>
        <li class="item_news <?php if($controller=='contact') echo 'active'?>">
            <a href='<?php echo Yii::app()->createUrl('/contact')?>' class='clearfix'>
                <span class='text'><?php echo Yii::t("web","Liên hệ");?></span>
            </a>
        </li>
       </ul>
   <p>
       © 2016 Powered By SUSOFT
   </p>

</aside>
<script>
    $("#product_more").on('click', function () {
        if($('.product_child').hasClass('hidden')){
            $('.product_child').removeClass('hidden');
        }else{
            $('.product_child').addClass('hidden');
        }
        if($('#product_more').hasClass('product_showmore')){
            $('#product_more').removeClass('product_showmore');
            $("#product_more").addClass('product_hidemore');
        }else  if($('#product_more').hasClass('product_hidemore')){
            $('#product_more').removeClass('product_hidemore');
            $("#product_more").addClass('product_showmore');
        }
    })
</script>