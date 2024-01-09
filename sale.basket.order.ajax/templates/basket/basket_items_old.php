<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//dump($arResult["ITEMS"]["AnDelCanBuy"]);?>
<div class="basket-wr">
	<?if(count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
        <div class="basket-head">
            <div class="b-item-pic">Фото</div>
	        <div class="b-name">Название</div>
	        <div class="catalog_available">В наличии</div>
	        <?/*
            <?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
                <div class="b-price">Цена за штуку</div>
            <?endif;?>
            <?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
                <div class="b-quantity">Количество</div>
            <?endif;?>
            <?if (in_array("TOTAL_PRICE", $arParams["COLUMNS_LIST"])):?>
                <div class="b-total-price">Итоговая цена</div>
            <?endif;?>
            <?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
                <div class="b-del"></div>
            <?endif;?>
			*/?>
        </div>
        <div class="basket-body">
		<?
		$i=0;
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
		{
			?>
            <div class="basket-row js-basket-item" data-id="<?=$arBasketItems["ID"];?>">
                <div class="b-item">
                    <div class="b-item-pic">
	                    <a href="<?=$arBasketItems["DETAIL_PAGE_URL"];?>">
		                    <? if (!empty($arBasketItems["IMAGE"]["src"])) { ?>
	                                <img src="<?=$arBasketItems["IMAGE"]["src"];?>" width="<?=$arBasketItems["IMAGE"]["width"];?>" alt="<?=$arBasketItems["NAME"];?>">
		                    <? } else { ?>
			                    <img src="/img/alyans-cabel-logo-small-gray.png" width="55" height="55" alt="">
		                    <? } ?>
	                    </a>
                    </div>
                    <div class="b-item-info">
	                    <div class="b-item-info-table">
		                    <div class="b-name">
			                    <a href="<?=$arBasketItems["DETAIL_PAGE_URL"];?>"><?=$arBasketItems["NAME"];?></a>
		                    </div>
		                    <? if (in_array('PROPS', $arParams['COLUMNS_LIST'])) { ?>
			                    <? foreach ($arBasketItems['PROPS'] as $val) { ?>
				                    <div class="<?=strtolower($val['NAME']);?>"><?=$val['VALUE'];?></div>
			                    <? } ?>
		                    <? } ?>
	                    </div>
                    </div>
                </div>
                <?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
                    <div class="b-price js-price">
                        <?if ($arBasketItems["PRICE"] <= 0):?>
                            <span class="orange">на заказ</span>
                        <?else:?>
                            <?=$arBasketItems["PRICE_FORMATED"]?>
                        <?endif;?>
                    </div>
                <?endif;?>
                <?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
                    <div class="b-quantity">
                        <div class="quantity js-quantity">
                            <input type="number" <?if($arBasketItems['MAX_QUANTITY'] > 0):?>data-maxVal="<?=$arBasketItems['MAX_QUANTITY']?>"<?endif;?>
                                   value="<?if($arBasketItems['MAX_QUANTITY'] > 0 && $arBasketItems["QUANTITY"] > $arBasketItems['MAX_QUANTITY']){echo $arBasketItems['MAX_QUANTITY'];}else{echo $arBasketItems["QUANTITY"];}?>"
                                   name="quantity">
                            <span class="plus js-quantity-plus" data-type="plus"><span class="site-icon-math"><span class="path1"></span><span class="path2"></span></span></span>
                            <span class="minus js-quantity-minus" data-type="minus"><span class="site-icon-math"><span class="path1"></span></span></span>
                        </div>
                    </div>
                <?endif;?>
                <?if (in_array("TOTAL_PRICE", $arParams["COLUMNS_LIST"])):?>
                    <?$totalPrice = $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];?>
                    <div class="b-total-price" data-cost="<?=$totalPrice;?>">
                        <?if ($arBasketItems["PRICE"] <= 0):?>
                            <span class="orange">на заказ</span>
                        <?else:?>
                            <?=CurrencyFormat($totalPrice, $arBasketItems["CURRENCY"]);?>
                        <?endif;?>
                    </div>
                <?endif;?>
                <?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
                    <div class="b-del"><a href="<?=$APPLICATION->GetCurPage().'?action=delete&id='.$arBasketItems["ID"];?>" class="site-icon-delete" title="Удалить товар"><span class="icon-close"></span></a></div>
                <?endif;?>
            </div>
			<?
			$i++;
		}
		?>
		</div>
	<?else:
		echo ShowNote(GetMessage("SALE_NO_ACTIVE_PRD"));
	endif;?>

</div>
