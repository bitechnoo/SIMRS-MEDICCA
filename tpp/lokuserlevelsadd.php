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
$lokuserlevels_add = new lokuserlevels_add();

// Run the page
$lokuserlevels_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokuserlevels_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokuserlevelsadd = currentForm = new ew.Form("flokuserlevelsadd", "add");

// Validate form
flokuserlevelsadd.validate = function() {
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
		<?php if ($lokuserlevels_add->userlevelid->Required) { ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokuserlevels->userlevelid->caption(), $lokuserlevels->userlevelid->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_userlevelid");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokuserlevels->userlevelid->errorMessage()) ?>");
		<?php if ($lokuserlevels_add->userlevelname->Required) { ?>
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
flokuserlevelsadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokuserlevelsadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokuserlevels_add->showPageHeader(); ?>
<?php
$lokuserlevels_add->showMessage();
?>
<form name="flokuserlevelsadd" id="flokuserlevelsadd" class="<?php echo $lokuserlevels_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokuserlevels_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokuserlevels_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevels">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokuserlevels_add->IsModal ?>">
<?php if (!$lokuserlevels_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokuserlevels_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokuserlevelsadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
<?php if ($lokuserlevels_add->IsMobileOrModal) { ?>
	<div id="r_userlevelid" class="form-group row">
		<label id="elh_lokuserlevels_userlevelid" for="x_userlevelid" class="<?php echo $lokuserlevels_add->LeftColumnClass ?>"><?php echo $lokuserlevels->userlevelid->caption() ?><?php echo ($lokuserlevels->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokuserlevels_add->RightColumnClass ?>"><div<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelid">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" value="<?php echo $lokuserlevels->userlevelid->EditValue ?>"<?php echo $lokuserlevels->userlevelid->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelid">
		<td class="<?php echo $lokuserlevels_add->TableLeftColumnClass ?>"><span id="elh_lokuserlevels_userlevelid"><?php echo $lokuserlevels->userlevelid->caption() ?><?php echo ($lokuserlevels->userlevelid->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelid">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelid" name="x_userlevelid" id="x_userlevelid" size="30" value="<?php echo $lokuserlevels->userlevelid->EditValue ?>"<?php echo $lokuserlevels->userlevelid->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
<?php if ($lokuserlevels_add->IsMobileOrModal) { ?>
	<div id="r_userlevelname" class="form-group row">
		<label id="elh_lokuserlevels_userlevelname" for="x_userlevelname" class="<?php echo $lokuserlevels_add->LeftColumnClass ?>"><?php echo $lokuserlevels->userlevelname->caption() ?><?php echo ($lokuserlevels->userlevelname->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokuserlevels_add->RightColumnClass ?>"><div<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelname">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="80" value="<?php echo $lokuserlevels->userlevelname->EditValue ?>"<?php echo $lokuserlevels->userlevelname->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelname->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_userlevelname">
		<td class="<?php echo $lokuserlevels_add->TableLeftColumnClass ?>"><span id="elh_lokuserlevels_userlevelname"><?php echo $lokuserlevels->userlevelname->caption() ?><?php echo ($lokuserlevels->userlevelname->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el_lokuserlevels_userlevelname">
<input type="text" data-table="lokuserlevels" data-field="x_userlevelname" name="x_userlevelname" id="x_userlevelname" size="30" maxlength="80" value="<?php echo $lokuserlevels->userlevelname->EditValue ?>"<?php echo $lokuserlevels->userlevelname->editAttributes() ?>>
</span>
<?php echo $lokuserlevels->userlevelname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
	<!-- row for permission values -->
<?php if ($lokuserlevels_add->IsMobileOrModal) { ?>
	<div id="rp_permission" class="form-group row">
		<label id="elh_permission" class="<?php echo $lokuserlevels_add->LeftColumnClass ?>"><?php echo HtmlTitle($Language->phrase("Permission")) ?></label>
		<div class="<?php echo $lokuserlevels_add->RightColumnClass ?>">
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowAdd" id="Add" value="<?php echo ALLOW_ADD ?>"><label class="form-check-label" for="Add"><?php echo $Language->Phrase("PermissionAddCopy") ?></label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowDelete" id="Delete" value="<?php echo ALLOW_DELETE ?>"><label class="form-check-label" for="Delete"><?php echo $Language->Phrase("PermissionDelete") ?></label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowEdit" id="Edit" value="<?php echo ALLOW_EDIT ?>"><label class="form-check-label" for="Edit"><?php echo $Language->Phrase("PermissionEdit") ?></label>
			</div>
			<?php if (defined(PROJECT_NAMESPACE . "USER_LEVEL_COMPAT")) { ?>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowList" id="List" value="<?php echo ALLOW_LIST ?>"><label class="form-check-label" for="List"><?php echo $Language->Phrase("PermissionListSearchView") ?></label>
			</div>
			<?php } else { ?>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowList" id="List" value="<?php echo ALLOW_LIST ?>"><label class="form-check-label" for="List"><?php echo $Language->Phrase("PermissionList") ?></label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowView" id="View" value="<?php echo ALLOW_VIEW ?>"><label class="form-check-label" for="View"><?php echo $Language->Phrase("PermissionView") ?></label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" class="form-check-input" name="x__AllowSearch" id="Search" value="<?php echo ALLOW_SEARCH ?>"><label class="form-check-label" for="Search"><?php echo $Language->Phrase("PermissionSearch") ?></label>
			</div>
<?php } ?>
		</div>
	</div>
<?php } else { ?>
	<tr id="rp_permission">
		<td class="<?php echo $lokuserlevels_add->TableLeftColumnClass ?>"><span id="elh_permission"><?php echo HtmlTitle($Language->phrase("Permission")) ?></span></td>
		<td>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowAdd" id="Add" value="<?php echo ALLOW_ADD ?>" /><label class="form-check-label" for="Add"><?php echo $Language->Phrase("PermissionAddCopy") ?></label>
			</div>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowDelete" id="Delete" value="<?php echo ALLOW_DELETE ?>" /><label class="form-check-label" for="Delete"><?php echo $Language->Phrase("PermissionDelete") ?></label>
		</div>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowEdit" id="Edit" value="<?php echo ALLOW_EDIT ?>" /><label class="form-check-label" for="Edit"><?php echo $Language->Phrase("PermissionEdit") ?></label>
		</div>
		<?php if (defined(PROJECT_NAMESPACE . "USER_LEVEL_COMPAT")) { ?>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowList" id="List" value="<?php echo ALLOW_LIST ?>" /><label class="form-check-label" for="List"><?php echo $Language->Phrase("PermissionListSearchView") ?></label>
		</div>
		<?php } else { ?>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowList" id="List" value="<?php echo ALLOW_LIST ?>" /><label class="form-check-label" for="List"><?php echo $Language->Phrase("PermissionList") ?></label>
		</div>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowView" id="View" value="<?php echo ALLOW_VIEW ?>" /><label class="form-check-label" for="View"><?php echo $Language->Phrase("PermissionView") ?></label>
		</div>
		<div class="form-check form-check-inline">
			<input type="checkbox" class="form-check-input" name="x__AllowSearch" id="Search" value="<?php echo ALLOW_SEARCH ?>" /><label class="form-check-label" for="Search"><?php echo $Language->Phrase("PermissionSearch") ?></label>
		</div>
<?php } ?>
		</td>
	</tr>
<?php } ?>
<?php if ($lokuserlevels_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokuserlevels_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokuserlevels_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokuserlevels_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokuserlevels_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokuserlevels_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokuserlevels_add->terminate();
?>