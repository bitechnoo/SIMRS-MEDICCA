<?php
namespace PHPMaker2019\tpp;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start(); 

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$lokbiayadaftar_delete = new lokbiayadaftar_delete();

// Run the page
$lokbiayadaftar_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokbiayadaftar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokbiayadaftardelete = currentForm = new ew.Form("flokbiayadaftardelete", "delete");

// Form_CustomValidate event
flokbiayadaftardelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokbiayadaftardelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokbiayadaftar_delete->showPageHeader(); ?>
<?php
$lokbiayadaftar_delete->showMessage();
?>
<form name="flokbiayadaftardelete" id="flokbiayadaftardelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokbiayadaftar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokbiayadaftar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokbiayadaftar">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokbiayadaftar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<th class="<?php echo $lokbiayadaftar->Nama_Biaya->headerCellClass() ?>"><span id="elh_lokbiayadaftar_Nama_Biaya" class="lokbiayadaftar_Nama_Biaya"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?></span></th>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<th class="<?php echo $lokbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><span id="elh_lokbiayadaftar_Jasa_Dokter" class="lokbiayadaftar_Jasa_Dokter"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?></span></th>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<th class="<?php echo $lokbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><span id="elh_lokbiayadaftar_Jasa_Layanan" class="lokbiayadaftar_Jasa_Layanan"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?></span></th>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<th class="<?php echo $lokbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><span id="elh_lokbiayadaftar_Jasa_Sarana" class="lokbiayadaftar_Jasa_Sarana"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?></span></th>
<?php } ?>
<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<th class="<?php echo $lokbiayadaftar->Total_Biaya->headerCellClass() ?>"><span id="elh_lokbiayadaftar_Total_Biaya" class="lokbiayadaftar_Total_Biaya"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokbiayadaftar_delete->RecCnt = 0;
$i = 0;
while (!$lokbiayadaftar_delete->Recordset->EOF) {
	$lokbiayadaftar_delete->RecCnt++;
	$lokbiayadaftar_delete->RowCnt++;

	// Set row properties
	$lokbiayadaftar->resetAttributes();
	$lokbiayadaftar->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokbiayadaftar_delete->loadRowValues($lokbiayadaftar_delete->Recordset);

	// Render row
	$lokbiayadaftar_delete->renderRow();
?>
	<tr<?php echo $lokbiayadaftar->rowAttributes() ?>>
<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<td<?php echo $lokbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_delete->RowCnt ?>_lokbiayadaftar_Nama_Biaya" class="lokbiayadaftar_Nama_Biaya">
<span<?php echo $lokbiayadaftar->Nama_Biaya->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Nama_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<td<?php echo $lokbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_delete->RowCnt ?>_lokbiayadaftar_Jasa_Dokter" class="lokbiayadaftar_Jasa_Dokter">
<span<?php echo $lokbiayadaftar->Jasa_Dokter->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Dokter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<td<?php echo $lokbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_delete->RowCnt ?>_lokbiayadaftar_Jasa_Layanan" class="lokbiayadaftar_Jasa_Layanan">
<span<?php echo $lokbiayadaftar->Jasa_Layanan->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Layanan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<td<?php echo $lokbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_delete->RowCnt ?>_lokbiayadaftar_Jasa_Sarana" class="lokbiayadaftar_Jasa_Sarana">
<span<?php echo $lokbiayadaftar->Jasa_Sarana->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Sarana->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td<?php echo $lokbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_delete->RowCnt ?>_lokbiayadaftar_Total_Biaya" class="lokbiayadaftar_Total_Biaya">
<span<?php echo $lokbiayadaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokbiayadaftar_delete->Recordset->moveNext();
}
$lokbiayadaftar_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokbiayadaftar_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokbiayadaftar_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokbiayadaftar_delete->terminate();
?>