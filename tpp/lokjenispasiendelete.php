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
$lokjenispasien_delete = new lokjenispasien_delete();

// Run the page
$lokjenispasien_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokjenispasien_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokjenispasiendelete = currentForm = new ew.Form("flokjenispasiendelete", "delete");

// Form_CustomValidate event
flokjenispasiendelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokjenispasiendelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokjenispasien_delete->showPageHeader(); ?>
<?php
$lokjenispasien_delete->showMessage();
?>
<form name="flokjenispasiendelete" id="flokjenispasiendelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokjenispasien_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokjenispasien_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokjenispasien">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokjenispasien_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<th class="<?php echo $lokjenispasien->Id_JenisPasien->headerCellClass() ?>"><span id="elh_lokjenispasien_Id_JenisPasien" class="lokjenispasien_Id_JenisPasien"><?php echo $lokjenispasien->Id_JenisPasien->caption() ?></span></th>
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
		<th class="<?php echo $lokjenispasien->Jenis_Pasien->headerCellClass() ?>"><span id="elh_lokjenispasien_Jenis_Pasien" class="lokjenispasien_Jenis_Pasien"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokjenispasien_delete->RecCnt = 0;
$i = 0;
while (!$lokjenispasien_delete->Recordset->EOF) {
	$lokjenispasien_delete->RecCnt++;
	$lokjenispasien_delete->RowCnt++;

	// Set row properties
	$lokjenispasien->resetAttributes();
	$lokjenispasien->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokjenispasien_delete->loadRowValues($lokjenispasien_delete->Recordset);

	// Render row
	$lokjenispasien_delete->renderRow();
?>
	<tr<?php echo $lokjenispasien->rowAttributes() ?>>
<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td<?php echo $lokjenispasien->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $lokjenispasien_delete->RowCnt ?>_lokjenispasien_Id_JenisPasien" class="lokjenispasien_Id_JenisPasien">
<span<?php echo $lokjenispasien->Id_JenisPasien->viewAttributes() ?>>
<?php echo $lokjenispasien->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
		<td<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokjenispasien_delete->RowCnt ?>_lokjenispasien_Jenis_Pasien" class="lokjenispasien_Jenis_Pasien">
<span<?php echo $lokjenispasien->Jenis_Pasien->viewAttributes() ?>>
<?php echo $lokjenispasien->Jenis_Pasien->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokjenispasien_delete->Recordset->moveNext();
}
$lokjenispasien_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokjenispasien_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokjenispasien_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokjenispasien_delete->terminate();
?>