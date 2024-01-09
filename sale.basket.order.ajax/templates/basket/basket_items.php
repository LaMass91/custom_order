<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//dump($arResult["ITEMS"]["AnDelCanBuy"]);?>
<div class="basket-wr">
	<?if(count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
        <div class="basket-body">
            <div class="hdr_bskt">
                <div>Фото</div>
                <div>Название</div>
                <div class="nn">Цена</div>
                <div class="nn">Количество</div>
                <div class="nn">Сумма</div>
                <div class="nn">Удалить</div>
            </div>
		<?
		$i=0;
		foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
		{
           
			?>
            <div class="basket-row js-basket-item" data-id="<?=$arBasketItems["ID"];?>" data-product="<?=$arBasketItems["PRODUCT_ID"];?>" data-price_group="<?=$arBasketItems["CATALOG_GROUP_ID"];?>">
            
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
		                    <? /*if (in_array('PROPS', $arParams['COLUMNS_LIST'])) { ?>
			                    <? foreach ($arBasketItems['PROPS'] as $val) { ?>
				                    <div class="<?=strtolower($val['NAME']);?>"><span><?=$val['NAME'];?>: </span><?=$val['VALUE'];?></div>
			                    <? } ?>
		                    <? } */?>
	                    </div>
                    </div>
                <div class="b-price js-price" data-price="<?=round($arBasketItems["BASE_PRICE"], 2);?>">
                    <?if ($arBasketItems["PRICE"] <= 0):?>
                        <span class="orange">Уточняйте</span>
                    <?else:?>
                        <span class="ins_p"><?=CurrencyFormat($arBasketItems["BASE_PRICE"], $arBasketItems["CURRENCY"]);?></span>/<?=$arBasketItems["MEASURE_NAME"]?>
                    <?endif;?>
                </div>
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
                <?$totalPrice = $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];?>
                <?$totalPrice = round($totalPrice, 2);?>
                <div class="b-total-price">
                    <?if ($arBasketItems["PRICE"] <= 0):?>
                        <span class="orange">на заказ</span>
                    <?else:?>
                        <?=CurrencyFormat($totalPrice, $arBasketItems["CURRENCY"]);?>
                    <?endif;?>
                </div>

                <?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
                    <div class="b-del"><a href="<?=$APPLICATION->GetCurPage().'?action=delete&id='.$arBasketItems["ID"];?>" class="site-icon-delete" title="Удалить товар"><span class="icon-close"></span></a></div>
                <?endif;?>
                <?$totalPrices += $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];?>
            </div>
			<?
			$i++;
		}
        $totalPrices = round($totalPrices, 2);
		?>
        <!--<span class="basket-big-wr__"><a href="#" class="delete_all">Очистить корзину</a></span>-->

            
       
		</div>
	<?else:
		echo ShowNote(GetMessage("SALE_NO_ACTIVE_PRD"));
	endif;?>

</div>
