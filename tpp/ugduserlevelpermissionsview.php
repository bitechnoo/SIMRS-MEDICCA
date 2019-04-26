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
$ugduserlevelpermissions_view = new ugduserlevelpermissions_view();

// Run the page
$ugduserlevelpermissions_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugduserlevelpermissions_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fugduserlevelpermissionsview = currentForm = new ew.Form("fugduserlevelpermissionsview", "view");

// Form_CustomValidate event
fugduserlevelpermissionsview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugduserlevelpermissionsview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $ugduserlevelpermissions_view->ExportOptions->render("body") ?>
<?php $ugduserlevelpermissions_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ugduserlevelpermissions_view->showPageHeader(); ?>
<?php
$ugduserlevelpermissions_view->showMessage();
?>
<form name="fugduserlevelpermissionsview" id="fugduserlevelpermissionsview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugduserlevelpermissions_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugduserlevelpermissions_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugduserlevelpermissions">
<input type="hidden" name="modal" value="<?php echo (int)$ugduserlevelpermissions_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $ugduserlevelpermissions_view->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_userlevelid"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?></span></td>
		<td data-name="userlevelid"<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_userlevelid">
<span<?php echo $ugduserlevelpermissions->userlevelid->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->userlevelid->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
	<tr id="r__tablename">
		<td class="<?php echo $ugduserlevelpermissions_view->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions__tablename"><?php echo $ugduserlevelpermissions->_tablename->caption() ?></span></td>
		<td data-name="_tablename"<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions__tablename">
<span<?php echo $ugduserlevelpermissions->_tablename->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->_tablename->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
	<tr id="r_permission">
		<td class="<?php echo $ugduserlevelpermissions_view->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_permission"><?php echo $ugduserlevelpermissions->permission->caption() ?></span></td>
		<td data-name="permission"<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_permission">
<span<?php echo $ugduserlevelpermissions->permission->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->permission->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$ugduserlevelpermissions_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ugduserlevelpermissions_view->terminate();
?>