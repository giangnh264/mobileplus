<div class="product_header">
    <input id="link_channel_web" type="hidden" value="<?php echo Yii::app()->createAbsoluteUrl('/product/index', array('channel'=>'web', 'order'=>$order));?>">
    <input id="link_channel_app" type="hidden" value="<?php echo Yii::app()->createAbsoluteUrl('/product/index', array('channel'=>'app', 'order'=>$order));?>">
    <ul class="product_promotion">
        <li class="product_web <?php echo ($channel == 'web'? 'selected' : '') ;?>">Web</li>
        <li class="product_mobile <?php echo ($channel == 'app'? 'selected' : '') ;?>">Mobile App</li>
    </ul>
    <div class="styled-select">
        <select class="product_select" onchange="location = this.options[this.selectedIndex].value;">
            <option value="<?php echo Yii::app()->createUrl('/product/index', array('channel'=>$channel, 'order'=>'0'))?>" <?php echo ($order == 0) ?'selected' : '';?>>Xem nhiều nhất</option>
            <option value="<?php echo Yii::app()->createUrl('/product/index', array('channel'=>$channel, 'order'=>'1'))?>" <?php echo ($order == 1) ?'selected' : '';?>>Mới nhất</option>

        </select>
    </div>
</div>
<div class="product_content">
        <div class="wrr_items_list_resp">
            <?php foreach($product_web as $product):?>
                <div class="items fll col-25 col-sm-3">
                    <div class="wrr-item">
                        <div class="wrr-item-main">
                            <div class="thumb thumb-hover">
                                <?php
                                $link = !empty($product->des_link) ? $product->des_link : Yii::app()->createUrl('product/view', array('id'=>$product->id, 'url_key'=>$product->url_key));
                                ?>
                                <a title="<?php echo $product->name;?>" href="<?php echo $link; ?>">
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
            <?php endforeach;?>
            <div class="clear"></div>
        </div>
    <hr class="pr-hr">
    <?php
    $this->widget("application.widgets.web.common.VLinkPager", array(
        "pages" => $page,
        "maxButtonCount" => Yii::app()->params ["constLimit"] ["pager.max.button.count"],
        "header" => "",
        "htmlOptions" => array(
            "class" => "pager"
        )
    ));
    ?>
</div>
