<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    Bitrix\Main\Loader;

$request = Application::getInstance()->getContext()->getRequest();
if (!$request->isAjaxRequest()) {
    die();
}

Loader::includeModule('catalog');

$productId = $request->getPost('product_id');
$quantity = $request->getPost('quantity');
Add2BasketByProductID($productId, $quantity);