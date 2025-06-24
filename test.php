<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?><?$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "filter_fixed",
    Array(
        "AJAX_MODE" => "Y",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => "filter_fixed",
        "CONVERT_CURRENCY" => "N",
        "DISPLAY_ELEMENT_COUNT" => "Y",
        "FILTER_NAME" => "arrFilter",
        "FILTER_VIEW_MODE" => "vertical",
        "HIDE_NOT_AVAILABLE" => "N",
        "IBLOCK_ID" => "2",
        "IBLOCK_TYPE" => "catalog",
        "PAGER_PARAMS_NAME" => "arrPager",
        "POPUP_POSITION" => "left",
        "PREFILTER_NAME" => "smartPreFilter",
        "PRICE_CODE" => array(),
        "SAVE_IN_SESSION" => "N",
        "SECTION_CODE" => "",
        "SECTION_DESCRIPTION" => "-",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_TITLE" => "-",
        "SEF_MODE" => "N",
        "TEMPLATE_THEME" => "blue",
        "XML_EXPORT" => "N"
    )
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>