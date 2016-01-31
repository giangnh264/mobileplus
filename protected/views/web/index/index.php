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
                    <h2 class="widget-title">Chào mừng đến với Susoft</h2>
                    <Hr/>
                    <Hr/>
                </aside>
                <div class="bs-callout bs-callout-warning">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                        mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                        dolores eos qui ratione voluptatem sequi nesciunt.
                    </p>
                </div>

                <aside id="wen-corporate-service-3" class="widget wen_corporate_service_widget">
                    <h2 class="widget-title"><span>Dịch vụ của chúng tôi</span></h2>
                    <div class="service-block-list row">

                        <div class="service-block-item col-sm-4">
                            <div class="service-block-inner">

                                <i class="fa icon-web"></i>

                                <h3 class="service-item-title">
                                    Graphics / Web Design </h3>

                                <div class="service-block-item-excerpt">
                                   <p>
                                       Vượt ngoài khôn khổ, sáng tạo chúng tôi đem lại một sản phẩm chuyên nghiệp độc đáo, Mượt mà qua từng nét thiết kế. Cung cấp kèm theo các dịch vụ hệ thống.
                                   </p>
                                </div>
                                <!-- .service-block-item-excerpt -->


                            </div>
                            <!-- .service-block-inner -->
                        </div>
                        <!-- .service-block-item -->


                        <div class="service-block-item col-sm-4">
                            <div class="service-block-inner">

                                <i class="fa icon-responsive"></i>

                                <h3 class="service-item-title">
                                    Responsive Web Design </h3>

                                <div class="service-block-item-excerpt">
                                    Ứng dụng các tiêu chuẩn W3C đem lại cho website của bạn chạy trơn tru với tất cả trình duyệt trên mọi thiết bị.
                                </div>
                                <!-- .service-block-item-excerpt -->

                            </div>
                            <!-- .service-block-inner -->
                            <div class="show_more">
                                <i class="show_more_icon"></i>
                                <span>Xem thêm</span>
                            </div>
                        </div>
                        <!-- .service-block-item -->


                        <div class="service-block-item col-sm-4">
                            <div class="service-block-inner">

                                <i class="fa icon-app-design"></i>

                                <h3 class="service-item-title">
                                    Mobile Applications </h3>

                                <div class="service-block-item-excerpt">
                                    Các thành viên của chúng tôi có kinh nghiệm và am hiểu về phát triển phần mềm mobile. Phạm vi ứng dụng rộng và chuyên sâu từ giải trí, tiện ích đến thương mại đời sống ...
                                </div>
                                <!-- .service-block-item-excerpt -->
                            </div>
                            <!-- .service-block-inner -->
                        </div>
                        <!-- .service-block-item -->
                    </div>
                    <!-- .service-block-list -->
                </aside>
            </div>

        </main>
        <!-- #main -->
    </div>
    <!-- #primary -->


</div><!-- #content -->