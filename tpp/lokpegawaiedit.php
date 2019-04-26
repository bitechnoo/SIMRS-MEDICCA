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
$lokpegawai_edit = new lokpegawai_edit();

// Run the page
$lokpegawai_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpegawai_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var flokpegawaiedit = currentForm = new ew.Form("flokpegawaiedit", "edit");

// Validate form
flokpegawaiedit.validate = function() {
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
		<?php if ($lokpegawai_edit->Id_Pegawai->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Pegawai");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Id_Pegawai->caption(), $lokpegawai->Id_Pegawai->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Nama_Pegawai->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Pegawai");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Nama_Pegawai->caption(), $lokpegawai->Nama_Pegawai->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->NIK->Required) { ?>
			elm = this.getElements("x" + infix + "_NIK");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->NIK->caption(), $lokpegawai->NIK->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Unit->Required) { ?>
			elm = this.getElements("x" + infix + "_Unit");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Unit->caption(), $lokpegawai->Unit->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Jenis_Pegawai->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Pegawai");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Jenis_Pegawai->caption(), $lokpegawai->Jenis_Pegawai->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Username->Required) { ?>
			elm = this.getElements("x" + infix + "_Username");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Username->caption(), $lokpegawai->Username->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Password->Required) { ?>
			elm = this.getElements("x" + infix + "_Password");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Password->caption(), $lokpegawai->Password->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpegawai_edit->Userlevel->Required) { ?>
			elm = this.getElements("x" + infix + "_Userlevel");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpegawai->Userlevel->caption(), $lokpegawai->Userlevel->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Userlevel");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokpegawai->Userlevel->errorMessage()) ?>");

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
flokpegawaiedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpegawaiedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpegawai_edit->showPageHeader(); ?>
<?php
$lokpegawai_edit->showMessage();
?>
<form name="flokpegawaiedit" id="flokpegawaiedit" class="<?php echo $lokpegawai_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpegawai_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpegawai_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpegawai">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$lokpegawai_edit->IsModal ?>">
<?php if (!$lokpegawai_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokpegawaiedit" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Id_Pegawai" class="form-group row">
		<label id="elh_lokpegawai_Id_Pegawai" for="x_Id_Pegawai" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Id_Pegawai->caption() ?><?php echo ($lokpegawai->Id_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Id_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Id_Pegawai">
<span<?php echo $lokpegawai->Id_Pegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($lokpegawai->Id_Pegawai->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="lokpegawai" data-field="x_Id_Pegawai" name="x_Id_Pegawai" id="x_Id_Pegawai" value="<?php echo HtmlEncode($lokpegawai->Id_Pegawai->CurrentValue) ?>">
<?php echo $lokpegawai->Id_Pegawai->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Pegawai">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Id_Pegawai"><?php echo $lokpegawai->Id_Pegawai->caption() ?><?php echo ($lokpegawai->Id_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Id_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Id_Pegawai">
<span<?php echo $lokpegawai->Id_Pegawai->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($lokpegawai->Id_Pegawai->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="lokpegawai" data-field="x_Id_Pegawai" name="x_Id_Pegawai" id="x_Id_Pegawai" value="<?php echo HtmlEncode($lokpegawai->Id_Pegawai->CurrentValue) ?>">
<?php echo $lokpegawai->Id_Pegawai->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Nama_Pegawai" class="form-group row">
		<label id="elh_lokpegawai_Nama_Pegawai" for="x_Nama_Pegawai" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Nama_Pegawai->caption() ?><?php echo ($lokpegawai->Nama_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Nama_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Nama_Pegawai">
<input type="text" data-table="lokpegawai" data-field="x_Nama_Pegawai" name="x_Nama_Pegawai" id="x_Nama_Pegawai" size="30" maxlength="50" value="<?php echo $lokpegawai->Nama_Pegawai->EditValue ?>"<?php echo $lokpegawai->Nama_Pegawai->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Nama_Pegawai->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Pegawai">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Nama_Pegawai"><?php echo $lokpegawai->Nama_Pegawai->caption() ?><?php echo ($lokpegawai->Nama_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Nama_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Nama_Pegawai">
<input type="text" data-table="lokpegawai" data-field="x_Nama_Pegawai" name="x_Nama_Pegawai" id="x_Nama_Pegawai" size="30" maxlength="50" value="<?php echo $lokpegawai->Nama_Pegawai->EditValue ?>"<?php echo $lokpegawai->Nama_Pegawai->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Nama_Pegawai->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_NIK" class="form-group row">
		<label id="elh_lokpegawai_NIK" for="x_NIK" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->NIK->caption() ?><?php echo ($lokpegawai->NIK->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->NIK->cellAttributes() ?>>
<span id="el_lokpegawai_NIK">
<input type="text" data-table="lokpegawai" data-field="x_NIK" name="x_NIK" id="x_NIK" size="30" maxlength="50" value="<?php echo $lokpegawai->NIK->EditValue ?>"<?php echo $lokpegawai->NIK->editAttributes() ?>>
</span>
<?php echo $lokpegawai->NIK->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_NIK">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_NIK"><?php echo $lokpegawai->NIK->caption() ?><?php echo ($lokpegawai->NIK->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->NIK->cellAttributes() ?>>
<span id="el_lokpegawai_NIK">
<input type="text" data-table="lokpegawai" data-field="x_NIK" name="x_NIK" id="x_NIK" size="30" maxlength="50" value="<?php echo $lokpegawai->NIK->EditValue ?>"<?php echo $lokpegawai->NIK->editAttributes() ?>>
</span>
<?php echo $lokpegawai->NIK->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Unit" class="form-group row">
		<label id="elh_lokpegawai_Unit" for="x_Unit" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Unit->caption() ?><?php echo ($lokpegawai->Unit->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Unit->cellAttributes() ?>>
<span id="el_lokpegawai_Unit">
<input type="text" data-table="lokpegawai" data-field="x_Unit" name="x_Unit" id="x_Unit" size="30" maxlength="20" value="<?php echo $lokpegawai->Unit->EditValue ?>"<?php echo $lokpegawai->Unit->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Unit->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Unit">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Unit"><?php echo $lokpegawai->Unit->caption() ?><?php echo ($lokpegawai->Unit->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Unit->cellAttributes() ?>>
<span id="el_lokpegawai_Unit">
<input type="text" data-table="lokpegawai" data-field="x_Unit" name="x_Unit" id="x_Unit" size="30" maxlength="20" value="<?php echo $lokpegawai->Unit->EditValue ?>"<?php echo $lokpegawai->Unit->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Unit->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Jenis_Pegawai" class="form-group row">
		<label id="elh_lokpegawai_Jenis_Pegawai" for="x_Jenis_Pegawai" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?><?php echo ($lokpegawai->Jenis_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Jenis_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Jenis_Pegawai">
<input type="text" data-table="lokpegawai" data-field="x_Jenis_Pegawai" name="x_Jenis_Pegawai" id="x_Jenis_Pegawai" size="30" maxlength="50" value="<?php echo $lokpegawai->Jenis_Pegawai->EditValue ?>"<?php echo $lokpegawai->Jenis_Pegawai->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Jenis_Pegawai->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Pegawai">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Jenis_Pegawai"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?><?php echo ($lokpegawai->Jenis_Pegawai->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Jenis_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Jenis_Pegawai">
<input type="text" data-table="lokpegawai" data-field="x_Jenis_Pegawai" name="x_Jenis_Pegawai" id="x_Jenis_Pegawai" size="30" maxlength="50" value="<?php echo $lokpegawai->Jenis_Pegawai->EditValue ?>"<?php echo $lokpegawai->Jenis_Pegawai->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Jenis_Pegawai->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Username->Visible) { // Username ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Username" class="form-group row">
		<label id="elh_lokpegawai_Username" for="x_Username" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Username->caption() ?><?php echo ($lokpegawai->Username->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Username->cellAttributes() ?>>
<span id="el_lokpegawai_Username">
<input type="text" data-table="lokpegawai" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="50" value="<?php echo $lokpegawai->Username->EditValue ?>"<?php echo $lokpegawai->Username->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Username->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Username">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Username"><?php echo $lokpegawai->Username->caption() ?><?php echo ($lokpegawai->Username->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Username->cellAttributes() ?>>
<span id="el_lokpegawai_Username">
<input type="text" data-table="lokpegawai" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="50" value="<?php echo $lokpegawai->Username->EditValue ?>"<?php echo $lokpegawai->Username->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Password->Visible) { // Password ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Password" class="form-group row">
		<label id="elh_lokpegawai_Password" for="x_Password" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Password->caption() ?><?php echo ($lokpegawai->Password->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Password->cellAttributes() ?>>
<span id="el_lokpegawai_Password">
<input type="text" data-table="lokpegawai" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" value="<?php echo $lokpegawai->Password->EditValue ?>"<?php echo $lokpegawai->Password->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Password->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Password">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Password"><?php echo $lokpegawai->Password->caption() ?><?php echo ($lokpegawai->Password->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Password->cellAttributes() ?>>
<span id="el_lokpegawai_Password">
<input type="text" data-table="lokpegawai" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" value="<?php echo $lokpegawai->Password->EditValue ?>"<?php echo $lokpegawai->Password->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
	<div id="r_Userlevel" class="form-group row">
		<label id="elh_lokpegawai_Userlevel" for="x_Userlevel" class="<?php echo $lokpegawai_edit->LeftColumnClass ?>"><?php echo $lokpegawai->Userlevel->caption() ?><?php echo ($lokpegawai->Userlevel->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpegawai_edit->RightColumnClass ?>"><div<?php echo $lokpegawai->Userlevel->cellAttributes() ?>>
<span id="el_lokpegawai_Userlevel">
<input type="text" data-table="lokpegawai" data-field="x_Userlevel" name="x_Userlevel" id="x_Userlevel" size="30" value="<?php echo $lokpegawai->Userlevel->EditValue ?>"<?php echo $lokpegawai->Userlevel->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Userlevel->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Userlevel">
		<td class="<?php echo $lokpegawai_edit->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Userlevel"><?php echo $lokpegawai->Userlevel->caption() ?><?php echo ($lokpegawai->Userlevel->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpegawai->Userlevel->cellAttributes() ?>>
<span id="el_lokpegawai_Userlevel">
<input type="text" data-table="lokpegawai" data-field="x_Userlevel" name="x_Userlevel" id="x_Userlevel" size="30" value="<?php echo $lokpegawai->Userlevel->EditValue ?>"<?php echo $lokpegawai->Userlevel->editAttributes() ?>>
</span>
<?php echo $lokpegawai->Userlevel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpegawai_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokpegawai_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokpegawai_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpegawai_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokpegawai_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokpegawai_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokpegawai_edit->terminate();
?>