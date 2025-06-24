<?
AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
{
    if(CModule::IncludeModule("sale") && CModule::IncludeModule("iblock"))
    {
        $dbBasketItem = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array("ORDER_ID" => $orderID),
            false,
            false,
            array("PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY")
        );
        $arElement = [];
        while($arOrder = $dbBasketItem->Fetch()) {
            $arElement = CIBlockElement::GetList(
                [],
                ["ID" => $arOrder["PRODUCT_ID"]],
                false,
                false,
                ["ID", "DETAIL_PICTURE"]
            );

        }
        $arPicture = [];
        while($ob = $arElement->GetNextElement())
        {
            $arPicture = $ob->GetFields();
        }
        $imgSrc = CFile::GetPath($arPicture["DETAIL_PICTURE"]);
        $arFields["ORDER_LIST"] .= '<img src="'.$imgSrc.'">';




    }
}