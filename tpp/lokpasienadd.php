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
$lokpasien_add = new lokpasien_add();

// Run the page
$lokpasien_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpasien_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokpasienadd = currentForm = new ew.Form("flokpasienadd", "add");

// Validate form
flokpasienadd.validate = function() {
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
		<?php if ($lokpasien_add->Id_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Id_Pasien->caption(), $lokpasien->Id_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->No_RM->Required) { ?>
			elm = this.getElements("x" + infix + "_No_RM");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->No_RM->caption(), $lokpasien->No_RM->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Nama_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Nama_Pasien->caption(), $lokpasien->Nama_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->No_BPJS->Required) { ?>
			elm = this.getElements("x" + infix + "_No_BPJS");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->No_BPJS->caption(), $lokpasien->No_BPJS->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->No_KTP->Required) { ?>
			elm = this.getElements("x" + infix + "_No_KTP");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->No_KTP->caption(), $lokpasien->No_KTP->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Tempat_Lahir->Required) { ?>
			elm = this.getElements("x" + infix + "_Tempat_Lahir");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Tempat_Lahir->caption(), $lokpasien->Tempat_Lahir->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Tgl_Lahir->Required) { ?>
			elm = this.getElements("x" + infix + "_Tgl_Lahir");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Tgl_Lahir->caption(), $lokpasien->Tgl_Lahir->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Tgl_Lahir");
			if (elm && !ew.checkEuroDate(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokpasien->Tgl_Lahir->errorMessage()) ?>");
		<?php if ($lokpasien_add->Jenis_Kelamin->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Kelamin");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Jenis_Kelamin->caption(), $lokpasien->Jenis_Kelamin->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Alamat->Required) { ?>
			elm = this.getElements("x" + infix + "_Alamat");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Alamat->caption(), $lokpasien->Alamat->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Id_Kelurahan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Kelurahan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Id_Kelurahan->caption(), $lokpasien->Id_Kelurahan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Agama->Required) { ?>
			elm = this.getElements("x" + infix + "_Agama");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Agama->caption(), $lokpasien->Agama->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpasien_add->Lama_Baru->Required) { ?>
			elm = this.getElements("x" + infix + "_Lama_Baru");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpasien->Lama_Baru->caption(), $lokpasien->Lama_Baru->RequiredErrorMessage)) ?>");
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
flokpasienadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpasienadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokpasienadd.lists["x_Jenis_Kelamin"] = <?php echo $lokpasien_add->Jenis_Kelamin->Lookup->toClientList() ?>;
flokpasienadd.lists["x_Jenis_Kelamin"].options = <?php echo JsonEncode($lokpasien_add->Jenis_Kelamin->options(FALSE, TRUE)) ?>;
flokpasienadd.lists["x_Id_Kelurahan"] = <?php echo $lokpasien_add->Id_Kelurahan->Lookup->toClientList() ?>;
flokpasienadd.lists["x_Id_Kelurahan"].options = <?php echo JsonEncode($lokpasien_add->Id_Kelurahan->lookupOptions()) ?>;
flokpasienadd.lists["x_Agama"] = <?php echo $lokpasien_add->Agama->Lookup->toClientList() ?>;
flokpasienadd.lists["x_Agama"].options = <?php echo JsonEncode($lokpasien_add->Agama->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpasien_add->showPageHeader(); ?>
<?php
$lokpasien_add->showMessage();
?>
<form name="flokpasienadd" id="flokpasienadd" class="<?php echo $lokpasien_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpasien_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpasien_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpasien">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokpasien_add->IsModal ?>">
<?php if (!$lokpasien_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokpasienadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokpasien->Nama_Pasien->Visible) { // Nama_Pasien ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Pasien" class="form-group row">
		<label id="elh_lokpasien_Nama_Pasien" for="x_Nama_Pasien" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Nama_Pasien->caption() ?><?php echo ($lokpasien->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Nama_Pasien->cellAttributes() ?>>
<span id="el_lokpasien_Nama_Pasien">
<input type="text" data-table="lokpasien" data-field="x_Nama_Pasien" name="x_Nama_Pasien" id="x_Nama_Pasien" size="30" maxlength="50" value="<?php echo $lokpasien->Nama_Pasien->EditValue ?>"<?php echo $lokpasien->Nama_Pasien->editAttributes() ?>>
</span>
<?php echo $lokpasien->Nama_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Pasien">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Nama_Pasien"><?php echo $lokpasien->Nama_Pasien->caption() ?><?php echo ($lokpasien->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Nama_Pasien->cellAttributes() ?>>
<span id="el_lokpasien_Nama_Pasien">
<input type="text" data-table="lokpasien" data-field="x_Nama_Pasien" name="x_Nama_Pasien" id="x_Nama_Pasien" size="30" maxlength="50" value="<?php echo $lokpasien->Nama_Pasien->EditValue ?>"<?php echo $lokpasien->Nama_Pasien->editAttributes() ?>>
</span>
<?php echo $lokpasien->Nama_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->No_BPJS->Visible) { // No_BPJS ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_No_BPJS" class="form-group row">
		<label id="elh_lokpasien_No_BPJS" for="x_No_BPJS" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->No_BPJS->caption() ?><?php echo ($lokpasien->No_BPJS->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->No_BPJS->cellAttributes() ?>>
<span id="el_lokpasien_No_BPJS">
<input type="text" data-table="lokpasien" data-field="x_No_BPJS" name="x_No_BPJS" id="x_No_BPJS" size="30" maxlength="20" value="<?php echo $lokpasien->No_BPJS->EditValue ?>"<?php echo $lokpasien->No_BPJS->editAttributes() ?>>
</span>
<?php echo $lokpasien->No_BPJS->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_No_BPJS">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_No_BPJS"><?php echo $lokpasien->No_BPJS->caption() ?><?php echo ($lokpasien->No_BPJS->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->No_BPJS->cellAttributes() ?>>
<span id="el_lokpasien_No_BPJS">
<input type="text" data-table="lokpasien" data-field="x_No_BPJS" name="x_No_BPJS" id="x_No_BPJS" size="30" maxlength="20" value="<?php echo $lokpasien->No_BPJS->EditValue ?>"<?php echo $lokpasien->No_BPJS->editAttributes() ?>>
</span>
<?php echo $lokpasien->No_BPJS->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->No_KTP->Visible) { // No_KTP ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_No_KTP" class="form-group row">
		<label id="elh_lokpasien_No_KTP" for="x_No_KTP" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->No_KTP->caption() ?><?php echo ($lokpasien->No_KTP->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->No_KTP->cellAttributes() ?>>
<span id="el_lokpasien_No_KTP">
<input type="text" data-table="lokpasien" data-field="x_No_KTP" name="x_No_KTP" id="x_No_KTP" size="30" maxlength="20" value="<?php echo $lokpasien->No_KTP->EditValue ?>"<?php echo $lokpasien->No_KTP->editAttributes() ?>>
</span>
<?php echo $lokpasien->No_KTP->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_No_KTP">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_No_KTP"><?php echo $lokpasien->No_KTP->caption() ?><?php echo ($lokpasien->No_KTP->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->No_KTP->cellAttributes() ?>>
<span id="el_lokpasien_No_KTP">
<input type="text" data-table="lokpasien" data-field="x_No_KTP" name="x_No_KTP" id="x_No_KTP" size="30" maxlength="20" value="<?php echo $lokpasien->No_KTP->EditValue ?>"<?php echo $lokpasien->No_KTP->editAttributes() ?>>
</span>
<?php echo $lokpasien->No_KTP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Tempat_Lahir->Visible) { // Tempat_Lahir ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Tempat_Lahir" class="form-group row">
		<label id="elh_lokpasien_Tempat_Lahir" for="x_Tempat_Lahir" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Tempat_Lahir->caption() ?><?php echo ($lokpasien->Tempat_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Tempat_Lahir->cellAttributes() ?>>
<span id="el_lokpasien_Tempat_Lahir">
<input type="text" data-table="lokpasien" data-field="x_Tempat_Lahir" name="x_Tempat_Lahir" id="x_Tempat_Lahir" size="30" maxlength="75" value="<?php echo $lokpasien->Tempat_Lahir->EditValue ?>"<?php echo $lokpasien->Tempat_Lahir->editAttributes() ?>>
</span>
<?php echo $lokpasien->Tempat_Lahir->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tempat_Lahir">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Tempat_Lahir"><?php echo $lokpasien->Tempat_Lahir->caption() ?><?php echo ($lokpasien->Tempat_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Tempat_Lahir->cellAttributes() ?>>
<span id="el_lokpasien_Tempat_Lahir">
<input type="text" data-table="lokpasien" data-field="x_Tempat_Lahir" name="x_Tempat_Lahir" id="x_Tempat_Lahir" size="30" maxlength="75" value="<?php echo $lokpasien->Tempat_Lahir->EditValue ?>"<?php echo $lokpasien->Tempat_Lahir->editAttributes() ?>>
</span>
<?php echo $lokpasien->Tempat_Lahir->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Tgl_Lahir" class="form-group row">
		<label id="elh_lokpasien_Tgl_Lahir" for="x_Tgl_Lahir" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Tgl_Lahir->caption() ?><?php echo ($lokpasien->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Tgl_Lahir->cellAttributes() ?>>
<span id="el_lokpasien_Tgl_Lahir">
<input type="text" data-table="lokpasien" data-field="x_Tgl_Lahir" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="10" value="<?php echo $lokpasien->Tgl_Lahir->EditValue ?>"<?php echo $lokpasien->Tgl_Lahir->editAttributes() ?>>
<?php if (!$lokpasien->Tgl_Lahir->ReadOnly && !$lokpasien->Tgl_Lahir->Disabled && !isset($lokpasien->Tgl_Lahir->EditAttrs["readonly"]) && !isset($lokpasien->Tgl_Lahir->EditAttrs["disabled"])) { ?>
<script>
ew.createDateTimePicker("flokpasienadd", "x_Tgl_Lahir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $lokpasien->Tgl_Lahir->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tgl_Lahir">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Tgl_Lahir"><?php echo $lokpasien->Tgl_Lahir->caption() ?><?php echo ($lokpasien->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Tgl_Lahir->cellAttributes() ?>>
<span id="el_lokpasien_Tgl_Lahir">
<input type="text" data-table="lokpasien" data-field="x_Tgl_Lahir" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="10" value="<?php echo $lokpasien->Tgl_Lahir->EditValue ?>"<?php echo $lokpasien->Tgl_Lahir->editAttributes() ?>>
<?php if (!$lokpasien->Tgl_Lahir->ReadOnly && !$lokpasien->Tgl_Lahir->Disabled && !isset($lokpasien->Tgl_Lahir->EditAttrs["readonly"]) && !isset($lokpasien->Tgl_Lahir->EditAttrs["disabled"])) { ?>
<script>
ew.createDateTimePicker("flokpasienadd", "x_Tgl_Lahir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $lokpasien->Tgl_Lahir->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Jenis_Kelamin" class="form-group row">
		<label id="elh_lokpasien_Jenis_Kelamin" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Jenis_Kelamin->caption() ?><?php echo ($lokpasien->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_lokpasien_Jenis_Kelamin">
<div id="tp_x_Jenis_Kelamin" class="ew-template"><input type="radio" class="form-check-input" data-table="lokpasien" data-field="x_Jenis_Kelamin" data-value-separator="<?php echo $lokpasien->Jenis_Kelamin->displayValueSeparatorAttribute() ?>" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" value="{value}"<?php echo $lokpasien->Jenis_Kelamin->editAttributes() ?>></div>
<div id="dsl_x_Jenis_Kelamin" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $lokpasien->Jenis_Kelamin->radioButtonListHtml(FALSE, "x_Jenis_Kelamin") ?>
</div></div>
</span>
<?php echo $lokpasien->Jenis_Kelamin->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Kelamin">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Jenis_Kelamin"><?php echo $lokpasien->Jenis_Kelamin->caption() ?><?php echo ($lokpasien->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Jenis_Kelamin->cellAttributes() ?>>
<span id="el_lokpasien_Jenis_Kelamin">
<div id="tp_x_Jenis_Kelamin" class="ew-template"><input type="radio" class="form-check-input" data-table="lokpasien" data-field="x_Jenis_Kelamin" data-value-separator="<?php echo $lokpasien->Jenis_Kelamin->displayValueSeparatorAttribute() ?>" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" value="{value}"<?php echo $lokpasien->Jenis_Kelamin->editAttributes() ?>></div>
<div id="dsl_x_Jenis_Kelamin" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $lokpasien->Jenis_Kelamin->radioButtonListHtml(FALSE, "x_Jenis_Kelamin") ?>
</div></div>
</span>
<?php echo $lokpasien->Jenis_Kelamin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Alamat->Visible) { // Alamat ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Alamat" class="form-group row">
		<label id="elh_lokpasien_Alamat" for="x_Alamat" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Alamat->caption() ?><?php echo ($lokpasien->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Alamat->cellAttributes() ?>>
<span id="el_lokpasien_Alamat">
<textarea data-table="lokpasien" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4"<?php echo $lokpasien->Alamat->editAttributes() ?>><?php echo $lokpasien->Alamat->EditValue ?></textarea>
</span>
<?php echo $lokpasien->Alamat->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Alamat">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Alamat"><?php echo $lokpasien->Alamat->caption() ?><?php echo ($lokpasien->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Alamat->cellAttributes() ?>>
<span id="el_lokpasien_Alamat">
<textarea data-table="lokpasien" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="4"<?php echo $lokpasien->Alamat->editAttributes() ?>><?php echo $lokpasien->Alamat->EditValue ?></textarea>
</span>
<?php echo $lokpasien->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Id_Kelurahan" class="form-group row">
		<label id="elh_lokpasien_Id_Kelurahan" for="x_Id_Kelurahan" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Id_Kelurahan->caption() ?><?php echo ($lokpasien->Id_Kelurahan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Id_Kelurahan->cellAttributes() ?>>
<span id="el_lokpasien_Id_Kelurahan">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_Id_Kelurahan"><?php echo strval($lokpasien->Id_Kelurahan->ViewValue) == "" ? $Language->phrase("PleaseSelect") : (REMOVE_XSS ? HtmlDecode($lokpasien->Id_Kelurahan->ViewValue) : $lokpasien->Id_Kelurahan->ViewValue) ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($lokpasien->Id_Kelurahan->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($lokpasien->Id_Kelurahan->ReadOnly || $lokpasien->Id_Kelurahan->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x_Id_Kelurahan',m:0,n:5});"><i class="fa fa-search ew-icon"></i></button>
<?php if (AllowAdd(CurrentProjectID() . "lokkelurahan") && !$lokpasien->Id_Kelurahan->ReadOnly) { ?>
<button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Kelurahan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokpasien->Id_Kelurahan->caption() ?>" data-title="<?php echo $lokpasien->Id_Kelurahan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Kelurahan',url:'lokkelurahanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button>
<?php } ?>
	</div>
</div>
<?php echo $lokpasien->Id_Kelurahan->Lookup->getParamTag("p_x_Id_Kelurahan") ?>
<input type="hidden" data-table="lokpasien" data-field="x_Id_Kelurahan" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $lokpasien->Id_Kelurahan->displayValueSeparatorAttribute() ?>" name="x_Id_Kelurahan" id="x_Id_Kelurahan" value="<?php echo $lokpasien->Id_Kelurahan->CurrentValue ?>"<?php echo $lokpasien->Id_Kelurahan->editAttributes() ?>>
</span>
<?php echo $lokpasien->Id_Kelurahan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Kelurahan">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Id_Kelurahan"><?php echo $lokpasien->Id_Kelurahan->caption() ?><?php echo ($lokpasien->Id_Kelurahan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Id_Kelurahan->cellAttributes() ?>>
<span id="el_lokpasien_Id_Kelurahan">
<div class="input-group ew-lookup-list">
	<div class="form-control ew-lookup-text" tabindex="-1" id="lu_x_Id_Kelurahan"><?php echo strval($lokpasien->Id_Kelurahan->ViewValue) == "" ? $Language->phrase("PleaseSelect") : (REMOVE_XSS ? HtmlDecode($lokpasien->Id_Kelurahan->ViewValue) : $lokpasien->Id_Kelurahan->ViewValue) ?></div>
	<div class="input-group-append">
		<button type="button" title="<?php echo HtmlEncode(str_replace("%s", RemoveHtml($lokpasien->Id_Kelurahan->caption()), $Language->phrase("LookupLink", TRUE))) ?>" class="ew-lookup-btn btn btn-default"<?php echo (($lokpasien->Id_Kelurahan->ReadOnly || $lokpasien->Id_Kelurahan->Disabled) ? " disabled" : "")?> onclick="ew.modalLookupShow({lnk:this,el:'x_Id_Kelurahan',m:0,n:5});"><i class="fa fa-search ew-icon"></i></button>
<?php if (AllowAdd(CurrentProjectID() . "lokkelurahan") && !$lokpasien->Id_Kelurahan->ReadOnly) { ?>
<button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Kelurahan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokpasien->Id_Kelurahan->caption() ?>" data-title="<?php echo $lokpasien->Id_Kelurahan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Kelurahan',url:'lokkelurahanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button>
<?php } ?>
	</div>
</div>
<?php echo $lokpasien->Id_Kelurahan->Lookup->getParamTag("p_x_Id_Kelurahan") ?>
<input type="hidden" data-table="lokpasien" data-field="x_Id_Kelurahan" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $lokpasien->Id_Kelurahan->displayValueSeparatorAttribute() ?>" name="x_Id_Kelurahan" id="x_Id_Kelurahan" value="<?php echo $lokpasien->Id_Kelurahan->CurrentValue ?>"<?php echo $lokpasien->Id_Kelurahan->editAttributes() ?>>
</span>
<?php echo $lokpasien->Id_Kelurahan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpasien->Agama->Visible) { // Agama ?>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
	<div id="r_Agama" class="form-group row">
		<label id="elh_lokpasien_Agama" class="<?php echo $lokpasien_add->LeftColumnClass ?>"><?php echo $lokpasien->Agama->caption() ?><?php echo ($lokpasien->Agama->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpasien_add->RightColumnClass ?>"><div<?php echo $lokpasien->Agama->cellAttributes() ?>>
<span id="el_lokpasien_Agama">
<div id="tp_x_Agama" class="ew-template"><input type="radio" class="form-check-input" data-table="lokpasien" data-field="x_Agama" data-value-separator="<?php echo $lokpasien->Agama->displayValueSeparatorAttribute() ?>" name="x_Agama" id="x_Agama" value="{value}"<?php echo $lokpasien->Agama->editAttributes() ?>></div>
<div id="dsl_x_Agama" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $lokpasien->Agama->radioButtonListHtml(FALSE, "x_Agama") ?>
</div></div>
</span>
<?php echo $lokpasien->Agama->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Agama">
		<td class="<?php echo $lokpasien_add->TableLeftColumnClass ?>"><span id="elh_lokpasien_Agama"><?php echo $lokpasien->Agama->caption() ?><?php echo ($lokpasien->Agama->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpasien->Agama->cellAttributes() ?>>
<span id="el_lokpasien_Agama">
<div id="tp_x_Agama" class="ew-template"><input type="radio" class="form-check-input" data-table="lokpasien" data-field="x_Agama" data-value-separator="<?php echo $lokpasien->Agama->displayValueSeparatorAttribute() ?>" name="x_Agama" id="x_Agama" value="{value}"<?php echo $lokpasien->Agama->editAttributes() ?>></div>
<div id="dsl_x_Agama" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $lokpasien->Agama->radioButtonListHtml(FALSE, "x_Agama") ?>
</div></div>
</span>
<?php echo $lokpasien->Agama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
	<span id="el_lokpasien_Lama_Baru">
	<input type="hidden" data-table="lokpasien" data-field="x_Lama_Baru" name="x_Lama_Baru" id="x_Lama_Baru" value="<?php echo HtmlEncode($lokpasien->Lama_Baru->CurrentValue) ?>">
	</span>
<?php if ($lokpasien_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokpasien_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokpasien_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpasien_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokpasien_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokpasien_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

$(document).ready(function () {
	upperCase("Nama_Pasien");
});

function upperCase(cField) {
	$("#x_"+cField).keyup( function (e) {
		var str = $(this).val();
		$(this).val(str.toUpperCase());
	});
}
</script>
<?php include_once "footer.php" ?>
<?php
$lokpasien_add->terminate();
?>