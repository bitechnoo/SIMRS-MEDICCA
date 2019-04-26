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
$lokuserlevels_edit = new lokuserlevels_edit();

// Run the page
$lokuserlevels_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokuserlevels_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var flokuserlevelsedit = currentForm = new ew.Form("flokuserlevelsedit", "edit");

// Validate form
flokuserlevelsedit.validate = function() {
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
		<?php if ($lokuserlevels_edit->userlevelid->Required) { ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokuserlevels->userlevelid->caption(), $lokuserlevels->userlevelid->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokuserlevels->userlevelid->errorMessage()) ?>");
		<?php if ($lokuserlevels_edit->userlevelname->Required) { ?>
			elm = this.getElements("x" + infix + "_userlevelname");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokuserlevels->userlevelname->caption(), $lokuserlevels->userlevelname->RequiredErrorMessage)) ?>");
		<?php } ?>
			var elId = fobj.elements["x" + infix + "_userlevelid"];
			var elName = fobj.elements["x" + infix + "_userlevelname"];
			if (elId && elName) {
				elId.value = $.trim(elId.value);
				elName.value = $.trim(elName.value);
				if (elId && !ew.checkInteger(elId.value))
					return this.onError(elId, ew.language.phrase("UserLevelIDInteger"));
				var level = parseInt(elId.value, 10);
				if (level == 0 && !ew.sameText(elName.value, "Default")) {
					return this.onError(elName, ew.language.phrase("UserLevelDefaultName"));
				} else if (level == -1 && !ew.sameText(elName.value, "Administrator")) {
					return this.onError(elName, ew.language.phrase("UserLevelAdministratorName"));
				} else if (level == -2 && !ew.sameText(elName.value, "Anonymous")) {
					return this.onError(elName, ew.language.phrase("UserLevelAnonymousName"));
				} else if (level < -2) {
					return this.onError(elId, ew.language.phrase("UserLevelIDIncorrect"));
				} else if (level > 0 && ["anonymous", "administrator", "default"].includes(elName.value.toLowerCase())) {
					return this.onError(elName, ew.language.phrase("UserLevelNameIncorrect"));
				}
			}

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
flokuserlevelsedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokuserlevelsedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokuserlevels_edit->showPageHeader(); ?>
<?php
$lokuserlevels_edit->showMessage();
?>
<form name="flokuserlevelsedit" id="flokuserlevelsedit" class="<?php echo $lokuserlevels_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokuserlevels_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokuserlevels_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$lokuserlevels_edit->IsModal ?>">
<?php if (!$lokuserlevels_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokuserlevels_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokuserlevelsedit" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
<?php if ($lokuserlevels_edit->IsMobileOrModal) { ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_lokuserlevels_userlevelid" for="x_userlevelid" class="<?php echo $lokuserlevels_edit->LeftColumnClass ?>"><?php echo $lokuserlevels->userlevelid->caption() ?><?php echo ($lokuserlevels->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokuserlevels_edit->RightColumnClass ?>"><div<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelid">
<span<?php echo $lokuserlevels->userlevelid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($lokuserlevels->userlevelid->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="lokuserlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" value="<?php echo HtmlEncode($lokuserlevels->userlevelid->CurrentValue) ?>">
<?php echo $lokuserlevels->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $lokuserlevels_edit->TableLeftColumnClass ?>"><span id="elh_lokuserlevels_userlevelid"><?php echo $lokuserlevels->userlevelid->caption() ?><?php echo ($lokuserlevels->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelid">
<span<?php echo $lokuserlevels->userlevelid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($lokuserlevels->userlevelid->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="lokuserlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" value="<?php echo HtmlEncode($lokuserlevels->userlevelid->CurrentValue) ?>">
<?php echo $lokuserlevels->userlevelid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
<?php if ($lokuserlevels_edit->IsMobileOrModal) { ?>
	<div id="r_userlevelname" class="form-group row">
		<label id="elh_lokuserlevels_userlevelname" for="x_userlevelname" class="<?php echo $lokuserlevels_edit->LeftColumnClass ?>"><?php echo $lokuserlevels->userlevelname->caption() ?><?php echo ($lokuserlevels->userlevelname->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokuserlevels_edit->RightColumnClass ?>"><div<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelname">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="80" value="<?php echo $lokuserlevels->userlevelname->EditValue ?>"<?php echo $lokuserlevels->userlevelname->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelname->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelname">
		<td class="<?php echo $lokuserlevels_edit->TableLeftColumnClass ?>"><span id="elh_lokuserlevels_userlevelname"><?php echo $lokuserlevels->userlevelname->caption() ?><?php echo ($lokuserlevels->userlevelname->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelname">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="80" value="<?php echo $lokuserlevels->userlevelname->EditValue ?>"<?php echo $lokuserlevels->userlevelname->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokuserlevels_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokuserlevels_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokuserlevels_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokuserlevels_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokuserlevels_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokuserlevels_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokuserlevels_edit->terminate();
?>