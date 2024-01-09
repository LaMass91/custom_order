<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$this->setFrameMode(true);
	global $USER;
	if($USER->IsAdmin())
	{
		//echo "<pre style='color:#02f702; background:#414354;'>";print_r($arResult["ITEMS"]);echo "</pre>";
	}

?>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
<p class="back-to">
	<? if(is_array($arResult["ITEMS"]["AnDelCanBuy"]) && count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
		<a href="javascript:void(0);" class="delete_all">Очистить корзину</a>
	<? endif;?>
	<a href="/#main-mobile-menu" class="back-to">
		<span class="icon-slider-arrow"></span>Вернуться в каталог
	</a>
</p>

<div id="order_form_div">
	<div class="order_prop_error">
		<?
			if ('' != $arResult["ERROR_MESSAGE"])
			{
				ShowNote($arResult["ERROR_MESSAGE"]);
				echo '<br/>';
			}
		?>
	</div>
<?
	if (isset($arResult["ORDER_BASKET"]["CONFIRM_ORDER"]) && $arResult["ORDER_BASKET"]["CONFIRM_ORDER"] == "Y")
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_confirm.php");
	} else {
?>
        <form method="POST" action="<?=$APPLICATION->GetCurPage();?>" class="basket-site-form" enctype="multipart/form-data" onsubmit="ym(34786855,'reachGoal','otpravka_vse_formy')">
            <input type="hidden" name="form" value="Y" />
            <?=bitrix_sessid_post()?>
            <? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");?>
            <?if(count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
                <? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_person_type.php");?>
                <? include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_props.php");?>
            <?endif;?>
			
        </form>
<? } ?>
</div>