<div id="content" class="site-content row">
    <div class="product_view">
        <div class="product_slide">
            <?php $this->widget('application.widgets.web.product_slider.Init',array('slider'=>$slider)); ?>
        </div>
        <div class="product_detail">
            <h2><?php echo $product->name;?></h2>
            <p class="pr_item">
                <?php echo $product->description;?>
            </p>
        </div>
        <div class="pr_mobile_view">
            <img src="../web/images/os/ios_view.png" alt="IOS">
            <img src="../web/images/os/wp_view.png" alt="WINDOWS PHONE">
            <img src="../web/images/os/android_view.png" alt="ANDROID">
            <span><a href="http://mobileplus.vn">http://mobileplus.vn</a></span>
        </div>
    </div>
    <div class="pr_same">
        <div class="pr_same_title">
            <span>Sản phẩm tương tự</span>
            <div class="pro_same_load">
                <a class="video_playlist_prev active" href="javascript:void(0)"><i class="icon_pre_active"></i>&nbsp;</a>
                <a class="video_playlist_next" href="javascript:void(0)"><i class="icon_next"></i>&nbsp;</a>
            </div>
        </div>
        <div id="video_playlist_mask" style="height: 224px;">
            <div class="product_content page_1" id="video_playlist_contain" style="left: 0px;">
                <?php
                $i=0;
                foreach ($product_relate as $product):
                    if (fmod($i, 4) == 0){
                        echo '<ul class="list_video_playlist video_playlist_page" style="width: 1170px;float:left">';
                        echo '<div class="wrr_items_list_resp">';
                    }
                    ?>
                    <div class="items fll col-25 col-sm-3">
                        <div class="wrr-item">
                            <div class="wrr-item-main">
                                <div class="thumb thumb-hover">
                                    <a title="<?php echo $product->name?>"  href="<?php echo Yii::app()->createUrl('product/view', array('id'=>$product->id))?>">
                                        <?php
                                        $product_img = ProductImgModel::model()->getOneImgByProductId($product->id);
                                        ?>
                                        <img width="100%" alt="<?php echo $product->name;?>" src="<?php echo $product_img[0]['img_url'];?>">
                                    </a>
                                </div>

                                <div class="wrr-item-content">
                                    <p class="item_main">
                                        <?php echo Formatter::smartCut($product->name, 20);?>
                                    </p>
                                    <p class="item_sub">
                                        <?php echo Formatter::smartCut($product->description, 60 );?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (fmod($i, 4) == 3 || $i==count($product_relate)-1){
                        echo '</ul>';
                    }
                    $i++; endforeach;?>
            </div>
            </div>


    </div>
</div>
<script type="text/javascript">
    var videoplaylistPager = new SlideBar('video_playlist_contain','video_playlist_page',550,2);
    $('#video_playlist_mask').height($("#video_playlist_contain").height()+"px");
    $(".video_playlist_next").live("click",function(){
        $('.video_playlist_next').addClass('active');
        $('.video_playlist_prev').removeClass('active');
        $('.video_playlist_next').children().removeClass('icon_next').addClass('icon_next_active');
        $('.video_playlist_prev').children().removeClass('icon_pre_active').addClass('icon_pre');

        videoplaylistPager.goPage(2);
    })
    $(".video_playlist_prev").live("click",function(){
        $('.video_playlist_prev').addClass('active');
        $('.video_playlist_next').removeClass('active');
        $('.video_playlist_next').children().removeClass('icon_next_active').addClass('icon_next');
        $('.video_playlist_prev').children().removeClass('icon_pre').addClass('icon_pre_active');

        videoplaylistPager.goPage(1);
    })
</script>