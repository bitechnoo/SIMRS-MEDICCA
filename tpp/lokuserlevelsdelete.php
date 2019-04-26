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
$lokuserlevels_delete = new lokuserlevels_delete();

// Run the page
$lokuserlevels_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokuserlevels_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flokuserlevelsdelete = currentForm = new ew.Form("flokuserlevelsdelete", "delete");

// Form_CustomValidate event
flokuserlevelsdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokuserlevelsdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokuserlevels_delete->showPageHeader(); ?>
<?php
$lokuserlevels_delete->showMessage();
?>
<form name="flokuserlevelsdelete" id="flokuserlevelsdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokuserlevels_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokuserlevels_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevels">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($lokuserlevels_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
		<th class="<?php echo $lokuserlevels->userlevelid->headerCellClass() ?>"><span id="elh_lokuserlevels_userlevelid" class="lokuserlevels_userlevelid"><?php echo $lokuserlevels->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
		<th class="<?php echo $lokuserlevels->userlevelname->headerCellClass() ?>"><span id="elh_lokuserlevels_userlevelname" class="lokuserlevels_userlevelname"><?php echo $lokuserlevels->userlevelname->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$lokuserlevels_delete->RecCnt = 0;
$i = 0;
while (!$lokuserlevels_delete->Recordset->EOF) {
	$lokuserlevels_delete->RecCnt++;
	$lokuserlevels_delete->RowCnt++;

	// Set row properties
	$lokuserlevels->resetAttributes();
	$lokuserlevels->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$lokuserlevels_delete->loadRowValues($lokuserlevels_delete->Recordset);

	// Render row
	$lokuserlevels_delete->renderRow();
?>
	<tr<?php echo $lokuserlevels->rowAttributes() ?>>
<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
		<td<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevels_delete->RowCnt ?>_lokuserlevels_userlevelid" class="lokuserlevels_userlevelid">
<span<?php echo $lokuserlevels->userlevelid->viewAttributes() ?>>
<?php echo $lokuserlevels->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
		<td<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevels_delete->RowCnt ?>_lokuserlevels_userlevelname" class="lokuserlevels_userlevelname">
<span<?php echo $lokuserlevels->userlevelname->viewAttributes() ?>>
<?php echo $lokuserlevels->userlevelname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$lokuserlevels_delete->Recordset->moveNext();
}
$lokuserlevels_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokuserlevels_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$lokuserlevels_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokuserlevels_delete->terminate();
?>