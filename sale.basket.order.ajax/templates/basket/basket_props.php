<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//pre($_POST['user_type']);
	if($USER->IsAdmin())
	{
		//echo "<pre style='color:#02f702; background:#414354;'>";print_r($arResult['ORDER_PROPS']);echo "</pre>";
		//echo "<pre style='color:#02f702; background:#414354;'>";print_r($_REQUEST);echo "</pre>";
	}
	if (!function_exists('PrintPropsForm'))
	{
		function PrintPropsForm($arSource=array(), $PERSON_TYPE_ID)
		{
			if (!empty($arSource))
			{
				$hasError = false;
				foreach($arSource as $key => $arProp)
				{
					if($PERSON_TYPE_ID == 1 && ($arProp['ID'] == 5 || $arProp['ID'] == 6)){
						continue;
					}
					if($arProp['ID'] == 5 || $arProp['ID'] == 6){
						$arProp['REQUIED_FORMATED'] = 'Y';
					}
					//pre($PERSON_TYPE_ID);
					//if($arProp['PROPS_GROUP_ID'] == $PERSON_TYPE_ID){
					switch($arProp['TYPE'])
					{
						case 'TEXT':
							?>
							<div class="row">
								<? /*if($arProp['REQUIED_FORMATED']=='Y'):?>*<? endif;*/?>
								<?
									switch($arProp['TYPE'])
									{
										case 'TEXT':
											if(isset($_REQUEST) && !empty($_REQUEST))
											{
												if(isset($_REQUEST['ORDER_PROP_'.$arProp['ID']]) && empty($_REQUEST['ORDER_PROP_'.$arProp['ID']]) && $arProp['REQUIED_FORMATED']=='Y')
												{
													$hasError = true;
												}
											}
											?>
											<input tabindex=<?=$arProp['ID'];?>
												<?=($hasError === true)?'class="error_input"':'';?>
												type="text" value="<?=$arProp['VALUE'];?>"
												name="<?=$arProp['FIELD_NAME'];?>" id="<?=$arProp['FIELD_NAME'];?>"
												placeholder="<?=$arProp["NAME"]?><? if($arProp['REQUIED_FORMATED']=='Y'):?>*<? endif;?>" />
											<?
											break;
									}
								?>
							</div>
							<?
							break;
					}
				//}
				}
				return true;
			}
			return false;
		}
	}
?>

<div class="order-site-form">
    <div class="hidden">
        <select name="PROFILE_ID" id="ID_PROFILE_ID">
            <option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
            <?
            $default = "0";
            foreach($arResult["USER_PROFILES"] as $key => $arUserProfiles)
            {
                ?><option value="<?=$key?>"<?if ($arUserProfiles["CHECKED"]=="Y") {echo " selected";$default=$key;}?>><?=$arUserProfiles["NAME"]?></option><?
            }
            ?>
        </select>
        <input type="hidden" name="PROFILE_ID_OLD" value="<?=$default?>" />
    </div>
    <div class="order-wr">
        <div class="left-col">
			<div class="tabs">
			
				<ul class="tabs__caption">
					<li data-type="1">Физ. лицо</li>
					<li data-type="2" class="active">Юр. лицо</li>
				</ul>
				
            <?//pre($arResult['ORDER_PROPS'])?>

			<div class="tabs__content active">
			<?
				//PrintPropsForm($arResult['ORDER_PROPS']['USER_PROPS_N'], 1);
				PrintPropsForm($arResult['ORDER_PROPS']['USER_PROPS_Y'], 3);
			?>
			</div>
          <div class="bottom_form_order">
                <textarea tabindex=4 name="ORDER_DESCRIPTION" placeholder="<?=\Bitrix\Main\Localization\Loc::getMessage("PH_ORDER_DESCRIPTION")?>"><?=$arResult["ORDER_DESCRIPTION"]?></textarea>
            
			<?
				foreach($arResult['ORDER_PROPS']['USER_PROPS_Y'] as $prop)
				{
					if($prop['TYPE'] == 'FILE')
					{
						if($USER->IsAdmin())
						{
							//echo "<pre style='color:#02f702; background:#414354;'>";print_r($prop);echo "</pre>";
						}
						?>
						<div class="cart__file">
							<svg class="cart__file__icon" viewBox="0 0 14 14">
								<path d="M0 8.5007C0.0423879 8.26227 0.0582833 8.02384 0.116567 7.7907C0.312611 6.95354 0.720595 6.23295 1.32462 5.62892C3.12611 3.82213 4.9276 2.02064 6.73439 0.219157C7.11588 -0.162335 7.69871 -0.0245732 7.83117 0.468187C7.88416 0.664231 7.85237 0.849679 7.7252 1.00863C7.68281 1.06692 7.62983 1.1199 7.57685 1.16759C5.80715 2.93729 4.04275 4.70168 2.27305 6.47138C1.89156 6.85287 1.61074 7.28735 1.43059 7.796C1.0385 8.91928 1.3935 10.3075 2.27835 11.1023C3.30626 12.0242 4.62559 12.2202 5.86543 11.6321C6.19924 11.4732 6.48536 11.2506 6.74498 10.991C8.53587 9.2001 10.3215 7.40391 12.1177 5.62362C13.0396 4.71228 12.8647 3.21281 11.7627 2.57169C11.0739 2.1743 10.1731 2.25378 9.56908 2.77833C9.52669 2.81542 9.479 2.85781 9.43662 2.90019C7.78879 4.54803 6.14095 6.19586 4.49312 7.84899C4.2229 8.11921 4.19111 8.46361 4.40305 8.73384C4.61499 8.99876 5.00178 9.05175 5.272 8.8504C5.33028 8.80802 5.38327 8.75503 5.43625 8.70204C6.49065 7.64764 7.55035 6.58795 8.60475 5.53355C8.88027 5.25802 9.23527 5.22623 9.5002 5.44347C9.77572 5.67131 9.81281 6.0581 9.59027 6.33362C9.55848 6.37071 9.52669 6.4078 9.4896 6.44489C8.4246 7.50988 7.35961 8.58018 6.29461 9.63988C5.67469 10.2545 4.83223 10.4082 4.07454 10.0479C2.95126 9.51271 2.64395 8.01854 3.46521 7.086C3.5129 7.03302 3.56059 6.98003 3.61357 6.92705C5.24551 5.29511 6.87744 3.66318 8.50938 2.03124C9.09751 1.44311 9.79162 1.09341 10.6288 1.05632C11.7415 1.00333 12.6581 1.41132 13.331 2.29087C14.1682 3.38236 14.2159 4.76526 13.4953 5.93623C13.3628 6.15347 13.1932 6.34421 13.0131 6.52436C11.2275 8.30996 9.44721 10.0903 7.66162 11.8758C7.00461 12.5329 6.23103 12.9885 5.30909 13.1422C3.5235 13.4442 2.05052 12.8826 0.921938 11.4679C0.38679 10.8002 0.10597 10.0214 0.0317913 9.17361C0.0264928 9.13652 0.0158953 9.10473 0.0105968 9.06764C-1.61855e-07 8.88219 0 8.69145 0 8.5007Z"/>
							</svg>
<? $APPLICATION->IncludeComponent("bitrix:main.file.input", "dmp", array(
	"INPUT_NAME" 		=> $prop['FIELD_NAME'],
	"MULTIPLE" 			=> "Y",
	"MODULE_ID" 		=> "iblock",
	"MAX_FILE_SIZE" 	=> "5242880", // 5мб
	"ALLOW_UPLOAD" 		=> "A",
	"ALLOW_UPLOAD_EXT" 	=> "pdf,doc,jpg,jpeg,png",
), false, ['HIDE_ICONS'=>'Y', 'ACTIVE_COMPONENT'=>'Y']);?>
						</div>
						<?
					}
				}
			?>
			</div>
			</div>
        </div>
        <div class="right-col">
            <div class="row clearfix">
			<div class="total-price">
			Итого: <span class="itog_sum"><?=CurrencyFormat($totalPrices, $arBasketItems["CURRENCY"]);?></span>
			</div>
                <?/*$APPLICATION->AddHeadScript('https://www.google.com/recaptcha/api.js');*/?>
                <div id="recaptcha1"></div>
                <?/*
                <script src="https://www.google.com/recaptcha/api.js"></script>
                <div class="g-recaptcha" data-sitekey="6LeGHhATAAAAAMbODsnj9DQ_-PpTePCukYwzMl02">
                    <? if ($arResult['RECAPTCHA']['ERROR'] == 'R') { ?>
                        <?=$arResult['RECAPTCHA']['MESSAGE'];?>
                    <? } ?>
                </div>
                */?>

              <?/*<label class="privacy-policy"><input type="checkbox" name="SECURED_PRIVACY_POLICY" checked /> <span>Согласен с обработкой моих<br>персональных данных в соответствии с<br>
			  <a href="/privacy-policy/">политикой конфиденциальности</a></span></?label>*/?>
              <input type="hidden" name="DELIVERY_ID" value="0">
              <input type="hidden" name="PAYSYSTEM_ID" value="1">
              <input tabindex=6 type="submit" onclick="yaCounter34786855.reachGoal('zakazupsehh'); return true;" value="<?=GetMessage("SALE_ORDER");?>" name="BasketOrder" class="fr" disabled="disabled">

			  <div class="personal_line">

				<input type="checkbox" name="personal_str">
				Согласен с обработкой моих персональных данных в соответствии с <a href="/privacy-policy/">политикой конфиденциальности</a>
			  </div>
            </div>
			
			<div class="order_link_wrapper">
				<a class="cart-element" href="/payment-and-delivery/" target="_blank">
					<div class="cart-element__icon">
						<svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.3573 7.45112C12.1802 7.45112 12.0366 7.59144 12.0366 7.76454V10.106C12.0366 10.2791 12.1802 10.4194 12.3573 10.4194H19.4126C19.5898 10.4194 19.7333 10.2791 19.7333 10.106V7.76454C19.7333 7.59144 19.5898 7.45112 19.4126 7.45112H12.3573ZM16.6829 0.000832053C17.6591 0.0472181 18.3616 0.240286 18.8054 0.648829C19.245 1.05343 19.4711 1.63941 19.5153 2.41415V4.63424C19.5153 5.02371 19.1922 5.33944 18.7937 5.33944C18.3952 5.33944 18.0722 5.02371 18.0722 4.63424L18.0733 2.45448C18.0497 2.05102 17.9538 1.80236 17.816 1.67556C17.6825 1.55271 17.2765 1.44111 16.6479 1.41041L2.80299 1.40988C2.23363 1.43146 1.86445 1.53925 1.68533 1.69263C1.54757 1.81058 1.4443 2.13472 1.44313 2.69475L1.43992 15.1568C1.49269 15.7016 1.61301 16.0642 1.76631 16.2457C1.88255 16.3833 2.24386 16.5215 2.77502 16.5881L16.6627 16.5883C17.3127 16.6013 17.6963 16.504 17.825 16.3735C17.9678 16.2287 18.0722 15.8476 18.0722 15.2233V13.0589C18.0722 12.6694 18.3952 12.3537 18.7937 12.3537C19.1922 12.3537 19.5153 12.6694 19.5153 13.0589V15.2233C19.5153 16.1777 19.3203 16.8896 18.8641 17.3522C18.3939 17.8291 17.6464 18.0187 16.6479 17.9986L2.68993 17.9936C1.73998 17.8834 1.05783 17.6224 0.653356 17.1435C0.285934 16.7085 0.0807411 16.0902 0 15.2233V2.69332C0.00193097 1.76615 0.224171 1.06859 0.734337 0.631766C1.20313 0.230366 1.87742 0.0334936 2.77502 0L16.6829 0.000832053ZM19.4126 6.04071C20.3868 6.04071 21.1765 6.8125 21.1765 7.76454V10.106C21.1765 11.058 20.3868 11.8298 19.4126 11.8298H12.3573C11.3832 11.8298 10.5935 11.058 10.5935 10.106V7.76454C10.5935 6.8125 11.3832 6.04071 12.3573 6.04071H19.4126ZM14.1212 8.0941C13.6341 8.0941 13.2392 8.47498 13.2392 8.94482C13.2392 9.41466 13.6341 9.79554 14.1212 9.79554C14.6082 9.79554 15.0031 9.41466 15.0031 8.94482C15.0031 8.47498 14.6082 8.0941 14.1212 8.0941Z" fill="#004877"/>
						</svg>
					</div>
					<div class="cart-element__text">Подробнее об оплате</div>
				</a>

				<a class="cart-element" href="/dostavka-i-samovyvoz/" target="_blank">
					<div class="cart-element__icon">
						<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20.8322 9.18293H19.9449L18.6776 5.35707C18.5773 5.05479 18.2948 4.85056 17.9763 4.85056H15.8296V1.32262C15.8296 0.914735 15.4988 0.583984 15.0909 0.583984H0.738779C0.330824 0.583984 0 0.914735 0 1.32262V14.2536C0 14.6616 0.330824 14.9924 0.738779 14.9924H1.45272C1.44117 15.1038 1.43514 15.2166 1.43514 15.3312C1.43514 17.1247 2.89331 18.584 4.68571 18.584C6.4779 18.584 7.93577 17.1247 7.93577 15.3312C7.93577 15.2166 7.92974 15.1038 7.9182 14.9924H14.3698C14.3583 15.1038 14.3522 15.2166 14.3522 15.3312C14.3522 17.1247 15.8104 18.584 17.603 18.584C19.3952 18.584 20.8533 17.1247 20.8533 15.3312C20.8533 15.2166 20.8473 15.1037 20.8356 14.9922C21.242 14.9904 21.5711 14.6605 21.5711 14.2536V9.92163C21.571 9.51382 21.2402 9.18293 20.8322 9.18293ZM17.4427 6.32804L18.3883 9.183H15.8296V6.32804H17.4427ZM4.68571 17.1065C3.70806 17.1065 2.91263 16.3101 2.91263 15.3312C2.91263 14.3521 3.70806 13.5558 4.68571 13.5558C5.66315 13.5558 6.45836 14.3521 6.45836 15.3312C6.45836 16.3101 5.66315 17.1065 4.68571 17.1065ZM14.3522 13.5149H7.38074C6.79623 12.6488 5.8063 12.0781 4.68571 12.0781C3.56483 12.0781 2.57476 12.6488 1.99017 13.5149H1.47756V2.06147H14.3522V13.5149ZM17.6029 17.1065C16.6251 17.1065 15.8296 16.3101 15.8296 15.3312C15.8296 14.3521 16.6251 13.5558 17.6029 13.5558C18.5804 13.5558 19.3758 14.3521 19.3758 15.3312C19.3758 16.3101 18.5804 17.1065 17.6029 17.1065ZM17.6029 12.0781C16.949 12.0781 16.3401 12.2731 15.8296 12.6068V10.6604H19.4113H20.0934V13.2439C19.4967 12.5319 18.6019 12.0781 17.6029 12.0781Z" fill="#004877"/>
						</svg>
					</div>
					<div class="cart-element__text">Подробнее о доставке</div>
				</a>
			</div>
			
        </div>
		
    </div>
</div>
<style>
    .error_input {border-color:red !important;}
</style>