<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->SetTitle("Заказ успешно оформлен!");?>

<style>
    .success {
        background-color:#E4E4E4;
        text-align: center;
        width: 80%;
        margin: 50px auto;
        max-width: 500px;
        padding: 30px 0 30px;
        font-size: 30px;
        border-radius: 10px;
    }
</style>

<div class="success">Заказ успешно оформлен!</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>