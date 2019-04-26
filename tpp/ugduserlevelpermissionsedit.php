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
$ugduserlevelpermissions_edit = new ugduserlevelpermissions_edit();

// Run the page
$ugduserlevelpermissions_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugduserlevelpermissions_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fugduserlevelpermissionsedit = currentForm = new ew.Form("fugduserlevelpermissionsedit", "edit");

// Validate form
fugduserlevelpermissionsedit.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
	if ($fobj.find("#confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		<?php if ($ugduserlevelpermissions_edit->userlevelid->Required) { ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugduserlevelpermissions->userlevelid->caption(), $ugduserlevelpermissions->userlevelid->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugduserlevelpermissions->userlevelid->errorMessage()) ?>");
		<?php if ($ugduserlevelpermissions_edit->_tablename->Required) { ?>
			elm = this.getElements("x" + infix + "__tablename");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugduserlevelpermissions->_tablename->caption(), $ugduserlevelpermissions->_tablename->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugduserlevelpermissions_edit->permission->Required) { ?>
			elm = this.getElements("x" + infix + "_permission");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugduserlevelpermissions->permission->caption(), $ugduserlevelpermissions->permission->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_permission");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugduserlevelpermissions->permission->errorMessage()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ew.forms[val])
			if (!ew.forms[val].validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fugduserlevelpermissionsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugduserlevelpermissionsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugduserlevelpermissions_edit->showPageHeader(); ?>
<?php
$ugduserlevelpermissions_edit->showMessage();
?>
<form name="fugduserlevelpermissionsedit" id="fugduserlevelpermissionsedit" class="<?php echo $ugduserlevelpermissions_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugduserlevelpermissions_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugduserlevelpermissions_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugduserlevelpermissions">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$ugduserlevelpermissions_edit->IsModal ?>">
<?php if (!$ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_ugduserlevelpermissionsedit" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
<?php if ($ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_ugduserlevelpermissions_userlevelid" for="x_userlevelid" class="<?php echo $ugduserlevelpermissions_edit->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?><?php echo ($ugduserlevelpermissions->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_edit->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_userlevelid">
<span<?php echo $ugduserlevelpermissions->userlevelid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($ugduserlevelpermissions->userlevelid->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="ugduserlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" value="<?php echo HtmlEncode($ugduserlevelpermissions->userlevelid->CurrentValue) ?>">
<?php echo $ugduserlevelpermissions->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $ugduserlevelpermissions_edit->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_userlevelid"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?><?php echo ($ugduserlevelpermissions->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_userlevelid">
<span<?php echo $ugduserlevelpermissions->userlevelid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($ugduserlevelpermissions->userlevelid->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="ugduserlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" value="<?php echo HtmlEncode($ugduserlevelpermissions->userlevelid->CurrentValue) ?>">
<?php echo $ugduserlevelpermissions->userlevelid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
<?php if ($ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
	<div id="r__tablename" class="form-group row">
		<label id="elh_ugduserlevelpermissions__tablename" for="x__tablename" class="<?php echo $ugduserlevelpermissions_edit->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->_tablename->caption() ?><?php echo ($ugduserlevelpermissions->_tablename->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_edit->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions__tablename">
<span<?php echo $ugduserlevelpermissions->_tablename->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($ugduserlevelpermissions->_tablename->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="ugduserlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" value="<?php echo HtmlEncode($ugduserlevelpermissions->_tablename->CurrentValue) ?>">
<?php echo $ugduserlevelpermissions->_tablename->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r__tablename">
		<td class="<?php echo $ugduserlevelpermissions_edit->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions__tablename"><?php echo $ugduserlevelpermissions->_tablename->caption() ?><?php echo ($ugduserlevelpermissions->_tablename->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions__tablename">
<span<?php echo $ugduserlevelpermissions->_tablename->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($ugduserlevelpermissions->_tablename->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="ugduserlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" value="<?php echo HtmlEncode($ugduserlevelpermissions->_tablename->CurrentValue) ?>">
<?php echo $ugduserlevelpermissions->_tablename->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
<?php if ($ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
	<div id="r_permission" class="form-group row">
		<label id="elh_ugduserlevelpermissions_permission" for="x_permission" class="<?php echo $ugduserlevelpermissions_edit->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->permission->caption() ?><?php echo ($ugduserlevelpermissions->permission->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_edit->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_permission">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" value="<?php echo $ugduserlevelpermissions->permission->EditValue ?>"<?php echo $ugduserlevelpermissions->permission->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->permission->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_permission">
		<td class="<?php echo $ugduserlevelpermissions_edit->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_permission"><?php echo $ugduserlevelpermissions->permission->caption() ?><?php echo ($ugduserlevelpermissions->permission->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_permission">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" value="<?php echo $ugduserlevelpermissions->permission->EditValue ?>"<?php echo $ugduserlevelpermissions->permission->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->permission->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$ugduserlevelpermissions_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $ugduserlevelpermissions_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugduserlevelpermissions_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$ugduserlevelpermissions_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$ugduserlevelpermissions_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugduserlevelpermissions_edit->terminate();
?>