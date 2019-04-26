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
$ugduserlevelpermissions_delete = new ugduserlevelpermissions_delete();

// Run the page
$ugduserlevelpermissions_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugduserlevelpermissions_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fugduserlevelpermissionsdelete = currentForm = new ew.Form("fugduserlevelpermissionsdelete", "delete");

// Form_CustomValidate event
fugduserlevelpermissionsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugduserlevelpermissionsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugduserlevelpermissions_delete->showPageHeader(); ?>
<?php
$ugduserlevelpermissions_delete->showMessage();
?>
<form name="fugduserlevelpermissionsdelete" id="fugduserlevelpermissionsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugduserlevelpermissions_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugduserlevelpermissions_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugduserlevelpermissions">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($ugduserlevelpermissions_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
		<th class="<?php echo $ugduserlevelpermissions->userlevelid->headerCellClass() ?>"><span id="elh_ugduserlevelpermissions_userlevelid" class="ugduserlevelpermissions_userlevelid"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
		<th class="<?php echo $ugduserlevelpermissions->_tablename->headerCellClass() ?>"><span id="elh_ugduserlevelpermissions__tablename" class="ugduserlevelpermissions__tablename"><?php echo $ugduserlevelpermissions->_tablename->caption() ?></span></th>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
		<th class="<?php echo $ugduserlevelpermissions->permission->headerCellClass() ?>"><span id="elh_ugduserlevelpermissions_permission" class="ugduserlevelpermissions_permission"><?php echo $ugduserlevelpermissions->permission->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ugduserlevelpermissions_delete->RecCnt = 0;
$i = 0;
while (!$ugduserlevelpermissions_delete->Recordset->EOF) {
	$ugduserlevelpermissions_delete->RecCnt++;
	$ugduserlevelpermissions_delete->RowCnt++;

	// Set row properties
	$ugduserlevelpermissions->resetAttributes();
	$ugduserlevelpermissions->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$ugduserlevelpermissions_delete->loadRowValues($ugduserlevelpermissions_delete->Recordset);

	// Render row
	$ugduserlevelpermissions_delete->renderRow();
?>
	<tr<?php echo $ugduserlevelpermissions->rowAttributes() ?>>
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
		<td<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_delete->RowCnt ?>_ugduserlevelpermissions_userlevelid" class="ugduserlevelpermissions_userlevelid">
<span<?php echo $ugduserlevelpermissions->userlevelid->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
		<td<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_delete->RowCnt ?>_ugduserlevelpermissions__tablename" class="ugduserlevelpermissions__tablename">
<span<?php echo $ugduserlevelpermissions->_tablename->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->_tablename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
		<td<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_delete->RowCnt ?>_ugduserlevelpermissions_permission" class="ugduserlevelpermissions_permission">
<span<?php echo $ugduserlevelpermissions->permission->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->permission->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ugduserlevelpermissions_delete->Recordset->moveNext();
}
$ugduserlevelpermissions_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugduserlevelpermissions_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$ugduserlevelpermissions_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugduserlevelpermissions_delete->terminate();
?>