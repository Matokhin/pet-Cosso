<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?LANGUAGE_ID?>>">

<head>
    <?$APPLICATION->ShowHead();?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?$APPLICATION->ShowTitle();?></title>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/owl.carousel.min.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap-slider.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick-theme.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/style.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/sass/components/Vendor/font-awesome/font-awesome.min.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/sass/components/Vendor/simple-line-icon/css/simple-line-icons.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/sass/components/Vendor/blanch/fonts.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/sass/components/Vendor/PlayfairDisplay/fonts.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/sass/components/Vendor/ionicons/css/ionicons.min.css");?>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/favicon.png" type="image/png">
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owl.carousel.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap-slider.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/masonry.pkgd.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/main.js");?>
</head>

<body>
<?$APPLICATION->ShowPanel();?>
<!--push menu cart -->
<div class="pushmenu pushmenu-left cart-box-container">
    <div class="cart-list">
        <span class="close-left js-close">x</span>
        <h3 class="cart-title">Your Cart</h3>
        <div class="nocart-list">
            <div class="empty-cart">
                <h4 class="nocart-title">No products in the cart.</h4>
                <a href="" class="btn-shop btn-arrow">Start shopping</a>
            </div>
        </div>
        <div class="cart-bottom">
            <a href="#" class="text">Our Shipping & Return Policy</a>
        </div>
        <!-- End cart bottom -->
    </div>
</div>
<!-- End cart -->
<?$APPLICATION->IncludeComponent(
    "bitrix:search.form",
    "search_form",
    Array(
        "COMPONENT_TEMPLATE" => "search_form",
        "PAGE" => "#SITE_DIR#search/index.php",
        "USE_SUGGEST" => "N"
    )
);?>
<!--END  Modal content-->
<div class="wrappage">
    <header id="header" class="header-v1">
        <div class="sticky-header text-center hidden-xs hidden-sm">
            <div class="text">
                <span class="u-line">Free shipping and returns</span> on all orders above $200
            </div>
        </div>
        <div class="topbar">
            <div class="container container-40">
                <div class="topbar-left">
                    <div class="topbar-option">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.basket.basket.line",
                            "profile",
                            Array(
                                "HIDE_ON_BASKET_PAGES" => "Y",
                                "PATH_TO_AUTHORIZE" => "",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                "PATH_TO_REGISTER" => SITE_DIR."login/",
                                "POSITION_FIXED" => "N",
                                "SHOW_AUTHOR" => "N",
                                "SHOW_EMPTY_VALUES" => "Y",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_PERSONAL_LINK" => "Y",
                                "SHOW_PRODUCTS" => "N",
                                "SHOW_REGISTRATION" => "Y",
                                "SHOW_TOTAL_PRICE" => "Y"
                            )
                        );?>
                        <div class="topbar-language dropdown">
                            <a id="label1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                                <span>EN</span>
                                <span class="fa fa-caret-down f-10"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="label1">
                                <li><a href="#">English</a></li>
                                <li><a href="#">Vietnamese</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--end topbar-option-->
                </div>
                <!--end topbar-left-->
                <div class="logo hidden-xs hidden-sm">
                    <a href="/" title="home-logo"><img src="<?=SITE_TEMPLATE_PATH?>/img/cosre.png" alt="logo" class="img-reponsive"></a>
                </div>
                <!--end logo-->
                <div class="topbar-right">
                    <div class="topbar-option">
                        <div class="topbar-currency dropdown">
                            <a id="label2" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                                <span>USD</span>
                                <span class="fa fa-caret-down f-10"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="label2">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">VND</a></li>
                            </ul>
                        </div>
                        <div class="topbar-search">
                            <div class="search-popup dropdown" data-toggle="modal" data-target="#myModal">
                                <a href="#"><i class="icon-magnifier f-15"></i></a>
                            </div>
                        </div>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.basket.basket.line",
                            "basket_line",
                            Array(
                                "COMPONENT_TEMPLATE" => "basket_line",
                                "HIDE_ON_BASKET_PAGES" => "Y",
                                "PATH_TO_AUTHORIZE" => "",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                "PATH_TO_REGISTER" => SITE_DIR."login/",
                                "POSITION_FIXED" => "N",
                                "SHOW_AUTHOR" => "N",
                                "SHOW_EMPTY_VALUES" => "Y",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_PERSONAL_LINK" => "Y",
                                "SHOW_PRODUCTS" => "N",
                                "SHOW_REGISTRATION" => "N",
                                "SHOW_TOTAL_PRICE" => "Y",

                            )
                        );?>
                    </div>
                    <!--end topbar-option-->
                </div>
                <!--end topbar-right-->
            </div>
        </div>
        <div class="header-top">
            <div class="container container-40">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="logo-mobile hidden-lg hidden-md">
                            <a href="" title="home-logo"><img src="<?=SITE_TEMPLATE_PATH?>/img/cosre.png" alt="logo" class="img-reponsive"></a>
                        </div>
                        <!--end logo-->
                        <button type="button" class="navbar-toggle icon-mobile" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-menu"></span>
                        </button>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "main_menu",
                            Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "COMPONENT_TEMPLATE" => "main_menu",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "3",
                                "MENU_CACHE_GET_VARS" => array(),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "Y",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "ROOT_MENU_TYPE" => "left",
                                "USE_EXT" => "Y"
                            )
                        );?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- /header -->
    <?if($APPLICATION->GetCurPage() != '/') {
        ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "breadcrumb",
            Array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0"
            )
        );?>
        <?
    } else {
        ?>
        <div class="page-heading">
            <div class="banner-heading">
                <img src="<?=SITE_TEMPLATE_PATH?>/img/headerbg_2.jpg" alt="" class="img-reponsive">
                <div class="heading-content text-center">
                    <div class="container container-42">
                        <h1 class="page-title white">Shop</h1>
                        <ul class="breadcrumb white">
                            <li><a href="/">home</a></li>
                            <li><a href="">Shop All Products</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.sections.top",
                "sections",
                Array(
                    "ACTION_VARIABLE" => "action",
                    "BASKET_URL" => "/personal/basket.php",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CONVERT_CURRENCY" => "N",
                    "DETAIL_URL" => "",
                    "DISPLAY_COMPARE" => "N",
                    "ELEMENT_COUNT" => "9",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "IBLOCK_ID" => "2",
                    "IBLOCK_TYPE" => "catalog",
                    "LINE_ELEMENT_COUNT" => "3",
                    "PRICE_CODE" => "",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPERTIES" => "",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PROPERTY_CODE" => array(0=>"",1=>"",),
                    "SECTION_COUNT" => "20",
                    "SECTION_FIELDS" => array(0=>"",1=>"",),
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_SORT_FIELD" => "sort",
                    "SECTION_SORT_ORDER" => "asc",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array(0=>"",1=>"",),
                    "SHOW_PRICE_COUNT" => "1",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N"
                )
            );?>
        </div>
        <?
    }?>


