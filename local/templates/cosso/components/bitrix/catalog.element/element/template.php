<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DESCRIPTION_ID' => $mainId.'_description',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] > 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
        {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}
?>
    <div class="container">
    <div class="single-product-detail product-bundle product-aff space-50" id="<?=$itemIds['ID']?>">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-6">
                        <div  id="<?=$itemIds['BIG_SLIDER_ID']?>" class="product-item-detail-slider-block product-images"
                             data-entity="images-slider-block">
                            <div  data-entity="images-container">
                                    <div class="main-img js-product-slider">
                                    <?php
                                    if (!empty($actualItem['MORE_PHOTO']))
                                    {
                                        foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                        {
                                            ?>
                                            <a class="hover-images effect" data-entity="image" data-id="<?=$file['ID']?>">
                                                <img class="img-reponsive" src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($showSliderControls)
                        {
                            ?>
                            <div class="multiple-img-list-ver2 js-click-product">
                            <?
                            $i = 1;
                                foreach ($arResult['OFFERS'] as $keyOffer => $offer)
                                {
                                    if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
                                        continue;

                                    $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                                    ?>
                                <div  class="product-col" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
                                        <?php
                                        foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
                                        {
                                            ?>
                                            <a class="img"
                                                 data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
                                                <img alt="photo" class="img-reponsive" src="<?=$photo['SRC']?>">
                                            </a>
                                            <?php
                                        }
                                        ?>
                                </div>
                                    <?php
                                    $i++;
                                    if($i > 1) {
                                        break;
                                    }
                                }
                        }?></div><?
                        ?>
                    </div>
                        <div class="col-xs-12 col-sm-7 col-md-6">
                            <div class="single-product-info">
                                <?php

                                    if ($arParams['USE_VOTE_RATING'] === 'Y')
                                    {
                                        ?>

                                            <?php
                                            $APPLICATION->IncludeComponent(
                                                'bitrix:iblock.vote',
                                                'bootstrap_v4',
                                                array(
                                                    'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                                                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                                    'ELEMENT_ID' => $arResult['ID'],
                                                    'ELEMENT_CODE' => '',
                                                    'MAX_VOTE' => '5',
                                                    'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                                    'SET_STATUS_404' => 'N',
                                                    'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                                    'CACHE_TIME' => $arParams['CACHE_TIME']
                                                ),
                                                $component,
                                                array('HIDE_ICONS' => 'Y')
                                            );

                                    }
                                    ?>
                                    <h3 class="product-title space-pm"><a href="#"><?=$arResult['NAME']?></a></h3>
                                    <div class="product-price">

                                        <span data-price="<?=$price['PRINT_RATIO_PRICE']?>" id="<?=$itemIds['PRICE_ID']?>">
                                            <?=$price['PRINT_RATIO_PRICE']?>
                                        </span>
                                    </div>
                                    <?php
                                    if ($haveOffers && !empty($arResult['OFFERS_PROP']))
                                    {
                                        ?>
                                            <?php
                                            foreach ($arResult['SKU_PROPS'] as $skuProperty)
                                            {
                                                if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                                    continue;
                                                $propertyId = $skuProperty['ID'];
                                                $skuProps[] = array(
                                                    'ID' => $propertyId,
                                                    'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                                    'VALUES' => $skuProperty['VALUES'],
                                                    'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                                );
                                                ?>
                                                <div class="form-group" id="<?=$itemIds['TREE_ID']?>">
                                                    <label><?=$skuProperty['NAME']?></label>
                                                    <select id="select_<?=strtolower($skuProperty['CODE'])?>" class="form-control js-offer-select" data-entity="sku-line-block">
                                                        <?php
                                                        foreach ($skuProperty['VALUES'] as &$value)
                                                        {
                                                            $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                                            $propId = ($skuProperty["PROPERTY_TYPE"] == 'S') ? $value["XML_ID"] : $value["NAME"];

                                                            ?>
                                                            <option  data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                    data-onevalue="<?=$propId?>">
                                                                <?=$value['NAME']?>
                                                            </option>
                                                            <?
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        <?php

                                    }?>
                                <div class="action">
                                <?
                                    if ($arParams['USE_PRODUCT_QUANTITY'])
                                    {
                                        ?>
                                        <div class="quantity"  data-entity="quantity-block">
                                            <button type="button" class="quantity-left-minus btn btn-number" data-type="minus" data-field="">
                                                <span class="minus-icon"  id="<?=$itemIds['QUANTITY_DOWN_ID']?>">-</span>
                                            </button>
                                            <input class="product_quantity_number js-number" name="number" id="<?=$itemIds['QUANTITY_ID']?>" type="text"
                                            value="<?=$price['MIN_QUANTITY']?>">
                                            <button type="button" class="quantity-right-plus btn btn-number" data-type="plus" data-field="">
                                                <span class="plus-icon" id="<?=$itemIds['QUANTITY_UP_ID']?>">+</span>
                                            </button>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                    <div data-entity="main-button-container">
                                        <div style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                            <a class="link-ver1 add-cart"
                                               data-offer="<?=$offer['ID']?>"
                                               data-quantity="<?=$price['MIN_QUANTITY']?>">
                                                <?=$arParams['MESS_BTN_ADD_TO_BASKET']?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>


        <meta itemprop="name" content="<?=$name?>" />
        <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
        <?php
        if ($haveOffers)
        {
            foreach ($arResult['JS_OFFERS'] as $offer)
            {
                $currentOffersList = array();

                if (!empty($offer['TREE']) && is_array($offer['TREE']))
                {
                    foreach ($offer['TREE'] as $propName => $skuId)
                    {
                        $propId = (int)mb_substr($propName, 5);

                        foreach ($skuProps as $prop)
                        {
                            if ($prop['ID'] == $propId)
                            {
                                foreach ($prop['VALUES'] as $propId => $propValue)
                                {
                                    if ($propId == $skuId)
                                    {
                                        $currentOffersList[] = $propValue['NAME'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                ?>
                <?php
            }

            unset($offerPrice, $currentOffersList);
        }
        else
        {
            ?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
            <?php
        }
        ?>
    </div>
<?php
if ($haveOffers)
{
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
    {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS'])
        {
            if (!empty($jsOffer['DISPLAY_PROPERTIES']))
            {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
                {
                    $current = '<dt>'.$property['NAME'].'</dt><dd>'.(
                        is_array($property['VALUE'])
                            ? implode(' / ', $property['VALUE'])
                            : $property['VALUE']
                        ).'</dd>';
                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
                    {
                        $strMainProps .= $current;
                    }
                }

                unset($current);
            }
        }

        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
        {
            $strPriceRangesRatio = '('.Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ).' '.$measureName)
                ).')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
            {
                if ($range['HASH'] !== 'ZERO-INF')
                {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
                    {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                        {
                            break;
                        }
                    }

                    if ($itemPrice)
                    {
                        $strPriceRanges .= '<dt>'.Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
                            ).' ';

                        if (is_infinite($range['SORT_TO']))
                        {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        }
                        else
                        {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'].' '.$measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null,
            'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
            'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
        ),
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH'],
            'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
            'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
            'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
            'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps
    );
}
else
{
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
    {
        ?>
        <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
            <?php
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
            {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
                {
                    ?>
                    <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                    <?php
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties)
            {
                ?>
                <table>
                    <?php
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
                    {
                        ?>
                        <tr>
                            <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
                            <td>
                                <?php
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                )
                                {
                                    foreach ($propInfo['VALUES'] as $valueId => $value)
                                    {
                                        ?>
                                        <label>
                                            <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                                                   value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
                                            <?=$value?>
                                        </label>
                                        <br>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
                                        <?php
                                        foreach ($propInfo['VALUES'] as $valueId => $value)
                                        {
                                            ?>
                                            <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
                                                <?=$value?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
        <?php
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}
?>
    <div class="single-product-tab ver2">
        <ul class="nav nav-tabs text-center">
            <li class="active"><a data-toggle="pill" href="#desc">Description</a></li>
            <li><a data-toggle="pill" href="#info">Additional Information</a></li>
            <li><a data-toggle="pill" href="#review">Reviews (1)</a></li>
        </ul>
        <div class="tab-content">
            <div id="desc" class="tab-pane fade in active">
                <div class="tab-simple">
                    <p class="p-center space-padding-tb-20"><?=$arResult['DETAIL_TEXT']?></p>
                </div>
            </div>
            <div id="info" class="tab-pane fade in">
                <div class="p-center space-padding-tb-20">
                    <span><?=$arResult['PROPERTIES']['ARTNUMBER']['NAME']?> : <?=$arResult['PROPERTIES']['ARTNUMBER']['VALUE']?></span>
                </div>
                <div class="p-center space-padding-tb-20">
                    <span><?=$arResult['PROPERTIES']['MANUFACTURER']['NAME']?> : <?=$arResult['PROPERTIES']['MANUFACTURER']['VALUE']?></span>
                </div>
                <div class="p-center space-padding-tb-20">
                    <span><?=$arResult['PROPERTIES']['MATERIAL']['NAME']?> :
                        <?
                         foreach ($arResult['PROPERTIES']['MATERIAL']['VALUE'] as $arItem) {
                            echo $arItem;
                        }
                        ?>
                    </span>
                </div>
                <div class="p-center space-padding-tb-20">
                    <span><?=$arResult['PROPERTIES']['ARTNUMBER']['NAME']?> : <?=$arResult['PROPERTIES']['ARTNUMBER']['VALUE']?></span>
                </div>

            </div>
            <div id="review" class="tab-pane fade in ">

            <?

            $componentCommentsParams = array(
                'ELEMENT_ID' => $arResult['ID'],
                'ELEMENT_CODE' => '',
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
                'URL_TO_COMMENT' => '',
                'WIDTH' => '',
                'COMMENTS_COUNT' => '5',
                'BLOG_USE' => $arParams['BLOG_USE'],
                'FB_USE' => $arParams['FB_USE'],
                'FB_APP_ID' => $arParams['FB_APP_ID'],
                'VK_USE' => $arParams['VK_USE'],
                'VK_API_ID' => $arParams['VK_API_ID'],
                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                'CACHE_TIME' => $arParams['CACHE_TIME'],
                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                'BLOG_TITLE' => '',
                'BLOG_URL' => $arParams['BLOG_URL'],
                'PATH_TO_SMILE' => '',
                'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
                'AJAX_POST' => 'Y',
                'SHOW_SPAM' => 'Y',
                'SHOW_RATING' => 'N',
                'FB_TITLE' => '',
                'FB_USER_ADMIN_ID' => '',
                'FB_COLORSCHEME' => 'light',
                'FB_ORDER_BY' => 'reverse_time',
                'VK_TITLE' => '',
                'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
            );
            if (isset($arParams["USER_CONSENT"]))
                $componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
            if (isset($arParams["USER_CONSENT_ID"]))
                $componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
            if (isset($arParams["USER_CONSENT_IS_CHECKED"]))
                $componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
            if (isset($arParams["USER_CONSENT_IS_LOADED"]))
                $componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.comments',
                '',
                $componentCommentsParams,
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>


            </div>
        </div>
    </div>
    <!--single-product-tab-->
    <div class="information">
        <ul>
            <li class="info-center text-center"><span><?=$arResult['PROPERTIES']['ARTNUMBER']['NAME']?> :</span>
                <a href=""><?=$arResult['PROPERTIES']['ARTNUMBER']['VALUE']?></a>
            </li>
            <li class="info-center bd-rl text-center"><span>Раздел :</span>
                <a href="">
                    <?
                    $res = CIBlockElement::GetByID($arResult['ID']);
                    if($arRes = $res->Fetch())
                    {
                        $res = CIBlockSection::GetByID($arRes["IBLOCK_SECTION_ID"]);
                        if($arRes = $res->Fetch())
                        {
                            echo $arRes["NAME"];
                        }
                    }
                    ?>
                </a>
            </li>
            <li class="info-center text-center"><span><?=$arResult['PROPERTIES']['META_DESCRIPTION']['NAME']?> :</span>
                <a href=""<?=$arResult['PROPERTIES']['META_DESCRIPTION']['VALUE']?></a>
            </li>
        </ul>
    </div>
    <div class="product-related">
        <div class="container container-42">
            <h3 class="title text-center">Related Products</h3>


        </div>
    </div>

    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        /*var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);*/
    </script>
<?php
unset($actualItem, $itemIds, $jsParams);
