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
$lokpoliklinik_delete = new lokpoliklinik_delete();

// Run the page
$lokpoliklinik_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpoliklinik_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokpoliklinikdelete = currentForm = new ew.Form("flokpoliklinikdelete", "delete");

// Form_CustomValidate event
flokpoliklinikdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpoliklinikdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpoliklinik_delete->showPageHeader(); ?>
<?php
$lokpoliklinik_delete->showMessage();
?>
<form name="flokpoliklinikdelete" id="flokpoliklinikdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpoliklinik_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpoliklinik_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpoliklinik">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokpoliklinik_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
		<th class="<?php echo $lokpoliklinik->Nama_Poliklinik->headerCellClass() ?>"><span id="elh_lokpoliklinik_Nama_Poliklinik" class="lokpoliklinik_Nama_Poliklinik"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokpoliklinik_delete->RecCnt = 0;
$i = 0;
while (!$lokpoliklinik_delete->Recordset->EOF) {
	$lokpoliklinik_delete->RecCnt++;
	$lokpoliklinik_delete->RowCnt++;

	// Set row properties
	$lokpoliklinik->resetAttributes();
	$lokpoliklinik->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokpoliklinik_delete->loadRowValues($lokpoliklinik_delete->Recordset);

	// Render row
	$lokpoliklinik_delete->renderRow();
?>
	<tr<?php echo $lokpoliklinik->rowAttributes() ?>>
<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
		<td<?php echo $lokpoliklinik->Nama_Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $lokpoliklinik_delete->RowCnt ?>_lokpoliklinik_Nama_Poliklinik" class="lokpoliklinik_Nama_Poliklinik">
<span<?php echo $lokpoliklinik->Nama_Poliklinik->viewAttributes() ?>>
<?php echo $lokpoliklinik->Nama_Poliklinik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokpoliklinik_delete->Recordset->moveNext();
}
$lokpoliklinik_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpoliklinik_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokpoliklinik_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokpoliklinik_delete->terminate();
?>