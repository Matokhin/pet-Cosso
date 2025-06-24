<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    Bitrix\Main\Loader;

$request = Application::getInstance()->getContext()->getRequest();
if (!$request->isAjaxRequest()) {
    die();
}

Loader::includeModule('iblock');

$color = $request->getPost('color');
$clothesSize = $request->getPost('cloth_size');
$shoesSize = $request->getPost('shoes_size');
$productId = $request->getPost('product_id');

$arFilter = Array("IBLOCK_ID" => 3, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK" => $productId, "PROPERTY_COLOR_REF" => $color, "PROPERTY_SIZES_CLOTHES_VALUE" => $clothesSize, "PROPERTY_SIZES_SHOES_VALUE" => $shoesSize);
$res = CIBlockElement::GetList(array(), $arFilter, false, array(), array("ID", "NAME"));
$ob = $res->fetch();
echo $ob['ID'];