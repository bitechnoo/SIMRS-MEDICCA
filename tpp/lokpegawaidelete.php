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
$lokpegawai_delete = new lokpegawai_delete();

// Run the page
$lokpegawai_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpegawai_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokpegawaidelete = currentForm = new ew.Form("flokpegawaidelete", "delete");

// Form_CustomValidate event
flokpegawaidelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpegawaidelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpegawai_delete->showPageHeader(); ?>
<?php
$lokpegawai_delete->showMessage();
?>
<form name="flokpegawaidelete" id="flokpegawaidelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpegawai_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpegawai_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpegawai">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokpegawai_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
		<th class="<?php echo $lokpegawai->Id_Pegawai->headerCellClass() ?>"><span id="elh_lokpegawai_Id_Pegawai" class="lokpegawai_Id_Pegawai"><?php echo $lokpegawai->Id_Pegawai->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
		<th class="<?php echo $lokpegawai->Nama_Pegawai->headerCellClass() ?>"><span id="elh_lokpegawai_Nama_Pegawai" class="lokpegawai_Nama_Pegawai"><?php echo $lokpegawai->Nama_Pegawai->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
		<th class="<?php echo $lokpegawai->NIK->headerCellClass() ?>"><span id="elh_lokpegawai_NIK" class="lokpegawai_NIK"><?php echo $lokpegawai->NIK->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
		<th class="<?php echo $lokpegawai->Unit->headerCellClass() ?>"><span id="elh_lokpegawai_Unit" class="lokpegawai_Unit"><?php echo $lokpegawai->Unit->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
		<th class="<?php echo $lokpegawai->Jenis_Pegawai->headerCellClass() ?>"><span id="elh_lokpegawai_Jenis_Pegawai" class="lokpegawai_Jenis_Pegawai"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Username->Visible) { // Username ?>
		<th class="<?php echo $lokpegawai->Username->headerCellClass() ?>"><span id="elh_lokpegawai_Username" class="lokpegawai_Username"><?php echo $lokpegawai->Username->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Password->Visible) { // Password ?>
		<th class="<?php echo $lokpegawai->Password->headerCellClass() ?>"><span id="elh_lokpegawai_Password" class="lokpegawai_Password"><?php echo $lokpegawai->Password->caption() ?></span></th>
<?php } ?>
<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
		<th class="<?php echo $lokpegawai->Userlevel->headerCellClass() ?>"><span id="elh_lokpegawai_Userlevel" class="lokpegawai_Userlevel"><?php echo $lokpegawai->Userlevel->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokpegawai_delete->RecCnt = 0;
$i = 0;
while (!$lokpegawai_delete->Recordset->EOF) {
	$lokpegawai_delete->RecCnt++;
	$lokpegawai_delete->RowCnt++;

	// Set row properties
	$lokpegawai->resetAttributes();
	$lokpegawai->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokpegawai_delete->loadRowValues($lokpegawai_delete->Recordset);

	// Render row
	$lokpegawai_delete->renderRow();
?>
	<tr<?php echo $lokpegawai->rowAttributes() ?>>
<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
		<td<?php echo $lokpegawai->Id_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Id_Pegawai" class="lokpegawai_Id_Pegawai">
<span<?php echo $lokpegawai->Id_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Id_Pegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
		<td<?php echo $lokpegawai->Nama_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Nama_Pegawai" class="lokpegawai_Nama_Pegawai">
<span<?php echo $lokpegawai->Nama_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Nama_Pegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
		<td<?php echo $lokpegawai->NIK->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_NIK" class="lokpegawai_NIK">
<span<?php echo $lokpegawai->NIK->viewAttributes() ?>>
<?php echo $lokpegawai->NIK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
		<td<?php echo $lokpegawai->Unit->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Unit" class="lokpegawai_Unit">
<span<?php echo $lokpegawai->Unit->viewAttributes() ?>>
<?php echo $lokpegawai->Unit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
		<td<?php echo $lokpegawai->Jenis_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Jenis_Pegawai" class="lokpegawai_Jenis_Pegawai">
<span<?php echo $lokpegawai->Jenis_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Jenis_Pegawai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Username->Visible) { // Username ?>
		<td<?php echo $lokpegawai->Username->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Username" class="lokpegawai_Username">
<span<?php echo $lokpegawai->Username->viewAttributes() ?>>
<?php echo $lokpegawai->Username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Password->Visible) { // Password ?>
		<td<?php echo $lokpegawai->Password->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Password" class="lokpegawai_Password">
<span<?php echo $lokpegawai->Password->viewAttributes() ?>>
<?php echo $lokpegawai->Password->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
		<td<?php echo $lokpegawai->Userlevel->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_delete->RowCnt ?>_lokpegawai_Userlevel" class="lokpegawai_Userlevel">
<span<?php echo $lokpegawai->Userlevel->viewAttributes() ?>>
<?php echo $lokpegawai->Userlevel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokpegawai_delete->Recordset->moveNext();
}
$lokpegawai_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpegawai_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokpegawai_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokpegawai_delete->terminate();
?>