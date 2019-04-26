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
$lokpasien_delete = new lokpasien_delete();

// Run the page
$lokpasien_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpasien_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokpasiendelete = currentForm = new ew.Form("flokpasiendelete", "delete");

// Form_CustomValidate event
flokpasiendelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpasiendelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokpasiendelete.lists["x_Jenis_Kelamin"] = <?php echo $lokpasien_delete->Jenis_Kelamin->Lookup->toClientList() ?>;
flokpasiendelete.lists["x_Jenis_Kelamin"].options = <?php echo JsonEncode($lokpasien_delete->Jenis_Kelamin->options(FALSE, TRUE)) ?>;
flokpasiendelete.lists["x_Id_Kelurahan"] = <?php echo $lokpasien_delete->Id_Kelurahan->Lookup->toClientList() ?>;
flokpasiendelete.lists["x_Id_Kelurahan"].options = <?php echo JsonEncode($lokpasien_delete->Id_Kelurahan->lookupOptions()) ?>;
flokpasiendelete.lists["x_Agama"] = <?php echo $lokpasien_delete->Agama->Lookup->toClientList() ?>;
flokpasiendelete.lists["x_Agama"].options = <?php echo JsonEncode($lokpasien_delete->Agama->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpasien_delete->showPageHeader(); ?>
<?php
$lokpasien_delete->showMessage();
?>
<form name="flokpasiendelete" id="flokpasiendelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpasien_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpasien_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpasien">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokpasien_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokpasien->No_RM->Visible) { // No_RM ?>
		<th class="<?php echo $lokpasien->No_RM->headerCellClass() ?>"><span id="elh_lokpasien_No_RM" class="lokpasien_No_RM"><?php echo $lokpasien->No_RM->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<th class="<?php echo $lokpasien->Nama_Pasien->headerCellClass() ?>"><span id="elh_lokpasien_Nama_Pasien" class="lokpasien_Nama_Pasien"><?php echo $lokpasien->Nama_Pasien->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->No_BPJS->Visible) { // No_BPJS ?>
		<th class="<?php echo $lokpasien->No_BPJS->headerCellClass() ?>"><span id="elh_lokpasien_No_BPJS" class="lokpasien_No_BPJS"><?php echo $lokpasien->No_BPJS->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->No_KTP->Visible) { // No_KTP ?>
		<th class="<?php echo $lokpasien->No_KTP->headerCellClass() ?>"><span id="elh_lokpasien_No_KTP" class="lokpasien_No_KTP"><?php echo $lokpasien->No_KTP->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Tempat_Lahir->Visible) { // Tempat_Lahir ?>
		<th class="<?php echo $lokpasien->Tempat_Lahir->headerCellClass() ?>"><span id="elh_lokpasien_Tempat_Lahir" class="lokpasien_Tempat_Lahir"><?php echo $lokpasien->Tempat_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<th class="<?php echo $lokpasien->Tgl_Lahir->headerCellClass() ?>"><span id="elh_lokpasien_Tgl_Lahir" class="lokpasien_Tgl_Lahir"><?php echo $lokpasien->Tgl_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<th class="<?php echo $lokpasien->Jenis_Kelamin->headerCellClass() ?>"><span id="elh_lokpasien_Jenis_Kelamin" class="lokpasien_Jenis_Kelamin"><?php echo $lokpasien->Jenis_Kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Alamat->Visible) { // Alamat ?>
		<th class="<?php echo $lokpasien->Alamat->headerCellClass() ?>"><span id="elh_lokpasien_Alamat" class="lokpasien_Alamat"><?php echo $lokpasien->Alamat->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
		<th class="<?php echo $lokpasien->Id_Kelurahan->headerCellClass() ?>"><span id="elh_lokpasien_Id_Kelurahan" class="lokpasien_Id_Kelurahan"><?php echo $lokpasien->Id_Kelurahan->caption() ?></span></th>
<?php } ?>
<?php if ($lokpasien->Agama->Visible) { // Agama ?>
		<th class="<?php echo $lokpasien->Agama->headerCellClass() ?>"><span id="elh_lokpasien_Agama" class="lokpasien_Agama"><?php echo $lokpasien->Agama->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokpasien_delete->RecCnt = 0;
$i = 0;
while (!$lokpasien_delete->Recordset->EOF) {
	$lokpasien_delete->RecCnt++;
	$lokpasien_delete->RowCnt++;

	// Set row properties
	$lokpasien->resetAttributes();
	$lokpasien->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokpasien_delete->loadRowValues($lokpasien_delete->Recordset);

	// Render row
	$lokpasien_delete->renderRow();
?>
	<tr<?php echo $lokpasien->rowAttributes() ?>>
<?php if ($lokpasien->No_RM->Visible) { // No_RM ?>
		<td<?php echo $lokpasien->No_RM->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_No_RM" class="lokpasien_No_RM">
<span<?php echo $lokpasien->No_RM->viewAttributes() ?>>
<?php echo $lokpasien->No_RM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td<?php echo $lokpasien->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Nama_Pasien" class="lokpasien_Nama_Pasien">
<span<?php echo $lokpasien->Nama_Pasien->viewAttributes() ?>>
<?php echo $lokpasien->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->No_BPJS->Visible) { // No_BPJS ?>
		<td<?php echo $lokpasien->No_BPJS->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_No_BPJS" class="lokpasien_No_BPJS">
<span<?php echo $lokpasien->No_BPJS->viewAttributes() ?>>
<?php echo $lokpasien->No_BPJS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->No_KTP->Visible) { // No_KTP ?>
		<td<?php echo $lokpasien->No_KTP->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_No_KTP" class="lokpasien_No_KTP">
<span<?php echo $lokpasien->No_KTP->viewAttributes() ?>>
<?php echo $lokpasien->No_KTP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Tempat_Lahir->Visible) { // Tempat_Lahir ?>
		<td<?php echo $lokpasien->Tempat_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Tempat_Lahir" class="lokpasien_Tempat_Lahir">
<span<?php echo $lokpasien->Tempat_Lahir->viewAttributes() ?>>
<?php echo $lokpasien->Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td<?php echo $lokpasien->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Tgl_Lahir" class="lokpasien_Tgl_Lahir">
<span<?php echo $lokpasien->Tgl_Lahir->viewAttributes() ?>>
<?php echo $lokpasien->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td<?php echo $lokpasien->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Jenis_Kelamin" class="lokpasien_Jenis_Kelamin">
<span<?php echo $lokpasien->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $lokpasien->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Alamat->Visible) { // Alamat ?>
		<td<?php echo $lokpasien->Alamat->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Alamat" class="lokpasien_Alamat">
<span<?php echo $lokpasien->Alamat->viewAttributes() ?>>
<?php echo $lokpasien->Alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
		<td<?php echo $lokpasien->Id_Kelurahan->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Id_Kelurahan" class="lokpasien_Id_Kelurahan">
<span<?php echo $lokpasien->Id_Kelurahan->viewAttributes() ?>>
<?php echo $lokpasien->Id_Kelurahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpasien->Agama->Visible) { // Agama ?>
		<td<?php echo $lokpasien->Agama->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_delete->RowCnt ?>_lokpasien_Agama" class="lokpasien_Agama">
<span<?php echo $lokpasien->Agama->viewAttributes() ?>>
<?php echo $lokpasien->Agama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokpasien_delete->Recordset->moveNext();
}
$lokpasien_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpasien_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokpasien_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokpasien_delete->terminate();
?>