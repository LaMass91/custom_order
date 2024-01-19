<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="notetext">
<?
if (!empty($_REQUEST["ORDER_ID"]))
{
	?>
	<h1><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h1>
    <p><?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $_REQUEST["ORDER_ID"]))?></p><p><?=GetMessage("SOA_TEMPL_ORDER_SUC_DOP")?></p>
	<?/*
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
		<br /><br />

		<table class="sale_order_full_table">
			<tr>
				<td>
					<?=GetMessage("SOA_TEMPL_PAY")?>: <?= $arResult["PAY_SYSTEM"]["NAME"] ?>
				</td>
			</tr>
			<?
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
			{
				?>
				<tr>
					<td>
						<?
						if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
						{
							?>
							<script language="JavaScript">
								window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?= $arResult["ORDER_BASKET"]["ORDER_ID"] ?>');
							</script>
							<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$arResult["ORDER_BASKET"]["ORDER_ID"])) ?>
							<?
						}
						else
						{
							if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
							{
								try
								{
									include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
								}
								catch(\Bitrix\Main\SystemException $e)
								{
									if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
										$message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
									else
										$message = $e->getMessage();

									echo '<span style="color:red;">'.$message.'</span>';
								}
							}
						}
						?>
					</td>
				</tr>
				<?
			}
			?>
		</table>

		<?
		if ($arResult["ERR_ACCOUNT"] == "Y")
			echo "<div>".GetMessage("NEWO_PAY_FROM_ACCOUNT_ERR")."</div>";
	}
*/
}
else
{
	//coo
	?>
	<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ORDER_ID"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?
}
?>
</div>
<?
global $USER;
if ($USER->IsAuthorized()) {
	$USER->Logout();
}
?>