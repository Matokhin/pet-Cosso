<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<footer>
    <div class="container container-42">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <div class="menu-footer">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom_menu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(0=>"",),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N"
                        )
                    );?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sender.subscribe",
                    "sender",
                    Array(
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CONFIRMATION" => "Y",
                        "HIDE_MAILINGS" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_HIDDEN" => "N",
                        "USER_CONSENT" => "N",
                        "USER_CONSENT_ID" => "0",
                        "USER_CONSENT_IS_CHECKED" => "Y",
                        "USER_CONSENT_IS_LOADED" => "N",
                        "USE_PERSONALIZATION" => "Y"
                    )
                );?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <div class="social">
                    <a href="#" title="twitter">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="#" title="facebook">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a href="#" title="google plus">
                        <i class="fa fa-google-plus"></i>
                    </a>
                    <a href="#" title="Pinterest">
                        <i class="fa fa-pinterest-p"></i>
                    </a>
                    <a href="#" title="rss">
                        <i class="fa fa-rss"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="scroll_top">SCROLL TO TOP<span></span></a>

</body>


