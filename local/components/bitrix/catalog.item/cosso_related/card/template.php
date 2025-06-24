11111111<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>
<div class="col-md-15 col-sm-3 col-xs-6 product-item">
    <div class="product-images">
        <a href="<?=$item['DETAIL_PAGE_URL']?>" class="hover-images effect"><img src="<?=$item['PREVIEW_PICTURE']['SRC'];?>" alt="photo" class="img-reponsive"></a>
        <?if(!empty($item['PROPERTIES']['SALELEADER']['VALUE'])):?>
            <div class="ribbon-sale ver2"><span><?=$item['PROPERTIES']['SALELEADER']['NAME']?></span></div>
        <?endif;?>
        <a href="#" class="btn-add-wishlist ver2"><i class="icon-heart"></i></a>
        <a href="<?=$item['DETAIL_PAGE_URL']?>" class="btn-quickview">QUICK VIEW</a>
    </div>
    <div class="product-info-ver2">
        <h3 class="product-title"><a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME'];?></a></h3>
        <div class="product-after-switch">
            <div class="product-price"><?=$price['PRINT_BASE_PRICE'];?></div>
            <div class="product-after-button">
                <a href="<?=$item['ADD_URL'];?>" class="addcart">ADD TO CART</a>
            </div>
        </div>
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:iblock.vote',
            'stars',
            array(
                'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                'IBLOCK_TYPE' => $item['IBLOCK_TYPE'],
                'IBLOCK_ID' => $item['IBLOCK_ID'],
                'ELEMENT_ID' => $item['ID'],
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
        ?>

        <p class="product-desc"><?=$item['PREVIEW_TEXT'];?></p>
        <div class="product-price"><?=$price;?></div>
        <div class="button-group">
            <a href="<?=$item['ADD_URL'];?>" class="button add-to-cart">Add to cart</a>
            <a href="#" class="button add-to-wishlist">Add to wishlist</a>
            <a href="<?=$item['DETAIL_PAGE_URL']?>>" class="button add-view">Quick view</a>
        </div>
    </div>
</div>


