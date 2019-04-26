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
$vlokpetugas_add = new vlokpetugas_add();

// Run the page
$vlokpetugas_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vlokpetugas_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fvlokpetugasadd = currentForm = new ew.Form("fvlokpetugasadd", "add");

// Validate form
fvlokpetugasadd.validate = function() {
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
		<?php if ($vlokpetugas_add->Id_Petugas->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Petugas");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Id_Petugas->caption(), $vlokpetugas->Id_Petugas->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->Nama_Petugas->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Petugas");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Nama_Petugas->caption(), $vlokpetugas->Nama_Petugas->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->NIK->Required) { ?>
			elm = this.getElements("x" + infix + "_NIK");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->NIK->caption(), $vlokpetugas->NIK->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->Unit->Required) { ?>
			elm = this.getElements("x" + infix + "_Unit");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Unit->caption(), $vlokpetugas->Unit->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->Username->Required) { ?>
			elm = this.getElements("x" + infix + "_Username");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Username->caption(), $vlokpetugas->Username->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->Password->Required) { ?>
			elm = this.getElements("x" + infix + "_Password");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Password->caption(), $vlokpetugas->Password->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($vlokpetugas_add->Userlevel->Required) { ?>
			elm = this.getElements("x" + infix + "_Userlevel");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $vlokpetugas->Userlevel->caption(), $vlokpetugas->Userlevel->RequiredErrorMessage)) ?>");
		<?php } ?>

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
fvlokpetugasadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fvlokpetugasadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fvlokpetugasadd.lists["x_Userlevel"] = <?php echo $vlokpetugas_add->Userlevel->Lookup->toClientList() ?>;
fvlokpetugasadd.lists["x_Userlevel"].options = <?php echo JsonEncode($vlokpetugas_add->Userlevel->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $vlokpetugas_add->showPageHeader(); ?>
<?php
$vlokpetugas_add->showMessage();
?>
<form name="fvlokpetugasadd" id="fvlokpetugasadd" class="<?php echo $vlokpetugas_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($vlokpetugas_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $vlokpetugas_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vlokpetugas">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$vlokpetugas_add->IsModal ?>">
<!-- Fields to prevent google autofill -->
<input class="d-none" type="text" name="<?php echo Encrypt(Random()) ?>">
<input class="d-none" type="password" name="<?php echo Encrypt(Random()) ?>">
<?php if (!$vlokpetugas_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_vlokpetugasadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($vlokpetugas->Nama_Petugas->Visible) { // Nama_Petugas ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Petugas" class="form-group row">
		<label id="elh_vlokpetugas_Nama_Petugas" for="x_Nama_Petugas" class="<?php echo $vlokpetugas_add->LeftColumnClass ?>"><?php echo $vlokpetugas->Nama_Petugas->caption() ?><?php echo ($vlokpetugas->Nama_Petugas->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $vlokpetugas_add->RightColumnClass ?>"><div<?php echo $vlokpetugas->Nama_Petugas->cellAttributes() ?>>
<span id="el_vlokpetugas_Nama_Petugas">
<input type="text" data-table="vlokpetugas" data-field="x_Nama_Petugas" name="x_Nama_Petugas" id="x_Nama_Petugas" size="30" maxlength="35" value="<?php echo $vlokpetugas->Nama_Petugas->EditValue ?>"<?php echo $vlokpetugas->Nama_Petugas->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Nama_Petugas->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Petugas">
		<td class="<?php echo $vlokpetugas_add->TableLeftColumnClass ?>"><span id="elh_vlokpetugas_Nama_Petugas"><?php echo $vlokpetugas->Nama_Petugas->caption() ?><?php echo ($vlokpetugas->Nama_Petugas->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $vlokpetugas->Nama_Petugas->cellAttributes() ?>>
<span id="el_vlokpetugas_Nama_Petugas">
<input type="text" data-table="vlokpetugas" data-field="x_Nama_Petugas" name="x_Nama_Petugas" id="x_Nama_Petugas" size="30" maxlength="35" value="<?php echo $vlokpetugas->Nama_Petugas->EditValue ?>"<?php echo $vlokpetugas->Nama_Petugas->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Nama_Petugas->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->NIK->Visible) { // NIK ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
	<div id="r_NIK" class="form-group row">
		<label id="elh_vlokpetugas_NIK" for="x_NIK" class="<?php echo $vlokpetugas_add->LeftColumnClass ?>"><?php echo $vlokpetugas->NIK->caption() ?><?php echo ($vlokpetugas->NIK->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $vlokpetugas_add->RightColumnClass ?>"><div<?php echo $vlokpetugas->NIK->cellAttributes() ?>>
<span id="el_vlokpetugas_NIK">
<input type="text" data-table="vlokpetugas" data-field="x_NIK" name="x_NIK" id="x_NIK" size="30" maxlength="25" value="<?php echo $vlokpetugas->NIK->EditValue ?>"<?php echo $vlokpetugas->NIK->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->NIK->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_NIK">
		<td class="<?php echo $vlokpetugas_add->TableLeftColumnClass ?>"><span id="elh_vlokpetugas_NIK"><?php echo $vlokpetugas->NIK->caption() ?><?php echo ($vlokpetugas->NIK->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $vlokpetugas->NIK->cellAttributes() ?>>
<span id="el_vlokpetugas_NIK">
<input type="text" data-table="vlokpetugas" data-field="x_NIK" name="x_NIK" id="x_NIK" size="30" maxlength="25" value="<?php echo $vlokpetugas->NIK->EditValue ?>"<?php echo $vlokpetugas->NIK->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->NIK->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
	<span id="el_vlokpetugas_Unit">
	<input type="hidden" data-table="vlokpetugas" data-field="x_Unit" name="x_Unit" id="x_Unit" value="<?php echo HtmlEncode($vlokpetugas->Unit->CurrentValue) ?>">
	</span>
<?php if ($vlokpetugas->Username->Visible) { // Username ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
	<div id="r_Username" class="form-group row">
		<label id="elh_vlokpetugas_Username" for="x_Username" class="<?php echo $vlokpetugas_add->LeftColumnClass ?>"><?php echo $vlokpetugas->Username->caption() ?><?php echo ($vlokpetugas->Username->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $vlokpetugas_add->RightColumnClass ?>"><div<?php echo $vlokpetugas->Username->cellAttributes() ?>>
<span id="el_vlokpetugas_Username">
<input type="text" data-table="vlokpetugas" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="50" value="<?php echo $vlokpetugas->Username->EditValue ?>"<?php echo $vlokpetugas->Username->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Username->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Username">
		<td class="<?php echo $vlokpetugas_add->TableLeftColumnClass ?>"><span id="elh_vlokpetugas_Username"><?php echo $vlokpetugas->Username->caption() ?><?php echo ($vlokpetugas->Username->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $vlokpetugas->Username->cellAttributes() ?>>
<span id="el_vlokpetugas_Username">
<input type="text" data-table="vlokpetugas" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="50" value="<?php echo $vlokpetugas->Username->EditValue ?>"<?php echo $vlokpetugas->Username->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->Password->Visible) { // Password ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
	<div id="r_Password" class="form-group row">
		<label id="elh_vlokpetugas_Password" for="x_Password" class="<?php echo $vlokpetugas_add->LeftColumnClass ?>"><?php echo $vlokpetugas->Password->caption() ?><?php echo ($vlokpetugas->Password->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $vlokpetugas_add->RightColumnClass ?>"><div<?php echo $vlokpetugas->Password->cellAttributes() ?>>
<span id="el_vlokpetugas_Password">
<input type="text" data-table="vlokpetugas" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" value="<?php echo $vlokpetugas->Password->EditValue ?>"<?php echo $vlokpetugas->Password->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Password->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Password">
		<td class="<?php echo $vlokpetugas_add->TableLeftColumnClass ?>"><span id="elh_vlokpetugas_Password"><?php echo $vlokpetugas->Password->caption() ?><?php echo ($vlokpetugas->Password->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $vlokpetugas->Password->cellAttributes() ?>>
<span id="el_vlokpetugas_Password">
<input type="text" data-table="vlokpetugas" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" value="<?php echo $vlokpetugas->Password->EditValue ?>"<?php echo $vlokpetugas->Password->editAttributes() ?>>
</span>
<?php echo $vlokpetugas->Password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->Userlevel->Visible) { // Userlevel ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
	<div id="r_Userlevel" class="form-group row">
		<label id="elh_vlokpetugas_Userlevel" for="x_Userlevel" class="<?php echo $vlokpetugas_add->LeftColumnClass ?>"><?php echo $vlokpetugas->Userlevel->caption() ?><?php echo ($vlokpetugas->Userlevel->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $vlokpetugas_add->RightColumnClass ?>"><div<?php echo $vlokpetugas->Userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_vlokpetugas_Userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($vlokpetugas->Userlevel->EditValue) ?>">
</span>
<?php } else { ?>
<span id="el_vlokpetugas_Userlevel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="vlokpetugas" data-field="x_Userlevel" data-value-separator="<?php echo $vlokpetugas->Userlevel->displayValueSeparatorAttribute() ?>" id="x_Userlevel" name="x_Userlevel"<?php echo $vlokpetugas->Userlevel->editAttributes() ?>>
		<?php echo $vlokpetugas->Userlevel->selectOptionListHtml("x_Userlevel") ?>
	</select>
</div>
<?php echo $vlokpetugas->Userlevel->Lookup->getParamTag("p_x_Userlevel") ?>
</span>
<?php } ?>
<?php echo $vlokpetugas->Userlevel->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Userlevel">
		<td class="<?php echo $vlokpetugas_add->TableLeftColumnClass ?>"><span id="elh_vlokpetugas_Userlevel"><?php echo $vlokpetugas->Userlevel->caption() ?><?php echo ($vlokpetugas->Userlevel->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $vlokpetugas->Userlevel->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_vlokpetugas_Userlevel">
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($vlokpetugas->Userlevel->EditValue) ?>">
</span>
<?php } else { ?>
<span id="el_vlokpetugas_Userlevel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="vlokpetugas" data-field="x_Userlevel" data-value-separator="<?php echo $vlokpetugas->Userlevel->displayValueSeparatorAttribute() ?>" id="x_Userlevel" name="x_Userlevel"<?php echo $vlokpetugas->Userlevel->editAttributes() ?>>
		<?php echo $vlokpetugas->Userlevel->selectOptionListHtml("x_Userlevel") ?>
	</select>
</div>
<?php echo $vlokpetugas->Userlevel->Lookup->getParamTag("p_x_Userlevel") ?>
</span>
<?php } ?>
<?php echo $vlokpetugas->Userlevel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($vlokpetugas_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$vlokpetugas_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $vlokpetugas_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $vlokpetugas_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$vlokpetugas_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$vlokpetugas_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vlokpetugas_add->terminate();
?>