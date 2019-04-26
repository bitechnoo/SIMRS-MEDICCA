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
$ugdbiayadaftar_add = new ugdbiayadaftar_add();

// Run the page
$ugdbiayadaftar_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugdbiayadaftar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fugdbiayadaftaradd = currentForm = new ew.Form("fugdbiayadaftaradd", "add");

// Validate form
fugdbiayadaftaradd.validate = function() {
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
		<?php if ($ugdbiayadaftar_add->Id_Biayadaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Biayadaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Id_Biayadaftar->caption(), $ugdbiayadaftar->Id_Biayadaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugdbiayadaftar_add->Nama_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Nama_Biaya->caption(), $ugdbiayadaftar->Nama_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugdbiayadaftar_add->Jasa_Dokter->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Dokter->caption(), $ugdbiayadaftar->Jasa_Dokter->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Dokter->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_add->Jasa_Layanan->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Layanan->caption(), $ugdbiayadaftar->Jasa_Layanan->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Layanan->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_add->Jasa_Sarana->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Sarana->caption(), $ugdbiayadaftar->Jasa_Sarana->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Sarana->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_add->Total_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Total_Biaya->caption(), $ugdbiayadaftar->Total_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Total_Biaya->errorMessage()) ?>");

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
fugdbiayadaftaradd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugdbiayadaftaradd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugdbiayadaftar_add->showPageHeader(); ?>
<?php
$ugdbiayadaftar_add->showMessage();
?>
<form name="fugdbiayadaftaradd" id="fugdbiayadaftaradd" class="<?php echo $ugdbiayadaftar_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugdbiayadaftar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugdbiayadaftar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugdbiayadaftar">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$ugdbiayadaftar_add->IsModal ?>">
<?php if (!$ugdbiayadaftar_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_ugdbiayadaftaradd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_Biayadaftar" class="form-group row">
		<label id="elh_ugdbiayadaftar_Id_Biayadaftar" for="x_Id_Biayadaftar" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?><?php echo ($ugdbiayadaftar->Id_Biayadaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Id_Biayadaftar->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Id_Biayadaftar">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Id_Biayadaftar" name="x_Id_Biayadaftar" id="x_Id_Biayadaftar" size="30" maxlength="50" value="<?php echo $ugdbiayadaftar->Id_Biayadaftar->EditValue ?>"<?php echo $ugdbiayadaftar->Id_Biayadaftar->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Biayadaftar">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Id_Biayadaftar"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?><?php echo ($ugdbiayadaftar->Id_Biayadaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Id_Biayadaftar->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Id_Biayadaftar">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Id_Biayadaftar" name="x_Id_Biayadaftar" id="x_Id_Biayadaftar" size="30" maxlength="50" value="<?php echo $ugdbiayadaftar->Id_Biayadaftar->EditValue ?>"<?php echo $ugdbiayadaftar->Id_Biayadaftar->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Biaya" class="form-group row">
		<label id="elh_ugdbiayadaftar_Nama_Biaya" for="x_Nama_Biaya" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Nama_Biaya">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="30" maxlength="250" value="<?php echo $ugdbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Nama_Biaya->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Nama_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Biaya">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Nama_Biaya"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Nama_Biaya">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="30" maxlength="250" value="<?php echo $ugdbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Nama_Biaya->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Nama_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Dokter" class="form-group row">
		<label id="elh_ugdbiayadaftar_Jasa_Dokter" for="x_Jasa_Dokter" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Dokter">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Dokter->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Dokter->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Dokter">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Dokter"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Dokter">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Dokter->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Dokter->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Layanan" class="form-group row">
		<label id="elh_ugdbiayadaftar_Jasa_Layanan" for="x_Jasa_Layanan" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Layanan">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Layanan->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Layanan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Layanan">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Layanan"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Layanan">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Layanan->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Layanan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Sarana" class="form-group row">
		<label id="elh_ugdbiayadaftar_Jasa_Sarana" for="x_Jasa_Sarana" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Sarana">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Sarana->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Sarana->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Sarana">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Sarana"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Sarana">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Sarana->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Jasa_Sarana->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Total_Biaya" class="form-group row">
		<label id="elh_ugdbiayadaftar_Total_Biaya" for="x_Total_Biaya" class="<?php echo $ugdbiayadaftar_add->LeftColumnClass ?>"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $ugdbiayadaftar_add->RightColumnClass ?>"><div<?php echo $ugdbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Total_Biaya">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $ugdbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Total_Biaya->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Total_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Total_Biaya">
		<td class="<?php echo $ugdbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Total_Biaya"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $ugdbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Total_Biaya">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $ugdbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Total_Biaya->editAttributes() ?>>
</span>
<?php echo $ugdbiayadaftar->Total_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$ugdbiayadaftar_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $ugdbiayadaftar_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugdbiayadaftar_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$ugdbiayadaftar_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$ugdbiayadaftar_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ugdbiayadaftar_add->terminate();
?>