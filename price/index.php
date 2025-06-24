<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товары");

require($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
$arFilter = Array('IBLOCK_ID' => 2);
$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();?>

<form class="section ajax_form" style="padding: 0 20px;">
    <?
    while ($ar_result = $db_list->GetNext()) {?>

    <span class="checkbox-wrapper">
        <input type="checkbox" data-id="<?=$ar_result['ID']?>">  <?=$ar_result['NAME'] . ' (' . $ar_result['ELEMENT_CNT'] . ') <br>';?>
    </span>
    <?

    if(isset($_POST["section_ids"])) {
        $linkStyle = [
            'font'  => array(
                'color' => array('rgb' => '0000FF'),
                'underline' => 'single'
            )
        ];

        $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_ARTNUMBER", "CATALOG_PRICE_1", "CATALOG_CURRENCY_1");
        $arFilter = Array("IBLOCK_ID" => 2, "SECTION_ID" => $_POST["section_ids"], "ACTIVE" => "Y", "PRODUCT_ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);

        $sheet
            ->setCellValue('A1', 'Артикул')
            ->setCellValue('B1', 'Название товара')
            ->setCellValue('C1', 'Цена')
            ->setCellValue('D1', 'Валюта')
            ->setCellValue('E1', 'Ссылка');
        $row = 2;
        while ($ob = $res->GetNext()) {
            $link = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $ob['DETAIL_PAGE_URL'];
            $sheet
                ->setCellValue("A{$row}", $ob["PROPERTY_ARTNUMBER_VALUE"])
                ->setCellValue("B{$row}", $ob["NAME"])
                ->setCellValue("C{$row}", $ob["CATALOG_PRICE_1"])
                ->setCellValue("D{$row}", $ob["CATALOG_CURRENCY_1"])
                ->setCellValue("E{$row}", $link)->getCell("E{$row}")->getHyperlink()->setUrl($link);
            $sheet->getStyle("E{$row}")->applyFromArray($linkStyle);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal('left');
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal('left');
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:E{$row}")->getFill()->setFillType('solid');
                $sheet->getStyle("A{$row}:E{$row}")->getFill()->getStartColor()->setARGB('E8E8E8E8');
            }
            $row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $writer = new Xls($spreadsheet);
        $writer->save($_SERVER["DOCUMENT_ROOT"] . '/upload/xml_files/xml_file.xls');
    }
}?>
    <br>
    <input type="submit"  id="form-submit" value="Сформировать xls-файл с товарами в наличии"> <br><br>


</form>

<div style="padding: 20px;">
    <a href='#' download style="display: none;padding: 10px 20px; border:1px solid #ccc; border-radius: 5px;"  id="download" >Скачать файл</a>
</div>


<script>
    $('#checkbox').click(function() {
        this.parent('span').addClass('selected');
    });
    $(".ajax_form").submit(function(e) {
        e.preventDefault();
        let sections = $('form.ajax_form input:checked');
        if (sections.length) {
            let sectionIds = [];
            sections.each(function (){
                sectionIds.push($(this).data('id'));
            });
            $.ajax({
                type: "POST",
                url: this.action,
                data: {section_ids : sectionIds},
                success: function()
                {
                    $('#download').attr('href', '/upload/xml_files/xml_file.xls').css('display', 'inline-block');
                }
            });
        }
    });
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>