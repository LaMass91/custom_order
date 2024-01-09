<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
use Bitrix\Sale;
$itemsInfo = array();
$itemsId = array();
$iblockId = 0;
foreach($arResult['ITEMS']['AnDelCanBuy'] as $key => &$arItem) {
    //Картинки товаров
    $id = $arItem['PREVIEW_PICTURE']?:$arItem['DETAIL_PICTURE'];
    $img = CFile::ResizeImageGet($id, array('width' => '110', 'height' => '100500'), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arItem['IMAGE'] = $img;

	if($arItem["IBLOCK_ID"] != "")
	{
		$iblockId = $arItem["IBLOCK_ID"];
	}

	if($arItem["PRODUCT_ID"] != "")
	{
		$itemsId[] = $arItem["PRODUCT_ID"];
		$itemsInfo[$arItem["PRODUCT_ID"]]["ID"] = $arItem["PRODUCT_ID"];
	}
/* 	$db_res = CPrice::GetList(
		array(),
		array(
			"PRODUCT_ID" => $arItem['PRODUCT_ID'],
			"CATALOG_GROUP_ID" => 2
		)
	);
	if ($ar_res = $db_res->Fetch())
	{
		$arResult['ITEMS']['AnDelCanBuy'][$key]['PRICE'] = $ar_res['PRICE'];
		$arResult['ITEMS']['AnDelCanBuy'][$key]['BASE_PRICE'] = $ar_res['PRICE'];
		$arResult['ITEMS']['AnDelCanBuy'][$key]['CATALOG_GROUP_ID'] = $ar_res['CATALOG_GROUP_ID'];
	} else {
		$arResult['ITEMS']['AnDelCanBuy'][$key]['CATALOG_GROUP_ID'] = 1;
	} */

}
unset($arItem);
if(!empty($itemsId) && $iblockId != 0)
{
	$arOrder = array("SORT"=>"ASC");
	$filter = array("IBLOCK_ID" => $iblockId, "ID" => $itemsId);
	$arGroupBy = false;
	$arNavStartParams = false;
	$select = array("ID", "NAME", "IBLOCK_ID", "CODE", "CATALOG_QUANTITY");
	$res = CIBlockElement::GetList($arOrder, $filter, $arGroupBy, $arNavStartParams, $select);
	while($arElement = $res->fetch())
	{
		$itemsInfo[$arElement["ID"]]["MAX_QUANTITY"] = $arElement["CATALOG_QUANTITY"];
	}

	foreach($arResult['ITEMS']['AnDelCanBuy'] as &$arItem) {
		if($itemsInfo[$arItem["PRODUCT_ID"]]["MAX_QUANTITY"] != "")
		{
			$arItem["MAX_QUANTITY"] = $itemsInfo[$arItem["PRODUCT_ID"]]["MAX_QUANTITY"];
		}
	}
	unset($arItem);
}


//pre($arItems);
?>