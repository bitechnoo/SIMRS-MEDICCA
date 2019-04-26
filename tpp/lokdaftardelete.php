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
$lokdaftar_delete = new lokdaftar_delete();

// Run the page
$lokdaftar_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokdaftar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokdaftardelete = currentForm = new ew.Form("flokdaftardelete", "delete");

// Form_CustomValidate event
flokdaftardelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokdaftardelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokdaftardelete.lists["x_Id_Rujukan"] = <?php echo $lokdaftar_delete->Id_Rujukan->Lookup->toClientList() ?>;
flokdaftardelete.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($lokdaftar_delete->Id_Rujukan->lookupOptions()) ?>;
flokdaftardelete.lists["x_Id_JenisPasien"] = <?php echo $lokdaftar_delete->Id_JenisPasien->Lookup->toClientList() ?>;
flokdaftardelete.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($lokdaftar_delete->Id_JenisPasien->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokdaftar_delete->showPageHeader(); ?>
<?php
$lokdaftar_delete->showMessage();
?>
<form name="flokdaftardelete" id="flokdaftardelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokdaftar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokdaftar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokdaftar">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokdaftar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokdaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<th class="<?php echo $lokdaftar->Tgl_Daftar->headerCellClass() ?>"><span id="elh_lokdaftar_Tgl_Daftar" class="lokdaftar_Tgl_Daftar"><?php echo $lokdaftar->Tgl_Daftar->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Waktu->Visible) { // Waktu ?>
		<th class="<?php echo $lokdaftar->Waktu->headerCellClass() ?>"><span id="elh_lokdaftar_Waktu" class="lokdaftar_Waktu"><?php echo $lokdaftar->Waktu->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<th class="<?php echo $lokdaftar->Nama_Pasien->headerCellClass() ?>"><span id="elh_lokdaftar_Nama_Pasien" class="lokdaftar_Nama_Pasien"><?php echo $lokdaftar->Nama_Pasien->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->No_RM->Visible) { // No_RM ?>
		<th class="<?php echo $lokdaftar->No_RM->headerCellClass() ?>"><span id="elh_lokdaftar_No_RM" class="lokdaftar_No_RM"><?php echo $lokdaftar->No_RM->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<th class="<?php echo $lokdaftar->Tgl_Lahir->headerCellClass() ?>"><span id="elh_lokdaftar_Tgl_Lahir" class="lokdaftar_Tgl_Lahir"><?php echo $lokdaftar->Tgl_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<th class="<?php echo $lokdaftar->Jenis_Kelamin->headerCellClass() ?>"><span id="elh_lokdaftar_Jenis_Kelamin" class="lokdaftar_Jenis_Kelamin"><?php echo $lokdaftar->Jenis_Kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Alamat->Visible) { // Alamat ?>
		<th class="<?php echo $lokdaftar->Alamat->headerCellClass() ?>"><span id="elh_lokdaftar_Alamat" class="lokdaftar_Alamat"><?php echo $lokdaftar->Alamat->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Poliklinik->Visible) { // Poliklinik ?>
		<th class="<?php echo $lokdaftar->Poliklinik->headerCellClass() ?>"><span id="elh_lokdaftar_Poliklinik" class="lokdaftar_Poliklinik"><?php echo $lokdaftar->Poliklinik->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Rawat->Visible) { // Rawat ?>
		<th class="<?php echo $lokdaftar->Rawat->headerCellClass() ?>"><span id="elh_lokdaftar_Rawat" class="lokdaftar_Rawat"><?php echo $lokdaftar->Rawat->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<th class="<?php echo $lokdaftar->Id_Rujukan->headerCellClass() ?>"><span id="elh_lokdaftar_Id_Rujukan" class="lokdaftar_Id_Rujukan"><?php echo $lokdaftar->Id_Rujukan->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<th class="<?php echo $lokdaftar->Id_JenisPasien->headerCellClass() ?>"><span id="elh_lokdaftar_Id_JenisPasien" class="lokdaftar_Id_JenisPasien"><?php echo $lokdaftar->Id_JenisPasien->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<th class="<?php echo $lokdaftar->Lama_Baru->headerCellClass() ?>"><span id="elh_lokdaftar_Lama_Baru" class="lokdaftar_Lama_Baru"><?php echo $lokdaftar->Lama_Baru->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<th class="<?php echo $lokdaftar->Total_Biaya->headerCellClass() ?>"><span id="elh_lokdaftar_Total_Biaya" class="lokdaftar_Total_Biaya"><?php echo $lokdaftar->Total_Biaya->caption() ?></span></th>
<?php } ?>
<?php if ($lokdaftar->Petugas->Visible) { // Petugas ?>
		<th class="<?php echo $lokdaftar->Petugas->headerCellClass() ?>"><span id="elh_lokdaftar_Petugas" class="lokdaftar_Petugas"><?php echo $lokdaftar->Petugas->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokdaftar_delete->RecCnt = 0;
$i = 0;
while (!$lokdaftar_delete->Recordset->EOF) {
	$lokdaftar_delete->RecCnt++;
	$lokdaftar_delete->RowCnt++;

	// Set row properties
	$lokdaftar->resetAttributes();
	$lokdaftar->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokdaftar_delete->loadRowValues($lokdaftar_delete->Recordset);

	// Render row
	$lokdaftar_delete->renderRow();
?>
	<tr<?php echo $lokdaftar->rowAttributes() ?>>
<?php if ($lokdaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<td<?php echo $lokdaftar->Tgl_Daftar->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Tgl_Daftar" class="lokdaftar_Tgl_Daftar">
<span<?php echo $lokdaftar->Tgl_Daftar->viewAttributes() ?>>
<?php echo $lokdaftar->Tgl_Daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Waktu->Visible) { // Waktu ?>
		<td<?php echo $lokdaftar->Waktu->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Waktu" class="lokdaftar_Waktu">
<span<?php echo $lokdaftar->Waktu->viewAttributes() ?>>
<?php echo $lokdaftar->Waktu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td<?php echo $lokdaftar->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Nama_Pasien" class="lokdaftar_Nama_Pasien">
<span<?php echo $lokdaftar->Nama_Pasien->viewAttributes() ?>>
<?php echo $lokdaftar->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->No_RM->Visible) { // No_RM ?>
		<td<?php echo $lokdaftar->No_RM->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_No_RM" class="lokdaftar_No_RM">
<span<?php echo $lokdaftar->No_RM->viewAttributes() ?>>
<?php echo $lokdaftar->No_RM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td<?php echo $lokdaftar->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Tgl_Lahir" class="lokdaftar_Tgl_Lahir">
<span<?php echo $lokdaftar->Tgl_Lahir->viewAttributes() ?>>
<?php echo $lokdaftar->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td<?php echo $lokdaftar->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Jenis_Kelamin" class="lokdaftar_Jenis_Kelamin">
<span<?php echo $lokdaftar->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $lokdaftar->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Alamat->Visible) { // Alamat ?>
		<td<?php echo $lokdaftar->Alamat->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Alamat" class="lokdaftar_Alamat">
<span<?php echo $lokdaftar->Alamat->viewAttributes() ?>>
<?php echo $lokdaftar->Alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Poliklinik->Visible) { // Poliklinik ?>
		<td<?php echo $lokdaftar->Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Poliklinik" class="lokdaftar_Poliklinik">
<span<?php echo $lokdaftar->Poliklinik->viewAttributes() ?>>
<?php echo $lokdaftar->Poliklinik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Rawat->Visible) { // Rawat ?>
		<td<?php echo $lokdaftar->Rawat->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Rawat" class="lokdaftar_Rawat">
<span<?php echo $lokdaftar->Rawat->viewAttributes() ?>>
<?php echo $lokdaftar->Rawat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td<?php echo $lokdaftar->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Id_Rujukan" class="lokdaftar_Id_Rujukan">
<span<?php echo $lokdaftar->Id_Rujukan->viewAttributes() ?>>
<?php echo $lokdaftar->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td<?php echo $lokdaftar->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Id_JenisPasien" class="lokdaftar_Id_JenisPasien">
<span<?php echo $lokdaftar->Id_JenisPasien->viewAttributes() ?>>
<?php echo $lokdaftar->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<td<?php echo $lokdaftar->Lama_Baru->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Lama_Baru" class="lokdaftar_Lama_Baru">
<span<?php echo $lokdaftar->Lama_Baru->viewAttributes() ?>>
<?php echo $lokdaftar->Lama_Baru->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td<?php echo $lokdaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Total_Biaya" class="lokdaftar_Total_Biaya">
<span<?php echo $lokdaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $lokdaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokdaftar->Petugas->Visible) { // Petugas ?>
		<td<?php echo $lokdaftar->Petugas->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_delete->RowCnt ?>_lokdaftar_Petugas" class="lokdaftar_Petugas">
<span<?php echo $lokdaftar->Petugas->viewAttributes() ?>>
<?php echo $lokdaftar->Petugas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokdaftar_delete->Recordset->moveNext();
}
$lokdaftar_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokdaftar_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokdaftar_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokdaftar_delete->terminate();
?>