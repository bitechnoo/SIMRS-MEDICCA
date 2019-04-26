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
$ugdbiayadaftar_delete = new ugdbiayadaftar_delete();

// Run the page
$ugdbiayadaftar_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugdbiayadaftar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fugdbiayadaftardelete = currentForm = new ew.Form("fugdbiayadaftardelete", "delete");

// Form_CustomValidate event
fugdbiayadaftardelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugdbiayadaftardelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugdbiayadaftar_delete->showPageHeader(); ?>
<?php
$ugdbiayadaftar_delete->showMessage();
?>
<form name="fugdbiayadaftardelete" id="fugdbiayadaftardelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugdbiayadaftar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugdbiayadaftar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugdbiayadaftar">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($ugdbiayadaftar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
		<th class="<?php echo $ugdbiayadaftar->Id_Biayadaftar->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Id_Biayadaftar" class="ugdbiayadaftar_Id_Biayadaftar"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?></span></th>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<th class="<?php echo $ugdbiayadaftar->Nama_Biaya->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Nama_Biaya" class="ugdbiayadaftar_Nama_Biaya"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?></span></th>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<th class="<?php echo $ugdbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Jasa_Dokter" class="ugdbiayadaftar_Jasa_Dokter"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?></span></th>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<th class="<?php echo $ugdbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Jasa_Layanan" class="ugdbiayadaftar_Jasa_Layanan"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?></span></th>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<th class="<?php echo $ugdbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Jasa_Sarana" class="ugdbiayadaftar_Jasa_Sarana"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?></span></th>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<th class="<?php echo $ugdbiayadaftar->Total_Biaya->headerCellClass() ?>"><span id="elh_ugdbiayadaftar_Total_Biaya" class="ugdbiayadaftar_Total_Biaya"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ugdbiayadaftar_delete->RecCnt = 0;
$i = 0;
while (!$ugdbiayadaftar_delete->Recordset->EOF) {
	$ugdbiayadaftar_delete->RecCnt++;
	$ugdbiayadaftar_delete->RowCnt++;

	// Set row properties
	$ugdbiayadaftar->resetAttributes();
	$ugdbiayadaftar->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$ugdbiayadaftar_delete->loadRowValues($ugdbiayadaftar_delete->Recordset);

	// Render row
	$ugdbiayadaftar_delete->renderRow();
?>
	<tr<?php echo $ugdbiayadaftar->rowAttributes() ?>>
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
		<td<?php echo $ugdbiayadaftar->Id_Biayadaftar->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Id_Biayadaftar" class="ugdbiayadaftar_Id_Biayadaftar">
<span<?php echo $ugdbiayadaftar->Id_Biayadaftar->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<td<?php echo $ugdbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Nama_Biaya" class="ugdbiayadaftar_Nama_Biaya">
<span<?php echo $ugdbiayadaftar->Nama_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Nama_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<td<?php echo $ugdbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Jasa_Dokter" class="ugdbiayadaftar_Jasa_Dokter">
<span<?php echo $ugdbiayadaftar->Jasa_Dokter->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Dokter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<td<?php echo $ugdbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Jasa_Layanan" class="ugdbiayadaftar_Jasa_Layanan">
<span<?php echo $ugdbiayadaftar->Jasa_Layanan->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Layanan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<td<?php echo $ugdbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Jasa_Sarana" class="ugdbiayadaftar_Jasa_Sarana">
<span<?php echo $ugdbiayadaftar->Jasa_Sarana->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Sarana->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td<?php echo $ugdbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_delete->RowCnt ?>_ugdbiayadaftar_Total_Biaya" class="ugdbiayadaftar_Total_Biaya">
<span<?php echo $ugdbiayadaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ugdbiayadaftar_delete->Recordset->moveNext();
}
$ugdbiayadaftar_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugdbiayadaftar_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$ugdbiayadaftar_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugdbiayadaftar_delete->terminate();
?>