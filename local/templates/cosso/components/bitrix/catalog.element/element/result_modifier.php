<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

/*$quantity= $_POST['quantity'];
$price = $_POST['price'];
$id = $_POST['id'];
if( !empty($quantity))
{
    if (CModule::IncludeModule("catalog"))
    {
        Add2BasketByProductID(
            $id,
            $quantity,
            array()
        );
    }
}*/