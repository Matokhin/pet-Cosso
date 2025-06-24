<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<nav class="navbar main-menu">
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav js-menubar">

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="level1 active dropdown"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                <span class="plus js-plus-icon"></span>
				<ul class="dropdown-menu menu-level-1">
		<?else:?>
			<li<?if ($arItem["SELECTED"]):?> class="level2"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?></a>
              <ul>
		<?endif?>

	<?else:?>
			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="level1 active hassub"><a href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
                    <span class="plus js-plus-icon"></span>
                </li>

			<?else:?>
				<li<?if ($arItem["SELECTED"]):?> class="level2"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>
	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

        </ul>
    </div>
</nav>
<?endif?>

