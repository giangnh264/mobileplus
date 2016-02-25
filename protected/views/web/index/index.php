<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_slidebar.js");
?>
<div id="content" class="site-content row">
    <div class="slide">
        <?php $this->widget('application.widgets.web.slider.Init',array()); ?>
    </div>

    <div id="primary" class="content-area col-sm-12 pull-left">
        <main id="main" class="site-main" role="main">

            <div id="sidebar-front-page-widget-area">
                <aside id="wen-corporate-welcome-3" class="widget wen_corporate_welcome_widget">
                    <h2 class="widget-title">Chào mừng đến với Công ty Khởi nguồn</h2>
                    <Hr/>
                    <Hr/>
                </aside>
                <div class="bs-callout bs-callout-warning">
                    <p>
                       <?php echo $content;?>
                    </p>
                </div>

                <aside id="wen-corporate-service-3" class="widget wen_corporate_service_widget">
                    <h2 class="widget-title"><span>Dịch vụ của chúng tôi</span></h2>
                    <div class="service-block-list row">
                        <?php foreach ($services as $item):?>
                            <div class="service-block-item col-sm-4">
                                <div class="service-block-inner">
                                    <img src="<?php echo $item->img_url;?>">
                                    <h3 class="service-item-title"><?php echo $item->name;?>  </h3>

                                    <div class="service-block-item-excerpt">
                                        <p>
                                            <?php echo $item->description;?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>


                    </div>
                    <!-- .service-block-list -->
                </aside>
            </div>

        </main>
        <!-- #main -->
    </div>
    <!-- #primary -->


</div><!-- #content -->