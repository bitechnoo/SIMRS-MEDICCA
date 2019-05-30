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
$ugddaftar_delete = new ugddaftar_delete();

// Run the page
$ugddaftar_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugddaftar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fugddaftardelete = currentForm = new ew.Form("fugddaftardelete", "delete");

// Form_CustomValidate event
fugddaftardelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugddaftardelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fugddaftardelete.lists["x_Id_Rujukan"] = <?php echo $ugddaftar_delete->Id_Rujukan->Lookup->toClientList() ?>;
fugddaftardelete.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($ugddaftar_delete->Id_Rujukan->lookupOptions()) ?>;
fugddaftardelete.lists["x_Id_JenisPasien"] = <?php echo $ugddaftar_delete->Id_JenisPasien->Lookup->toClientList() ?>;
fugddaftardelete.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($ugddaftar_delete->Id_JenisPasien->lookupOptions()) ?>;
fugddaftardelete.lists["x_Id_BiayaDaftar"] = <?php echo $ugddaftar_delete->Id_BiayaDaftar->Lookup->toClientList() ?>;
fugddaftardelete.lists["x_Id_BiayaDaftar"].options = <?php echo JsonEncode($ugddaftar_delete->Id_BiayaDaftar->lookupOptions()) ?>;
fugddaftardelete.lists["x_Rawat"] = <?php echo $ugddaftar_delete->Rawat->Lookup->toClientList() ?>;
fugddaftardelete.lists["x_Rawat"].options = <?php echo JsonEncode($ugddaftar_delete->Rawat->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugddaftar_delete->showPageHeader(); ?>
<?php
$ugddaftar_delete->showMessage();
?>
<form name="fugddaftardelete" id="fugddaftardelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugddaftar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugddaftar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugddaftar">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($ugddaftar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($ugddaftar->Id_Daftar->Visible) { // Id_Daftar ?>
		<th class="<?php echo $ugddaftar->Id_Daftar->headerCellClass() ?>"><span id="elh_ugddaftar_Id_Daftar" class="ugddaftar_Id_Daftar"><?php echo $ugddaftar->Id_Daftar->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<th class="<?php echo $ugddaftar->Tgl_Daftar->headerCellClass() ?>"><span id="elh_ugddaftar_Tgl_Daftar" class="ugddaftar_Tgl_Daftar"><?php echo $ugddaftar->Tgl_Daftar->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Waktu->Visible) { // Waktu ?>
		<th class="<?php echo $ugddaftar->Waktu->headerCellClass() ?>"><span id="elh_ugddaftar_Waktu" class="ugddaftar_Waktu"><?php echo $ugddaftar->Waktu->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Id_Pasien->Visible) { // Id_Pasien ?>
		<th class="<?php echo $ugddaftar->Id_Pasien->headerCellClass() ?>"><span id="elh_ugddaftar_Id_Pasien" class="ugddaftar_Id_Pasien"><?php echo $ugddaftar->Id_Pasien->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<th class="<?php echo $ugddaftar->Nama_Pasien->headerCellClass() ?>"><span id="elh_ugddaftar_Nama_Pasien" class="ugddaftar_Nama_Pasien"><?php echo $ugddaftar->Nama_Pasien->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->No_RM->Visible) { // No_RM ?>
		<th class="<?php echo $ugddaftar->No_RM->headerCellClass() ?>"><span id="elh_ugddaftar_No_RM" class="ugddaftar_No_RM"><?php echo $ugddaftar->No_RM->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<th class="<?php echo $ugddaftar->Tgl_Lahir->headerCellClass() ?>"><span id="elh_ugddaftar_Tgl_Lahir" class="ugddaftar_Tgl_Lahir"><?php echo $ugddaftar->Tgl_Lahir->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<th class="<?php echo $ugddaftar->Jenis_Kelamin->headerCellClass() ?>"><span id="elh_ugddaftar_Jenis_Kelamin" class="ugddaftar_Jenis_Kelamin"><?php echo $ugddaftar->Jenis_Kelamin->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Alamat->Visible) { // Alamat ?>
		<th class="<?php echo $ugddaftar->Alamat->headerCellClass() ?>"><span id="elh_ugddaftar_Alamat" class="ugddaftar_Alamat"><?php echo $ugddaftar->Alamat->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
		<th class="<?php echo $ugddaftar->Id_Poliklinik->headerCellClass() ?>"><span id="elh_ugddaftar_Id_Poliklinik" class="ugddaftar_Id_Poliklinik"><?php echo $ugddaftar->Id_Poliklinik->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<th class="<?php echo $ugddaftar->Id_Rujukan->headerCellClass() ?>"><span id="elh_ugddaftar_Id_Rujukan" class="ugddaftar_Id_Rujukan"><?php echo $ugddaftar->Id_Rujukan->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<th class="<?php echo $ugddaftar->Id_JenisPasien->headerCellClass() ?>"><span id="elh_ugddaftar_Id_JenisPasien" class="ugddaftar_Id_JenisPasien"><?php echo $ugddaftar->Id_JenisPasien->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<th class="<?php echo $ugddaftar->Lama_Baru->headerCellClass() ?>"><span id="elh_ugddaftar_Lama_Baru" class="ugddaftar_Lama_Baru"><?php echo $ugddaftar->Lama_Baru->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
		<th class="<?php echo $ugddaftar->Id_BiayaDaftar->headerCellClass() ?>"><span id="elh_ugddaftar_Id_BiayaDaftar" class="ugddaftar_Id_BiayaDaftar"><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<th class="<?php echo $ugddaftar->Total_Biaya->headerCellClass() ?>"><span id="elh_ugddaftar_Total_Biaya" class="ugddaftar_Total_Biaya"><?php echo $ugddaftar->Total_Biaya->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Rawat->Visible) { // Rawat ?>
		<th class="<?php echo $ugddaftar->Rawat->headerCellClass() ?>"><span id="elh_ugddaftar_Rawat" class="ugddaftar_Rawat"><?php echo $ugddaftar->Rawat->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Status->Visible) { // Status ?>
		<th class="<?php echo $ugddaftar->Status->headerCellClass() ?>"><span id="elh_ugddaftar_Status" class="ugddaftar_Status"><?php echo $ugddaftar->Status->caption() ?></span></th>
<?php } ?>
<?php if ($ugddaftar->Petugas->Visible) { // Petugas ?>
		<th class="<?php echo $ugddaftar->Petugas->headerCellClass() ?>"><span id="elh_ugddaftar_Petugas" class="ugddaftar_Petugas"><?php echo $ugddaftar->Petugas->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ugddaftar_delete->RecCnt = 0;
$i = 0;
while (!$ugddaftar_delete->Recordset->EOF) {
	$ugddaftar_delete->RecCnt++;
	$ugddaftar_delete->RowCnt++;

	// Set row properties
	$ugddaftar->resetAttributes();
	$ugddaftar->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$ugddaftar_delete->loadRowValues($ugddaftar_delete->Recordset);

	// Render row
	$ugddaftar_delete->renderRow();
?>
	<tr<?php echo $ugddaftar->rowAttributes() ?>>
<?php if ($ugddaftar->Id_Daftar->Visible) { // Id_Daftar ?>
		<td<?php echo $ugddaftar->Id_Daftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_Daftar" class="ugddaftar_Id_Daftar">
<span<?php echo $ugddaftar->Id_Daftar->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<td<?php echo $ugddaftar->Tgl_Daftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Tgl_Daftar" class="ugddaftar_Tgl_Daftar">
<span<?php echo $ugddaftar->Tgl_Daftar->viewAttributes() ?>>
<?php echo $ugddaftar->Tgl_Daftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Waktu->Visible) { // Waktu ?>
		<td<?php echo $ugddaftar->Waktu->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Waktu" class="ugddaftar_Waktu">
<span<?php echo $ugddaftar->Waktu->viewAttributes() ?>>
<?php echo $ugddaftar->Waktu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Id_Pasien->Visible) { // Id_Pasien ?>
		<td<?php echo $ugddaftar->Id_Pasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_Pasien" class="ugddaftar_Id_Pasien">
<span<?php echo $ugddaftar->Id_Pasien->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Pasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td<?php echo $ugddaftar->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Nama_Pasien" class="ugddaftar_Nama_Pasien">
<span<?php echo $ugddaftar->Nama_Pasien->viewAttributes() ?>>
<?php echo $ugddaftar->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->No_RM->Visible) { // No_RM ?>
		<td<?php echo $ugddaftar->No_RM->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_No_RM" class="ugddaftar_No_RM">
<span<?php echo $ugddaftar->No_RM->viewAttributes() ?>>
<?php echo $ugddaftar->No_RM->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td<?php echo $ugddaftar->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Tgl_Lahir" class="ugddaftar_Tgl_Lahir">
<span<?php echo $ugddaftar->Tgl_Lahir->viewAttributes() ?>>
<?php echo $ugddaftar->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td<?php echo $ugddaftar->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Jenis_Kelamin" class="ugddaftar_Jenis_Kelamin">
<span<?php echo $ugddaftar->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $ugddaftar->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Alamat->Visible) { // Alamat ?>
		<td<?php echo $ugddaftar->Alamat->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Alamat" class="ugddaftar_Alamat">
<span<?php echo $ugddaftar->Alamat->viewAttributes() ?>>
<?php echo $ugddaftar->Alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
		<td<?php echo $ugddaftar->Id_Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_Poliklinik" class="ugddaftar_Id_Poliklinik">
<span<?php echo $ugddaftar->Id_Poliklinik->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Poliklinik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td<?php echo $ugddaftar->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_Rujukan" class="ugddaftar_Id_Rujukan">
<span<?php echo $ugddaftar->Id_Rujukan->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td<?php echo $ugddaftar->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_JenisPasien" class="ugddaftar_Id_JenisPasien">
<span<?php echo $ugddaftar->Id_JenisPasien->viewAttributes() ?>>
<?php echo $ugddaftar->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<td<?php echo $ugddaftar->Lama_Baru->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Lama_Baru" class="ugddaftar_Lama_Baru">
<span<?php echo $ugddaftar->Lama_Baru->viewAttributes() ?>>
<?php echo $ugddaftar->Lama_Baru->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
		<td<?php echo $ugddaftar->Id_BiayaDaftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Id_BiayaDaftar" class="ugddaftar_Id_BiayaDaftar">
<span<?php echo $ugddaftar->Id_BiayaDaftar->viewAttributes() ?>>
<?php echo $ugddaftar->Id_BiayaDaftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td<?php echo $ugddaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Total_Biaya" class="ugddaftar_Total_Biaya">
<span<?php echo $ugddaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $ugddaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Rawat->Visible) { // Rawat ?>
		<td<?php echo $ugddaftar->Rawat->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Rawat" class="ugddaftar_Rawat">
<span<?php echo $ugddaftar->Rawat->viewAttributes() ?>>
<?php echo $ugddaftar->Rawat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Status->Visible) { // Status ?>
		<td<?php echo $ugddaftar->Status->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Status" class="ugddaftar_Status">
<span<?php echo $ugddaftar->Status->viewAttributes() ?>>
<?php echo $ugddaftar->Status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugddaftar->Petugas->Visible) { // Petugas ?>
		<td<?php echo $ugddaftar->Petugas->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_delete->RowCnt ?>_ugddaftar_Petugas" class="ugddaftar_Petugas">
<span<?php echo $ugddaftar->Petugas->viewAttributes() ?>>
<?php echo $ugddaftar->Petugas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ugddaftar_delete->Recordset->moveNext();
}
$ugddaftar_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugddaftar_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$ugddaftar_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugddaftar_delete->terminate();
?>