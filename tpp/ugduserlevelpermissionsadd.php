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
$ugduserlevelpermissions_add = new ugduserlevelpermissions_add();

// Run the page
$ugduserlevelpermissions_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugduserlevelpermissions_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fugduserlevelpermissionsadd = currentForm = new ew.Form("fugduserlevelpermissionsadd", "add");

// Validate form
fugduserlevelpermissionsadd.validate = function() {
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
		<?php if ($ugduserlevelpermissions_add->userlevelid->Required) { ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugduserlevelpermissions->userlevelid->caption(), $ugduserlevelpermissions->userlevelid->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugduserlevelpermissions->userlevelid->errorMessage()) ?>");
		<?php if ($ugduserlevelpermissions_add->_tablename->Required) { ?>
			elm = this.getElements("x" + infix + "__tablename");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugduserlevelpermissions->_tablename->caption(), $ugduserlevelpermissions->_tablename->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugduserlevelpermissions_add->permission->Required) { ?>
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
fugduserlevelpermissionsadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugduserlevelpermissionsadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugduserlevelpermissions_add->showPageHeader(); ?>
<?php
$ugduserlevelpermissions_add->showMessage();
?>
<form name="fugduserlevelpermissionsadd" id="fugduserlevelpermissionsadd" class="<?php echo $ugduserlevelpermissions_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugduserlevelpermissions_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugduserlevelpermissions_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugduserlevelpermissions">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$ugduserlevelpermissions_add->IsModal ?>">
<?php if (!$ugduserlevelpermissions_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($ugduserlevelpermissions_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_ugduserlevelpermissionsadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
<?php if ($ugduserlevelpermissions_add->IsMobileOrModal) { ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_ugduserlevelpermissions_userlevelid" for="x_userlevelid" class="<?php echo $ugduserlevelpermissions_add->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?><?php echo ($ugduserlevelpermissions->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_add->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_userlevelid">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" value="<?php echo $ugduserlevelpermissions->userlevelid->EditValue ?>"<?php echo $ugduserlevelpermissions->userlevelid->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $ugduserlevelpermissions_add->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_userlevelid"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?><?php echo ($ugduserlevelpermissions->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_userlevelid">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" value="<?php echo $ugduserlevelpermissions->userlevelid->EditValue ?>"<?php echo $ugduserlevelpermissions->userlevelid->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->userlevelid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
<?php if ($ugduserlevelpermissions_add->IsMobileOrModal) { ?>
	<div id="r__tablename" class="form-group row">
		<label id="elh_ugduserlevelpermissions__tablename" for="x__tablename" class="<?php echo $ugduserlevelpermissions_add->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->_tablename->caption() ?><?php echo ($ugduserlevelpermissions->_tablename->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_add->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions__tablename">
<input type="text" data-table="ugduserlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" size="30" maxlength="255" value="<?php echo $ugduserlevelpermissions->_tablename->EditValue ?>"<?php echo $ugduserlevelpermissions->_tablename->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->_tablename->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r__tablename">
		<td class="<?php echo $ugduserlevelpermissions_add->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions__tablename"><?php echo $ugduserlevelpermissions->_tablename->caption() ?><?php echo ($ugduserlevelpermissions->_tablename->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions__tablename">
<input type="text" data-table="ugduserlevelpermissions" data-field="x__tablename" name="x__tablename" id="x__tablename" size="30" maxlength="255" value="<?php echo $ugduserlevelpermissions->_tablename->EditValue ?>"<?php echo $ugduserlevelpermissions->_tablename->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->_tablename->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
<?php if ($ugduserlevelpermissions_add->IsMobileOrModal) { ?>
	<div id="r_permission" class="form-group row">
		<label id="elh_ugduserlevelpermissions_permission" for="x_permission" class="<?php echo $ugduserlevelpermissions_add->LeftColumnClass ?>"><?php echo $ugduserlevelpermissions->permission->caption() ?><?php echo ($ugduserlevelpermissions->permission->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugduserlevelpermissions_add->RightColumnClass ?>"><div<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_permission">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" value="<?php echo $ugduserlevelpermissions->permission->EditValue ?>"<?php echo $ugduserlevelpermissions->permission->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->permission->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_permission">
		<td class="<?php echo $ugduserlevelpermissions_add->TableLeftColumnClass ?>"><span id="elh_ugduserlevelpermissions_permission"><?php echo $ugduserlevelpermissions->permission->caption() ?><?php echo ($ugduserlevelpermissions->permission->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el_ugduserlevelpermissions_permission">
<input type="text" data-table="ugduserlevelpermissions" data-field="x_permission" name="x_permission" id="x_permission" size="30" value="<?php echo $ugduserlevelpermissions->permission->EditValue ?>"<?php echo $ugduserlevelpermissions->permission->editAttributes() ?>>
</span>
<?php echo $ugduserlevelpermissions->permission->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$ugduserlevelpermissions_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $ugduserlevelpermissions_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugduserlevelpermissions_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$ugduserlevelpermissions_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$ugduserlevelpermissions_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugduserlevelpermissions_add->terminate();
?>