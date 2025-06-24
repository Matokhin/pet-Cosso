<?
if (php_sapi_name() !== 'cli') die();
$www_path = realpath(dirname(__FILE__).'/../');
$_SERVER["DOCUMENT_ROOT"] = $www_path;
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Highloadblock as HL;

CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');
$xml =  simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/upload/feed-yml-0.xml', null, LIBXML_NOCDATA);

if ($xml === false) {
    echo "There were errors parsing the XML file.\n";
    foreach(libxml_get_errors() as $error) {
        echo $error->message;
    }
    exit;
}
$objJsonDocument = json_encode($xml);
$arrOutput = json_decode($objJsonDocument, TRUE);

$el = new CIBlockElement;

$brandHLBlock = HL\HighloadBlockTable::getById(3)->fetch();
$brandHLBlockEntity = HL\HighloadBlockTable::compileEntity($brandHLBlock);



$arFields = [];
foreach ($arrOutput['shop']['offers']['offer'] as $product){
    if($product['categoryId'] != 82) {
        continue;
    }
    $arFields['CATALOG_QUANTITY'] = $product['param'];
    $arFields['IBLOCK_ID'] = 2;
    $arFields['CODE'] = Cutil::translit($product['name'],"ru",array("replace_space"=>"-","replace_other"=>"_"));
    $arFields["IBLOCK_SECTION_ID"] = 16;
    $arFields['NAME'] = $product['name'];
    $arFields['DETAIL_TEXT'] = $product['description'];
    $arFile = CFile::MakeFileArray($product['picture']);
    $arFields['DETAIL_PICTURE'] = $arFile;
    $arProps = array();
    $arProps[9] = $product["vendorCode"];
    if (isset($product["vendor"]) && !empty($product["vendor"]))
    {
        $main_query = new \Bitrix\Main\Entity\Query($brandHLBlockEntity);
        $main_query->setSelect(array('UF_XML_ID'));
        $main_query->setFilter(array('UF_NAME' => $product["vendor"]));
        $result = $main_query->exec();
        $result = new CDBResult($result);
        if($row = $result->Fetch())
        {
            $arProps[5][] = $row['UF_XML_ID'];
        } else {
            $xmlId = CUtil::translit($product["vendor"], 'ru', array('replace_space' => '_', 'replace_other' => '_'));

            $entity_data_class = $brandHLBlockEntity->getDataClass();
            $result = $entity_data_class::add(array(
                                                  'UF_NAME' => $product["vendor"],
                                                  'UF_XML_ID' => $xmlId,
                                              ));

            if ($result->isSuccess()) {
                $arProps[5][] = $xmlId;
            }
        }
    }
    $arFieldsLoad = $arFieldsUpdate = $arFields;
    $arFieldsLoad['PROPERTY_VALUES'] = $arProps;

    if ($ID = $el->Add($arFieldsLoad)) {
        CCatalogProduct::Add(array("ID" => $ID));
        $arPrice = Array(
            "CURRENCY"         => "RUB",
            "PRICE"            =>  $product['price'],
            "CATALOG_GROUP_ID" => 1,
            "PRODUCT_ID"       => $ID,
        );
        CPrice::Add($arPrice, true);
    } else {
        $ob = $res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 2, 'CODE' => $arFields['CODE']), false, array(), array('ID'))->fetch();
        $resUpdate = $el->Update($ob['ID'], $arFieldsUpdate);
        CIBlockElement::SetPropertyValuesEx($ob['ID'], false, $arProps);
        $resPrice = CPrice::GetList(
            array(),
            array(
                "PRODUCT_ID" => $ob['ID'],
                "CATALOG_GROUP_ID" => 1
            )
        );
        $arPrice = Array(
            "CURRENCY"         => "RUB",
            "PRICE"            => $product['price'],
            "CATALOG_GROUP_ID" => 1,
            "PRODUCT_ID"       => $ob['ID'],
        );
        if ($arr = $resPrice->Fetch())
        {
            CPrice::Update($arr["ID"], $arPrice);
        }
        else
        {
            CPrice::Add($arPrice);
        }
    }

}






