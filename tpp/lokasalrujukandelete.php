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
$lokasalrujukan_delete = new lokasalrujukan_delete();

// Run the page
$lokasalrujukan_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokasalrujukan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokasalrujukandelete = currentForm = new ew.Form("flokasalrujukandelete", "delete");

// Form_CustomValidate event
flokasalrujukandelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokasalrujukandelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokasalrujukan_delete->showPageHeader(); ?>
<?php
$lokasalrujukan_delete->showMessage();
?>
<form name="flokasalrujukandelete" id="flokasalrujukandelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokasalrujukan_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokasalrujukan_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokasalrujukan">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokasalrujukan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<th class="<?php echo $lokasalrujukan->Id_Rujukan->headerCellClass() ?>"><span id="elh_lokasalrujukan_Id_Rujukan" class="lokasalrujukan_Id_Rujukan"><?php echo $lokasalrujukan->Id_Rujukan->caption() ?></span></th>
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
		<th class="<?php echo $lokasalrujukan->Rujukan->headerCellClass() ?>"><span id="elh_lokasalrujukan_Rujukan" class="lokasalrujukan_Rujukan"><?php echo $lokasalrujukan->Rujukan->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokasalrujukan_delete->RecCnt = 0;
$i = 0;
while (!$lokasalrujukan_delete->Recordset->EOF) {
	$lokasalrujukan_delete->RecCnt++;
	$lokasalrujukan_delete->RowCnt++;

	// Set row properties
	$lokasalrujukan->resetAttributes();
	$lokasalrujukan->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokasalrujukan_delete->loadRowValues($lokasalrujukan_delete->Recordset);

	// Render row
	$lokasalrujukan_delete->renderRow();
?>
	<tr<?php echo $lokasalrujukan->rowAttributes() ?>>
<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td<?php echo $lokasalrujukan->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokasalrujukan_delete->RowCnt ?>_lokasalrujukan_Id_Rujukan" class="lokasalrujukan_Id_Rujukan">
<span<?php echo $lokasalrujukan->Id_Rujukan->viewAttributes() ?>>
<?php echo $lokasalrujukan->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
		<td<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokasalrujukan_delete->RowCnt ?>_lokasalrujukan_Rujukan" class="lokasalrujukan_Rujukan">
<span<?php echo $lokasalrujukan->Rujukan->viewAttributes() ?>>
<?php echo $lokasalrujukan->Rujukan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokasalrujukan_delete->Recordset->moveNext();
}
$lokasalrujukan_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokasalrujukan_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokasalrujukan_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokasalrujukan_delete->terminate();
?>