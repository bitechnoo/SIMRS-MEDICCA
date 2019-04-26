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
$lokdaftar_edit = new lokdaftar_edit();

// Run the page
$lokdaftar_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokdaftar_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var flokdaftaredit = currentForm = new ew.Form("flokdaftaredit", "edit");

// Validate form
flokdaftaredit.validate = function() {
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
		<?php if ($lokdaftar_edit->Tgl_Daftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Tgl_Daftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Tgl_Daftar->caption(), $lokdaftar->Tgl_Daftar->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Tgl_Daftar");
			if (elm && !ew.checkEuroDate(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokdaftar->Tgl_Daftar->errorMessage()) ?>");
		<?php if ($lokdaftar_edit->Id_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Id_Pasien->caption(), $lokdaftar->Id_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Nama_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Nama_Pasien->caption(), $lokdaftar->Nama_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->No_RM->Required) { ?>
			elm = this.getElements("x" + infix + "_No_RM");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->No_RM->caption(), $lokdaftar->No_RM->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Tgl_Lahir->Required) { ?>
			elm = this.getElements("x" + infix + "_Tgl_Lahir");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Tgl_Lahir->caption(), $lokdaftar->Tgl_Lahir->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Tgl_Lahir");
			if (elm && !ew.checkEuroDate(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokdaftar->Tgl_Lahir->errorMessage()) ?>");
		<?php if ($lokdaftar_edit->Jenis_Kelamin->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Kelamin");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Jenis_Kelamin->caption(), $lokdaftar->Jenis_Kelamin->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Alamat->Required) { ?>
			elm = this.getElements("x" + infix + "_Alamat");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Alamat->caption(), $lokdaftar->Alamat->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Id_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Id_Poliklinik->caption(), $lokdaftar->Id_Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Poliklinik->caption(), $lokdaftar->Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Rawat->Required) { ?>
			elm = this.getElements("x" + infix + "_Rawat");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Rawat->caption(), $lokdaftar->Rawat->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Id_Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Id_Rujukan->caption(), $lokdaftar->Id_Rujukan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Id_JenisPasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_JenisPasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Id_JenisPasien->caption(), $lokdaftar->Id_JenisPasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Lama_Baru->Required) { ?>
			elm = this.getElements("x" + infix + "_Lama_Baru");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Lama_Baru->caption(), $lokdaftar->Lama_Baru->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Id_BiayaDaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_BiayaDaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Id_BiayaDaftar->caption(), $lokdaftar->Id_BiayaDaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Total_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Total_Biaya->caption(), $lokdaftar->Total_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Petugas->Required) { ?>
			elm = this.getElements("x" + infix + "_Petugas");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Petugas->caption(), $lokdaftar->Petugas->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokdaftar_edit->Status->Required) { ?>
			elm = this.getElements("x" + infix + "_Status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokdaftar->Status->caption(), $lokdaftar->Status->RequiredErrorMessage)) ?>");
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
flokdaftaredit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokdaftaredit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokdaftaredit.lists["x_Id_Poliklinik"] = <?php echo $lokdaftar_edit->Id_Poliklinik->Lookup->toClientList() ?>;
flokdaftaredit.lists["x_Id_Poliklinik"].options = <?php echo JsonEncode($lokdaftar_edit->Id_Poliklinik->lookupOptions()) ?>;
flokdaftaredit.lists["x_Id_Rujukan"] = <?php echo $lokdaftar_edit->Id_Rujukan->Lookup->toClientList() ?>;
flokdaftaredit.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($lokdaftar_edit->Id_Rujukan->lookupOptions()) ?>;
flokdaftaredit.lists["x_Id_JenisPasien"] = <?php echo $lokdaftar_edit->Id_JenisPasien->Lookup->toClientList() ?>;
flokdaftaredit.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($lokdaftar_edit->Id_JenisPasien->lookupOptions()) ?>;
flokdaftaredit.lists["x_Id_BiayaDaftar"] = <?php echo $lokdaftar_edit->Id_BiayaDaftar->Lookup->toClientList() ?>;
flokdaftaredit.lists["x_Id_BiayaDaftar"].options = <?php echo JsonEncode($lokdaftar_edit->Id_BiayaDaftar->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokdaftar_edit->showPageHeader(); ?>
<?php
$lokdaftar_edit->showMessage();
?>
<form name="flokdaftaredit" id="flokdaftaredit" class="<?php echo $lokdaftar_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokdaftar_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokdaftar_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokdaftar">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$lokdaftar_edit->IsModal ?>">
<?php if (!$lokdaftar_edit->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
<div class="ew-edit-div d-none"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokdaftaredit" class="table table-striped table-sm ew-desktop-table d-none"><!-- table* -->
<?php } ?>
<?php if ($lokdaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Tgl_Daftar" class="form-group row">
		<label id="elh_lokdaftar_Tgl_Daftar" for="x_Tgl_Daftar" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Tgl_Daftar" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Tgl_Daftar->caption() ?><?php echo ($lokdaftar->Tgl_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Tgl_Daftar->cellAttributes() ?>>
<script id="tpx_lokdaftar_Tgl_Daftar" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Tgl_Daftar">
<input type="text" data-table="lokdaftar" data-field="x_Tgl_Daftar" data-page="1" data-format="7" name="x_Tgl_Daftar" id="x_Tgl_Daftar" size="10" value="<?php echo $lokdaftar->Tgl_Daftar->EditValue ?>"<?php echo $lokdaftar->Tgl_Daftar->editAttributes() ?>>
<?php if (!$lokdaftar->Tgl_Daftar->ReadOnly && !$lokdaftar->Tgl_Daftar->Disabled && !isset($lokdaftar->Tgl_Daftar->EditAttrs["readonly"]) && !isset($lokdaftar->Tgl_Daftar->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="lokdaftaredit_js">
ew.createDateTimePicker("flokdaftaredit", "x_Tgl_Daftar", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $lokdaftar->Tgl_Daftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tgl_Daftar">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Tgl_Daftar"><script id="tpc_lokdaftar_Tgl_Daftar" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Tgl_Daftar->caption() ?><?php echo ($lokdaftar->Tgl_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Tgl_Daftar->cellAttributes() ?>>
<script id="tpx_lokdaftar_Tgl_Daftar" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Tgl_Daftar">
<input type="text" data-table="lokdaftar" data-field="x_Tgl_Daftar" data-page="1" data-format="7" name="x_Tgl_Daftar" id="x_Tgl_Daftar" size="10" value="<?php echo $lokdaftar->Tgl_Daftar->EditValue ?>"<?php echo $lokdaftar->Tgl_Daftar->editAttributes() ?>>
<?php if (!$lokdaftar->Tgl_Daftar->ReadOnly && !$lokdaftar->Tgl_Daftar->Disabled && !isset($lokdaftar->Tgl_Daftar->EditAttrs["readonly"]) && !isset($lokdaftar->Tgl_Daftar->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="lokdaftaredit_js">
ew.createDateTimePicker("flokdaftaredit", "x_Tgl_Daftar", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $lokdaftar->Tgl_Daftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_Pasien->Visible) { // Id_Pasien ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Id_Pasien" class="form-group row">
		<label id="elh_lokdaftar_Id_Pasien" for="x_Id_Pasien" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Id_Pasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Pasien->caption() ?><?php echo ($lokdaftar->Id_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Id_Pasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Pasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Pasien">
<input type="text" data-table="lokdaftar" data-field="x_Id_Pasien" data-page="1" name="x_Id_Pasien" id="x_Id_Pasien" size="10" value="<?php echo $lokdaftar->Id_Pasien->EditValue ?>"<?php echo $lokdaftar->Id_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Id_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Pasien">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Id_Pasien"><script id="tpc_lokdaftar_Id_Pasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Pasien->caption() ?><?php echo ($lokdaftar->Id_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Id_Pasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Pasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Pasien">
<input type="text" data-table="lokdaftar" data-field="x_Id_Pasien" data-page="1" name="x_Id_Pasien" id="x_Id_Pasien" size="10" value="<?php echo $lokdaftar->Id_Pasien->EditValue ?>"<?php echo $lokdaftar->Id_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Id_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Nama_Pasien" class="form-group row">
		<label id="elh_lokdaftar_Nama_Pasien" for="x_Nama_Pasien" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Nama_Pasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Nama_Pasien->caption() ?><?php echo ($lokdaftar->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Nama_Pasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Nama_Pasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Nama_Pasien">
<input type="text" data-table="lokdaftar" data-field="x_Nama_Pasien" data-page="1" name="x_Nama_Pasien" id="x_Nama_Pasien" size="22" maxlength="50" value="<?php echo $lokdaftar->Nama_Pasien->EditValue ?>"<?php echo $lokdaftar->Nama_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Nama_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Pasien">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Nama_Pasien"><script id="tpc_lokdaftar_Nama_Pasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Nama_Pasien->caption() ?><?php echo ($lokdaftar->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Nama_Pasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Nama_Pasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Nama_Pasien">
<input type="text" data-table="lokdaftar" data-field="x_Nama_Pasien" data-page="1" name="x_Nama_Pasien" id="x_Nama_Pasien" size="22" maxlength="50" value="<?php echo $lokdaftar->Nama_Pasien->EditValue ?>"<?php echo $lokdaftar->Nama_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Nama_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->No_RM->Visible) { // No_RM ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_No_RM" class="form-group row">
		<label id="elh_lokdaftar_No_RM" for="x_No_RM" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_No_RM" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->No_RM->caption() ?><?php echo ($lokdaftar->No_RM->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->No_RM->cellAttributes() ?>>
<script id="tpx_lokdaftar_No_RM" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_No_RM">
<input type="text" data-table="lokdaftar" data-field="x_No_RM" data-page="1" name="x_No_RM" id="x_No_RM" size="15" maxlength="50" value="<?php echo $lokdaftar->No_RM->EditValue ?>"<?php echo $lokdaftar->No_RM->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->No_RM->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_No_RM">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_No_RM"><script id="tpc_lokdaftar_No_RM" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->No_RM->caption() ?><?php echo ($lokdaftar->No_RM->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->No_RM->cellAttributes() ?>>
<script id="tpx_lokdaftar_No_RM" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_No_RM">
<input type="text" data-table="lokdaftar" data-field="x_No_RM" data-page="1" name="x_No_RM" id="x_No_RM" size="15" maxlength="50" value="<?php echo $lokdaftar->No_RM->EditValue ?>"<?php echo $lokdaftar->No_RM->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->No_RM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Tgl_Lahir" class="form-group row">
		<label id="elh_lokdaftar_Tgl_Lahir" for="x_Tgl_Lahir" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Tgl_Lahir" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Tgl_Lahir->caption() ?><?php echo ($lokdaftar->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Tgl_Lahir->cellAttributes() ?>>
<script id="tpx_lokdaftar_Tgl_Lahir" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Tgl_Lahir">
<input type="text" data-table="lokdaftar" data-field="x_Tgl_Lahir" data-page="1" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="15" value="<?php echo $lokdaftar->Tgl_Lahir->EditValue ?>"<?php echo $lokdaftar->Tgl_Lahir->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Tgl_Lahir->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tgl_Lahir">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Tgl_Lahir"><script id="tpc_lokdaftar_Tgl_Lahir" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Tgl_Lahir->caption() ?><?php echo ($lokdaftar->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Tgl_Lahir->cellAttributes() ?>>
<script id="tpx_lokdaftar_Tgl_Lahir" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Tgl_Lahir">
<input type="text" data-table="lokdaftar" data-field="x_Tgl_Lahir" data-page="1" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="15" value="<?php echo $lokdaftar->Tgl_Lahir->EditValue ?>"<?php echo $lokdaftar->Tgl_Lahir->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Tgl_Lahir->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Jenis_Kelamin" class="form-group row">
		<label id="elh_lokdaftar_Jenis_Kelamin" for="x_Jenis_Kelamin" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Jenis_Kelamin" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Jenis_Kelamin->caption() ?><?php echo ($lokdaftar->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Jenis_Kelamin->cellAttributes() ?>>
<script id="tpx_lokdaftar_Jenis_Kelamin" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Jenis_Kelamin">
<input type="text" data-table="lokdaftar" data-field="x_Jenis_Kelamin" data-page="1" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" size="15" maxlength="50" value="<?php echo $lokdaftar->Jenis_Kelamin->EditValue ?>"<?php echo $lokdaftar->Jenis_Kelamin->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Jenis_Kelamin->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Kelamin">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Jenis_Kelamin"><script id="tpc_lokdaftar_Jenis_Kelamin" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Jenis_Kelamin->caption() ?><?php echo ($lokdaftar->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Jenis_Kelamin->cellAttributes() ?>>
<script id="tpx_lokdaftar_Jenis_Kelamin" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Jenis_Kelamin">
<input type="text" data-table="lokdaftar" data-field="x_Jenis_Kelamin" data-page="1" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" size="15" maxlength="50" value="<?php echo $lokdaftar->Jenis_Kelamin->EditValue ?>"<?php echo $lokdaftar->Jenis_Kelamin->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Jenis_Kelamin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Alamat->Visible) { // Alamat ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Alamat" class="form-group row">
		<label id="elh_lokdaftar_Alamat" for="x_Alamat" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Alamat" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Alamat->caption() ?><?php echo ($lokdaftar->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Alamat->cellAttributes() ?>>
<script id="tpx_lokdaftar_Alamat" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Alamat">
<textarea data-table="lokdaftar" data-field="x_Alamat" data-page="1" name="x_Alamat" id="x_Alamat" cols="35" rows="3"<?php echo $lokdaftar->Alamat->editAttributes() ?>><?php echo $lokdaftar->Alamat->EditValue ?></textarea>
</span>
</script>
<?php echo $lokdaftar->Alamat->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Alamat">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Alamat"><script id="tpc_lokdaftar_Alamat" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Alamat->caption() ?><?php echo ($lokdaftar->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Alamat->cellAttributes() ?>>
<script id="tpx_lokdaftar_Alamat" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Alamat">
<textarea data-table="lokdaftar" data-field="x_Alamat" data-page="1" name="x_Alamat" id="x_Alamat" cols="35" rows="3"<?php echo $lokdaftar->Alamat->editAttributes() ?>><?php echo $lokdaftar->Alamat->EditValue ?></textarea>
</span>
</script>
<?php echo $lokdaftar->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Id_Poliklinik" class="form-group row">
		<label id="elh_lokdaftar_Id_Poliklinik" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Id_Poliklinik" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Poliklinik->caption() ?><?php echo ($lokdaftar->Id_Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Id_Poliklinik->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Poliklinik" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Poliklinik">
<div id="tp_x_Id_Poliklinik" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_Poliklinik" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_Poliklinik->displayValueSeparatorAttribute() ?>" name="x_Id_Poliklinik" id="x_Id_Poliklinik" value="{value}"<?php echo $lokdaftar->Id_Poliklinik->editAttributes() ?>></div>
<div id="dsl_x_Id_Poliklinik" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_Poliklinik->radioButtonListHtml(FALSE, "x_Id_Poliklinik", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_Poliklinik->Lookup->getParamTag("p_x_Id_Poliklinik") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokpoliklinik") && !$lokdaftar->Id_Poliklinik->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Poliklinik" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_Poliklinik->caption() ?>" data-title="<?php echo $lokdaftar->Id_Poliklinik->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Poliklinik',url:'lokpoliklinikaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_Poliklinik->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Poliklinik">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Id_Poliklinik"><script id="tpc_lokdaftar_Id_Poliklinik" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Poliklinik->caption() ?><?php echo ($lokdaftar->Id_Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Id_Poliklinik->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Poliklinik" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Poliklinik">
<div id="tp_x_Id_Poliklinik" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_Poliklinik" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_Poliklinik->displayValueSeparatorAttribute() ?>" name="x_Id_Poliklinik" id="x_Id_Poliklinik" value="{value}"<?php echo $lokdaftar->Id_Poliklinik->editAttributes() ?>></div>
<div id="dsl_x_Id_Poliklinik" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_Poliklinik->radioButtonListHtml(FALSE, "x_Id_Poliklinik", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_Poliklinik->Lookup->getParamTag("p_x_Id_Poliklinik") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokpoliklinik") && !$lokdaftar->Id_Poliklinik->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Poliklinik" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_Poliklinik->caption() ?>" data-title="<?php echo $lokdaftar->Id_Poliklinik->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Poliklinik',url:'lokpoliklinikaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_Poliklinik->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Poliklinik->Visible) { // Poliklinik ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Poliklinik" class="form-group row">
		<label id="elh_lokdaftar_Poliklinik" for="x_Poliklinik" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Poliklinik" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Poliklinik->caption() ?><?php echo ($lokdaftar->Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Poliklinik->cellAttributes() ?>>
<script id="tpx_lokdaftar_Poliklinik" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Poliklinik">
<input type="text" data-table="lokdaftar" data-field="x_Poliklinik" data-page="1" name="x_Poliklinik" id="x_Poliklinik" size="30" maxlength="50" value="<?php echo $lokdaftar->Poliklinik->EditValue ?>"<?php echo $lokdaftar->Poliklinik->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Poliklinik->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Poliklinik">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Poliklinik"><script id="tpc_lokdaftar_Poliklinik" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Poliklinik->caption() ?><?php echo ($lokdaftar->Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Poliklinik->cellAttributes() ?>>
<script id="tpx_lokdaftar_Poliklinik" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Poliklinik">
<input type="text" data-table="lokdaftar" data-field="x_Poliklinik" data-page="1" name="x_Poliklinik" id="x_Poliklinik" size="30" maxlength="50" value="<?php echo $lokdaftar->Poliklinik->EditValue ?>"<?php echo $lokdaftar->Poliklinik->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Poliklinik->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Id_Rujukan" class="form-group row">
		<label id="elh_lokdaftar_Id_Rujukan" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Id_Rujukan" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Rujukan->caption() ?><?php echo ($lokdaftar->Id_Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Id_Rujukan->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Rujukan" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Rujukan">
<div id="tp_x_Id_Rujukan" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_Rujukan" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_Rujukan->displayValueSeparatorAttribute() ?>" name="x_Id_Rujukan" id="x_Id_Rujukan" value="{value}"<?php echo $lokdaftar->Id_Rujukan->editAttributes() ?>></div>
<div id="dsl_x_Id_Rujukan" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_Rujukan->radioButtonListHtml(FALSE, "x_Id_Rujukan", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_Rujukan->Lookup->getParamTag("p_x_Id_Rujukan") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokasalrujukan") && !$lokdaftar->Id_Rujukan->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Rujukan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_Rujukan->caption() ?>" data-title="<?php echo $lokdaftar->Id_Rujukan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Rujukan',url:'lokasalrujukanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_Rujukan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Rujukan">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Id_Rujukan"><script id="tpc_lokdaftar_Id_Rujukan" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_Rujukan->caption() ?><?php echo ($lokdaftar->Id_Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Id_Rujukan->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_Rujukan" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_Rujukan">
<div id="tp_x_Id_Rujukan" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_Rujukan" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_Rujukan->displayValueSeparatorAttribute() ?>" name="x_Id_Rujukan" id="x_Id_Rujukan" value="{value}"<?php echo $lokdaftar->Id_Rujukan->editAttributes() ?>></div>
<div id="dsl_x_Id_Rujukan" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_Rujukan->radioButtonListHtml(FALSE, "x_Id_Rujukan", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_Rujukan->Lookup->getParamTag("p_x_Id_Rujukan") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokasalrujukan") && !$lokdaftar->Id_Rujukan->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Rujukan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_Rujukan->caption() ?>" data-title="<?php echo $lokdaftar->Id_Rujukan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Rujukan',url:'lokasalrujukanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_Rujukan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Id_JenisPasien" class="form-group row">
		<label id="elh_lokdaftar_Id_JenisPasien" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Id_JenisPasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_JenisPasien->caption() ?><?php echo ($lokdaftar->Id_JenisPasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Id_JenisPasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_JenisPasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_JenisPasien">
<div id="tp_x_Id_JenisPasien" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_JenisPasien" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_JenisPasien->displayValueSeparatorAttribute() ?>" name="x_Id_JenisPasien" id="x_Id_JenisPasien" value="{value}"<?php echo $lokdaftar->Id_JenisPasien->editAttributes() ?>></div>
<div id="dsl_x_Id_JenisPasien" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_JenisPasien->radioButtonListHtml(FALSE, "x_Id_JenisPasien", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_JenisPasien->Lookup->getParamTag("p_x_Id_JenisPasien") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokjenispasien") && !$lokdaftar->Id_JenisPasien->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_JenisPasien" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_JenisPasien->caption() ?>" data-title="<?php echo $lokdaftar->Id_JenisPasien->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_JenisPasien',url:'lokjenispasienaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_JenisPasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_JenisPasien">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Id_JenisPasien"><script id="tpc_lokdaftar_Id_JenisPasien" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_JenisPasien->caption() ?><?php echo ($lokdaftar->Id_JenisPasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Id_JenisPasien->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_JenisPasien" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_JenisPasien">
<div id="tp_x_Id_JenisPasien" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_JenisPasien" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_JenisPasien->displayValueSeparatorAttribute() ?>" name="x_Id_JenisPasien" id="x_Id_JenisPasien" value="{value}"<?php echo $lokdaftar->Id_JenisPasien->editAttributes() ?>></div>
<div id="dsl_x_Id_JenisPasien" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_JenisPasien->radioButtonListHtml(FALSE, "x_Id_JenisPasien", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_JenisPasien->Lookup->getParamTag("p_x_Id_JenisPasien") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokjenispasien") && !$lokdaftar->Id_JenisPasien->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_JenisPasien" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_JenisPasien->caption() ?>" data-title="<?php echo $lokdaftar->Id_JenisPasien->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_JenisPasien',url:'lokjenispasienaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_JenisPasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Lama_Baru->Visible) { // Lama_Baru ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Lama_Baru" class="form-group row">
		<label id="elh_lokdaftar_Lama_Baru" for="x_Lama_Baru" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Lama_Baru" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Lama_Baru->caption() ?><?php echo ($lokdaftar->Lama_Baru->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Lama_Baru->cellAttributes() ?>>
<script id="tpx_lokdaftar_Lama_Baru" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Lama_Baru">
<input type="text" data-table="lokdaftar" data-field="x_Lama_Baru" data-page="1" name="x_Lama_Baru" id="x_Lama_Baru" size="15" value="<?php echo $lokdaftar->Lama_Baru->EditValue ?>"<?php echo $lokdaftar->Lama_Baru->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Lama_Baru->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Lama_Baru">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Lama_Baru"><script id="tpc_lokdaftar_Lama_Baru" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Lama_Baru->caption() ?><?php echo ($lokdaftar->Lama_Baru->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Lama_Baru->cellAttributes() ?>>
<script id="tpx_lokdaftar_Lama_Baru" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Lama_Baru">
<input type="text" data-table="lokdaftar" data-field="x_Lama_Baru" data-page="1" name="x_Lama_Baru" id="x_Lama_Baru" size="15" value="<?php echo $lokdaftar->Lama_Baru->EditValue ?>"<?php echo $lokdaftar->Lama_Baru->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Lama_Baru->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Id_BiayaDaftar" class="form-group row">
		<label id="elh_lokdaftar_Id_BiayaDaftar" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Id_BiayaDaftar" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_BiayaDaftar->caption() ?><?php echo ($lokdaftar->Id_BiayaDaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Id_BiayaDaftar->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_BiayaDaftar" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_BiayaDaftar">
<?php $lokdaftar->Id_BiayaDaftar->EditAttrs["onclick"] = "ew.autoFill(this); " . @$lokdaftar->Id_BiayaDaftar->EditAttrs["onclick"]; ?>
<div id="tp_x_Id_BiayaDaftar" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_BiayaDaftar" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_BiayaDaftar->displayValueSeparatorAttribute() ?>" name="x_Id_BiayaDaftar" id="x_Id_BiayaDaftar" value="{value}"<?php echo $lokdaftar->Id_BiayaDaftar->editAttributes() ?>></div>
<div id="dsl_x_Id_BiayaDaftar" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_BiayaDaftar->radioButtonListHtml(FALSE, "x_Id_BiayaDaftar", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_BiayaDaftar->Lookup->getParamTag("p_x_Id_BiayaDaftar") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokbiayadaftar") && !$lokdaftar->Id_BiayaDaftar->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_BiayaDaftar" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_BiayaDaftar->caption() ?>" data-title="<?php echo $lokdaftar->Id_BiayaDaftar->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_BiayaDaftar',url:'lokbiayadaftaraddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_BiayaDaftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_BiayaDaftar">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Id_BiayaDaftar"><script id="tpc_lokdaftar_Id_BiayaDaftar" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Id_BiayaDaftar->caption() ?><?php echo ($lokdaftar->Id_BiayaDaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Id_BiayaDaftar->cellAttributes() ?>>
<script id="tpx_lokdaftar_Id_BiayaDaftar" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Id_BiayaDaftar">
<?php $lokdaftar->Id_BiayaDaftar->EditAttrs["onclick"] = "ew.autoFill(this); " . @$lokdaftar->Id_BiayaDaftar->EditAttrs["onclick"]; ?>
<div id="tp_x_Id_BiayaDaftar" class="ew-template"><input type="radio" class="form-check-input" data-table="lokdaftar" data-field="x_Id_BiayaDaftar" data-page="1" data-value-separator="<?php echo $lokdaftar->Id_BiayaDaftar->displayValueSeparatorAttribute() ?>" name="x_Id_BiayaDaftar" id="x_Id_BiayaDaftar" value="{value}"<?php echo $lokdaftar->Id_BiayaDaftar->editAttributes() ?>></div>
<div id="dsl_x_Id_BiayaDaftar" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $lokdaftar->Id_BiayaDaftar->radioButtonListHtml(FALSE, "x_Id_BiayaDaftar", 1) ?>
</div></div>
<?php echo $lokdaftar->Id_BiayaDaftar->Lookup->getParamTag("p_x_Id_BiayaDaftar") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokbiayadaftar") && !$lokdaftar->Id_BiayaDaftar->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_BiayaDaftar" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $lokdaftar->Id_BiayaDaftar->caption() ?>" data-title="<?php echo $lokdaftar->Id_BiayaDaftar->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_BiayaDaftar',url:'lokbiayadaftaraddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $lokdaftar->Id_BiayaDaftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Total_Biaya->Visible) { // Total_Biaya ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
	<div id="r_Total_Biaya" class="form-group row">
		<label id="elh_lokdaftar_Total_Biaya" for="x_Total_Biaya" class="<?php echo $lokdaftar_edit->LeftColumnClass ?>"><script id="tpc_lokdaftar_Total_Biaya" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Total_Biaya->caption() ?><?php echo ($lokdaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $lokdaftar_edit->RightColumnClass ?>"><div<?php echo $lokdaftar->Total_Biaya->cellAttributes() ?>>
<script id="tpx_lokdaftar_Total_Biaya" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Total_Biaya">
<input type="text" data-table="lokdaftar" data-field="x_Total_Biaya" data-page="1" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $lokdaftar->Total_Biaya->EditValue ?>"<?php echo $lokdaftar->Total_Biaya->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Total_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Total_Biaya">
		<td class="<?php echo $lokdaftar_edit->TableLeftColumnClass ?>"><span id="elh_lokdaftar_Total_Biaya"><script id="tpc_lokdaftar_Total_Biaya" class="lokdaftaredit" type="text/html"><span><?php echo $lokdaftar->Total_Biaya->caption() ?><?php echo ($lokdaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $lokdaftar->Total_Biaya->cellAttributes() ?>>
<script id="tpx_lokdaftar_Total_Biaya" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Total_Biaya">
<input type="text" data-table="lokdaftar" data-field="x_Total_Biaya" data-page="1" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $lokdaftar->Total_Biaya->EditValue ?>"<?php echo $lokdaftar->Total_Biaya->editAttributes() ?>>
</span>
</script>
<?php echo $lokdaftar->Total_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokdaftar_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<script id="tpx_lokdaftar_Rawat" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Rawat">
<input type="hidden" data-table="lokdaftar" data-field="x_Rawat" data-page="1" name="x_Rawat" id="x_Rawat" value="<?php echo HtmlEncode($lokdaftar->Rawat->CurrentValue) ?>">
</span>
</script>
<script id="tpx_lokdaftar_Petugas" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Petugas">
<input type="hidden" data-table="lokdaftar" data-field="x_Petugas" data-page="1" name="x_Petugas" id="x_Petugas" value="<?php echo HtmlEncode($lokdaftar->Petugas->CurrentValue) ?>">
</span>
</script>
<script id="tpx_lokdaftar_Status" class="lokdaftaredit" type="text/html">
<span id="el_lokdaftar_Status">
<input type="hidden" data-table="lokdaftar" data-field="x_Status" data-page="1" name="x_Status" id="x_Status" value="<?php echo HtmlEncode($lokdaftar->Status->CurrentValue) ?>">
</span>
</script>
	<input type="hidden" data-table="lokdaftar" data-field="x_Id_Daftar" name="x_Id_Daftar" id="x_Id_Daftar" value="<?php echo HtmlEncode($lokdaftar->Id_Daftar->CurrentValue) ?>">
<div id="tpd_lokdaftaredit" class="ew-custom-template"></div>
<script id="tpm_lokdaftaredit" type="text/html">
<div id="ct_lokdaftar_edit"><div class="container-fluid">
	<div class="row">
		<div class="col-3">
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Tgl_Daftar->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Tgl_Daftar"/}} {{include tmpl="#tpx_lokdaftar_Status"/}}</div>
			<div>{{include tmpl="#tpx_lokdaftar_Id_Pasien"/}} {{include tmpl="#tpx_lokdaftar_Petugas"/}} {{include tmpl="#tpx_lokdaftar_Waktu"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->No_RM->caption() ?></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_No_RM"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Nama_Pasien->caption() ?></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Nama_Pasien"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Tgl_Lahir->caption() ?></label></div>			
			<div>{{include tmpl="#tpx_lokdaftar_Tgl_Lahir"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Jenis_Kelamin->caption() ?></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Jenis_Kelamin"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Alamat->caption() ?></label></div>			
			<div>{{include tmpl="#tpx_lokdaftar_Alamat"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Lama_Baru->caption() ?></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Lama_Baru"/}}</div>
		</div>
		<div class="col-4">
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Id_Rujukan->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Id_Rujukan"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Id_JenisPasien->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Id_JenisPasien"/}}</div>
		</div>
		<div class="col-2">
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Id_Poliklinik->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Id_Poliklinik"/}}</div>
		</div>
		<div class="col-3">
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Id_BiayaDaftar->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Id_BiayaDaftar"/}}</div> 		
			<div><label class="control-label ewLabel"><?php echo $lokdaftar->Total_Biaya->caption() ?></label></div>
			<div>{{include tmpl="#tpx_lokdaftar_Total_Biaya"/}} {{include tmpl="#tpx_lokdaftar_Rawat"/}}</div>		
		</div>
	</div>
</div> 
</div>
</script>
<?php if (!$lokdaftar_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokdaftar_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokdaftar_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokdaftar_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script>
ew.vars.templateData = { rows: <?php echo JsonEncode($lokdaftar->Rows) ?> };
ew.applyTemplate("tpd_lokdaftaredit", "tpm_lokdaftaredit", "lokdaftaredit", "<?php echo $lokdaftar->CustomExport ?>", ew.vars.templateData.rows[0]);
jQuery("script.lokdaftaredit_js").each(function(){ew.addScript(this.text);});
</script>
<?php
$lokdaftar_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

$(document).ready(function() {
	$("#x_Id_Pasien").hide(); //menghilangkan textbox id_pasien
	$("div.ewDesktop").addClass("col-sm-offset-6 col-sm-6"); // justify button simpan
	$("#x_Waktu").hide(); //menghilangkan textbox waktu
});
$('input[name=x_Id_Rujukan]:radio').click(function(){ //setting nilai jenis pasien
	if ($(this).prop("value")=="{290320191250308A243FA9DF67A28BD1C5722022B148EE}"){
		$('input[name="x_Id_JenisPasien"][value="{290320191250308A243FA9DF67A28BD1C5722022B148EE}"]').prop("checked","true");
	} 
});
</script>
<?php include_once "footer.php" ?>
<?php
$lokdaftar_edit->terminate();
?>