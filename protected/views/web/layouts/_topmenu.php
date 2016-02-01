<body class="home blog">

<div id="page" class="hfeed site container mm-page mm-slideout">
    <header id="masthead" class="site-header" role="banner">
        <div id="header_phone" class="row" style="display: none">
            <div class="col-md-12 no_padding">
                <div class="container">
                    <div class="col-xs-2 no_padding">
                        <a href="javascript:;" id="m_sidebar_user">
                            <div class="icon_menu_phone"></div>
                        </a>
                    </div>
                    <div class="col-xs-8 no_padding area_logo">
                        <a href="#"><img src="/web/images/logo_wap.png" class="logo_waka_phone"></a>
                        <div class="site-branding">
                            <h1 class="site-title">
                                <a rel="home" href="<?php echo Yii::app()->createUrl('index')?>">
                                    Công ty Khởi Nguồn
                                </a>
                            </h1>

                            <h2 class="site-description">Song hành tới thành công</h2>
                        </div>
                    </div>
                    <div class="col-xs-2 no_padding">
                        <a href="javascript:;" id="m_sidebar_user">
                            <div class="icon_menu_lang"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row header-layout-1">
            <div class="col-sm-1">
                <img class="logo-main" src="<?php echo Yii::app()->request->baseUrl ?>/web/images/logo.png">
            </div>


            <div class="col-sm-4 site-branding">
                <h1 class="site-title">
                    <a href="http://mobileplus.vn/" rel="home">
                        Công ty Khởi Nguồn
                    </a>
                </h1>

                <h2 class="site-description">Song hành tới thành công</h2>
            </div>
            <div class="col-sm-5 search_area">
                <form id="search-form" class="pd-input" action="<?php echo Yii::app()->createUrl('/product/search')?>" method="get">
                    <input type="text" placeholder="Từ khóa tìm kiếm" name="q" id="content-search" class="input-search autocomplete ui-autocomplete-input" value="" autocomplete="off">
                    <input type="submit" id="btnSearch" class="btn-search" value="">
                </form>
            </div>
            <!-- .site-branding -->
            <div class="col-sm-2 header-area-right" style="float:right;">
                <a href="#" id="btn-change-lang-icon">
                    <i class="ico_lang_web"></i>
                    <span>English</span>
                </a>
                <!-- #header-search-form -->
                <div class="widget wen_corporate_social_widget"></div>
            </div>
        </div>

        <div class="" style="display:none;">
            <!-- #mob-menu -->
        </div>
        <?php $controller = Yii::app()->controller->id;?>
        <div id="site-navigation">
            <div class="main-container">
                <nav class="main-navigation">
                    <ul id="menu-home-1" class="menu">
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-7 <?php echo strtoupper($controller) == 'INDEX' ? 'current_page_item' : ''?>">
                            <a href="<?php echo Yii::app()->createUrl('index')?>">Trang chủ</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17 <?php echo strtoupper($controller) == 'PRODUCT' ? 'current_page_item' : ''?>"><a
                                href="<?php echo Yii::app()->createUrl('/product')?>">Sản phẩm</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16 <?php echo strtoupper($controller) == 'ABOUT' ? 'current_page_item' : ''?>"><a
                                href="<?php echo Yii::app()->createUrl('about')?>">Giới thiệu</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27 <?php echo strtoupper($controller) == 'CONTACT' ? 'current_page_item' : ''?>"><a
                                href="<?php echo Yii::app()->createUrl('contact')?>">Liên hệ</a></li>
                    </ul>
                </nav>
                <!-- .main-navigation -->
            </div>
        </div>
    </header>
    <!-- #masthead -->
