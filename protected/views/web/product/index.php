<div class="product_header">
    <ul class="product_promotion">
        <li class="selected product_web">Web</li>
        <li class="product_mobile">Mobile App</li>
    </ul>
    <div class="styled-select">
        <select class="product_select">
            <option selected="selected">Mới nhất</option>
            <option>Xem nhiều nhất</option>
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
                                <a title="Hòa Âm Của Giai Điệu" href="<?php echo Yii::app()->createUrl('product/view')?>">
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

