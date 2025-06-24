<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';



$strReturn .= '<div class="container container-42" > <ul class="breadcrumb">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '<li id="bx_breadcrumb_'.$index.'">
		                <a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>
				       </li>';
	}
	else
	{
		$strReturn .= '<li  class="active">'.$title.'</li>';
	}
}

$strReturn .= '<div style="clear:both"></div></ul></div>';

return $strReturn;
?>
