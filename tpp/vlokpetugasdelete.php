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
$vlokpetugas_delete = new vlokpetugas_delete();

// Run the page
$vlokpetugas_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vlokpetugas_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fvlokpetugasdelete = currentForm = new ew.Form("fvlokpetugasdelete", "delete");

// Form_CustomValidate event
fvlokpetugasdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fvlokpetugasdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fvlokpetugasdelete.lists["x_Userlevel"] = <?php echo $vlokpetugas_delete->Userlevel->Lookup->toClientList() ?>;
fvlokpetugasdelete.lists["x_Userlevel"].options = <?php echo JsonEncode($vlokpetugas_delete->Userlevel->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $vlokpetugas_delete->showPageHeader(); ?>
<?php
$vlokpetugas_delete->showMessage();
?>
<form name="fvlokpetugasdelete" id="fvlokpetugasdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($vlokpetugas_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $vlokpetugas_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vlokpetugas">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($vlokpetugas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($vlokpetugas->Nama_Petugas->Visible) { // Nama_Petugas ?>
		<th class="<?php echo $vlokpetugas->Nama_Petugas->headerCellClass() ?>"><span id="elh_vlokpetugas_Nama_Petugas" class="vlokpetugas_Nama_Petugas"><?php echo $vlokpetugas->Nama_Petugas->caption() ?></span></th>
<?php } ?>
<?php if ($vlokpetugas->NIK->Visible) { // NIK ?>
		<th class="<?php echo $vlokpetugas->NIK->headerCellClass() ?>"><span id="elh_vlokpetugas_NIK" class="vlokpetugas_NIK"><?php echo $vlokpetugas->NIK->caption() ?></span></th>
<?php } ?>
<?php if ($vlokpetugas->Unit->Visible) { // Unit ?>
		<th class="<?php echo $vlokpetugas->Unit->headerCellClass() ?>"><span id="elh_vlokpetugas_Unit" class="vlokpetugas_Unit"><?php echo $vlokpetugas->Unit->caption() ?></span></th>
<?php } ?>
<?php if ($vlokpetugas->Username->Visible) { // Username ?>
		<th class="<?php echo $vlokpetugas->Username->headerCellClass() ?>"><span id="elh_vlokpetugas_Username" class="vlokpetugas_Username"><?php echo $vlokpetugas->Username->caption() ?></span></th>
<?php } ?>
<?php if ($vlokpetugas->Userlevel->Visible) { // Userlevel ?>
		<th class="<?php echo $vlokpetugas->Userlevel->headerCellClass() ?>"><span id="elh_vlokpetugas_Userlevel" class="vlokpetugas_Userlevel"><?php echo $vlokpetugas->Userlevel->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$vlokpetugas_delete->RecCnt = 0;
$i = 0;
while (!$vlokpetugas_delete->Recordset->EOF) {
	$vlokpetugas_delete->RecCnt++;
	$vlokpetugas_delete->RowCnt++;

	// Set row properties
	$vlokpetugas->resetAttributes();
	$vlokpetugas->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$vlokpetugas_delete->loadRowValues($vlokpetugas_delete->Recordset);

	// Render row
	$vlokpetugas_delete->renderRow();
?>
	<tr<?php echo $vlokpetugas->rowAttributes() ?>>
<?php if ($vlokpetugas->Nama_Petugas->Visible) { // Nama_Petugas ?>
		<td<?php echo $vlokpetugas->Nama_Petugas->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_delete->RowCnt ?>_vlokpetugas_Nama_Petugas" class="vlokpetugas_Nama_Petugas">
<span<?php echo $vlokpetugas->Nama_Petugas->viewAttributes() ?>>
<?php echo $vlokpetugas->Nama_Petugas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vlokpetugas->NIK->Visible) { // NIK ?>
		<td<?php echo $vlokpetugas->NIK->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_delete->RowCnt ?>_vlokpetugas_NIK" class="vlokpetugas_NIK">
<span<?php echo $vlokpetugas->NIK->viewAttributes() ?>>
<?php echo $vlokpetugas->NIK->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vlokpetugas->Unit->Visible) { // Unit ?>
		<td<?php echo $vlokpetugas->Unit->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_delete->RowCnt ?>_vlokpetugas_Unit" class="vlokpetugas_Unit">
<span<?php echo $vlokpetugas->Unit->viewAttributes() ?>>
<?php echo $vlokpetugas->Unit->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vlokpetugas->Username->Visible) { // Username ?>
		<td<?php echo $vlokpetugas->Username->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_delete->RowCnt ?>_vlokpetugas_Username" class="vlokpetugas_Username">
<span<?php echo $vlokpetugas->Username->viewAttributes() ?>>
<?php echo $vlokpetugas->Username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vlokpetugas->Userlevel->Visible) { // Userlevel ?>
		<td<?php echo $vlokpetugas->Userlevel->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_delete->RowCnt ?>_vlokpetugas_Userlevel" class="vlokpetugas_Userlevel">
<span<?php echo $vlokpetugas->Userlevel->viewAttributes() ?>>
<?php echo $vlokpetugas->Userlevel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$vlokpetugas_delete->Recordset->moveNext();
}
$vlokpetugas_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $vlokpetugas_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$vlokpetugas_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vlokpetugas_delete->terminate();
?>