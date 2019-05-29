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
$ugddaftar_add = new ugddaftar_add();

// Run the page
$ugddaftar_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugddaftar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fugddaftaradd = currentForm = new ew.Form("fugddaftaradd", "add");

// Validate form
fugddaftaradd.validate = function() {
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
		<?php if ($ugddaftar_add->Id_Daftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Daftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_Daftar->caption(), $ugddaftar->Id_Daftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Tgl_Daftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Tgl_Daftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Tgl_Daftar->caption(), $ugddaftar->Tgl_Daftar->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Tgl_Daftar");
			if (elm && !ew.checkEuroDate(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugddaftar->Tgl_Daftar->errorMessage()) ?>");
		<?php if ($ugddaftar_add->Waktu->Required) { ?>
			elm = this.getElements("x" + infix + "_Waktu");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Waktu->caption(), $ugddaftar->Waktu->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Waktu");
			if (elm && !ew.checkTime(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugddaftar->Waktu->errorMessage()) ?>");
		<?php if ($ugddaftar_add->Id_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_Pasien->caption(), $ugddaftar->Id_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Id_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_Poliklinik->caption(), $ugddaftar->Id_Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Id_Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_Rujukan->caption(), $ugddaftar->Id_Rujukan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Id_JenisPasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_JenisPasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_JenisPasien->caption(), $ugddaftar->Id_JenisPasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Lama_Baru->Required) { ?>
			elm = this.getElements("x" + infix + "_Lama_Baru");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Lama_Baru->caption(), $ugddaftar->Lama_Baru->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Id_BiayaDaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_BiayaDaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Id_BiayaDaftar->caption(), $ugddaftar->Id_BiayaDaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Total_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Total_Biaya->caption(), $ugddaftar->Total_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugddaftar->Total_Biaya->errorMessage()) ?>");
		<?php if ($ugddaftar_add->Rawat->Required) { ?>
			elm = this.getElements("x" + infix + "_Rawat");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Rawat->caption(), $ugddaftar->Rawat->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Status->Required) { ?>
			elm = this.getElements("x" + infix + "_Status");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Status->caption(), $ugddaftar->Status->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Petugas->Required) { ?>
			elm = this.getElements("x" + infix + "_Petugas");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Petugas->caption(), $ugddaftar->Petugas->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->No_RM->Required) { ?>
			elm = this.getElements("x" + infix + "_No_RM");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->No_RM->caption(), $ugddaftar->No_RM->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Nama_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Nama_Pasien->caption(), $ugddaftar->Nama_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Tgl_Lahir->Required) { ?>
			elm = this.getElements("x" + infix + "_Tgl_Lahir");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Tgl_Lahir->caption(), $ugddaftar->Tgl_Lahir->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Jenis_Kelamin->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Kelamin");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Jenis_Kelamin->caption(), $ugddaftar->Jenis_Kelamin->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugddaftar_add->Alamat->Required) { ?>
			elm = this.getElements("x" + infix + "_Alamat");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugddaftar->Alamat->caption(), $ugddaftar->Alamat->RequiredErrorMessage)) ?>");
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
fugddaftaradd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugddaftaradd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fugddaftaradd.lists["x_Id_Rujukan"] = <?php echo $ugddaftar_add->Id_Rujukan->Lookup->toClientList() ?>;
fugddaftaradd.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($ugddaftar_add->Id_Rujukan->lookupOptions()) ?>;
fugddaftaradd.lists["x_Id_JenisPasien"] = <?php echo $ugddaftar_add->Id_JenisPasien->Lookup->toClientList() ?>;
fugddaftaradd.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($ugddaftar_add->Id_JenisPasien->lookupOptions()) ?>;
fugddaftaradd.lists["x_Id_BiayaDaftar"] = <?php echo $ugddaftar_add->Id_BiayaDaftar->Lookup->toClientList() ?>;
fugddaftaradd.lists["x_Id_BiayaDaftar"].options = <?php echo JsonEncode($ugddaftar_add->Id_BiayaDaftar->lookupOptions()) ?>;
fugddaftaradd.lists["x_Rawat"] = <?php echo $ugddaftar_add->Rawat->Lookup->toClientList() ?>;
fugddaftaradd.lists["x_Rawat"].options = <?php echo JsonEncode($ugddaftar_add->Rawat->options(FALSE, TRUE)) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugddaftar_add->showPageHeader(); ?>
<?php
$ugddaftar_add->showMessage();
?>
<form name="fugddaftaradd" id="fugddaftaradd" class="<?php echo $ugddaftar_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugddaftar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugddaftar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugddaftar">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$ugddaftar_add->IsModal ?>">
<?php if (!$ugddaftar_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
<div class="ew-add-div d-none"><!-- page* -->
<?php } else { ?>
<table id="tbl_ugddaftaradd" class="table table-striped table-sm ew-desktop-table d-none"><!-- table* -->
<?php } ?>
<?php if ($ugddaftar->Id_Daftar->Visible) { // Id_Daftar ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_Daftar" class="form-group row">
		<label id="elh_ugddaftar_Id_Daftar" for="x_Id_Daftar" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Id_Daftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Daftar->caption() ?><?php echo ($ugddaftar->Id_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Id_Daftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Daftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Daftar">
<input type="text" data-table="ugddaftar" data-field="x_Id_Daftar" name="x_Id_Daftar" id="x_Id_Daftar" size="30" maxlength="50" value="<?php echo $ugddaftar->Id_Daftar->EditValue ?>"<?php echo $ugddaftar->Id_Daftar->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Id_Daftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Daftar">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Id_Daftar"><script id="tpc_ugddaftar_Id_Daftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Daftar->caption() ?><?php echo ($ugddaftar->Id_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Id_Daftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Daftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Daftar">
<input type="text" data-table="ugddaftar" data-field="x_Id_Daftar" name="x_Id_Daftar" id="x_Id_Daftar" size="30" maxlength="50" value="<?php echo $ugddaftar->Id_Daftar->EditValue ?>"<?php echo $ugddaftar->Id_Daftar->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Id_Daftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Tgl_Daftar" class="form-group row">
		<label id="elh_ugddaftar_Tgl_Daftar" for="x_Tgl_Daftar" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Tgl_Daftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Tgl_Daftar->caption() ?><?php echo ($ugddaftar->Tgl_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Tgl_Daftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Tgl_Daftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Tgl_Daftar">
<input type="text" data-table="ugddaftar" data-field="x_Tgl_Daftar" data-format="7" name="x_Tgl_Daftar" id="x_Tgl_Daftar" size="10" value="<?php echo $ugddaftar->Tgl_Daftar->EditValue ?>"<?php echo $ugddaftar->Tgl_Daftar->editAttributes() ?>>
<?php if (!$ugddaftar->Tgl_Daftar->ReadOnly && !$ugddaftar->Tgl_Daftar->Disabled && !isset($ugddaftar->Tgl_Daftar->EditAttrs["readonly"]) && !isset($ugddaftar->Tgl_Daftar->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="ugddaftaradd_js">
ew.createDateTimePicker("fugddaftaradd", "x_Tgl_Daftar", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $ugddaftar->Tgl_Daftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tgl_Daftar">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Tgl_Daftar"><script id="tpc_ugddaftar_Tgl_Daftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Tgl_Daftar->caption() ?><?php echo ($ugddaftar->Tgl_Daftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Tgl_Daftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Tgl_Daftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Tgl_Daftar">
<input type="text" data-table="ugddaftar" data-field="x_Tgl_Daftar" data-format="7" name="x_Tgl_Daftar" id="x_Tgl_Daftar" size="10" value="<?php echo $ugddaftar->Tgl_Daftar->EditValue ?>"<?php echo $ugddaftar->Tgl_Daftar->editAttributes() ?>>
<?php if (!$ugddaftar->Tgl_Daftar->ReadOnly && !$ugddaftar->Tgl_Daftar->Disabled && !isset($ugddaftar->Tgl_Daftar->EditAttrs["readonly"]) && !isset($ugddaftar->Tgl_Daftar->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="ugddaftaradd_js">
ew.createDateTimePicker("fugddaftaradd", "x_Tgl_Daftar", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $ugddaftar->Tgl_Daftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Waktu->Visible) { // Waktu ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Waktu" class="form-group row">
		<label id="elh_ugddaftar_Waktu" for="x_Waktu" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Waktu" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Waktu->caption() ?><?php echo ($ugddaftar->Waktu->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Waktu->cellAttributes() ?>>
<script id="tpx_ugddaftar_Waktu" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Waktu">
<input type="text" data-table="ugddaftar" data-field="x_Waktu" name="x_Waktu" id="x_Waktu" value="<?php echo $ugddaftar->Waktu->EditValue ?>"<?php echo $ugddaftar->Waktu->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Waktu->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Waktu">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Waktu"><script id="tpc_ugddaftar_Waktu" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Waktu->caption() ?><?php echo ($ugddaftar->Waktu->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Waktu->cellAttributes() ?>>
<script id="tpx_ugddaftar_Waktu" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Waktu">
<input type="text" data-table="ugddaftar" data-field="x_Waktu" name="x_Waktu" id="x_Waktu" value="<?php echo $ugddaftar->Waktu->EditValue ?>"<?php echo $ugddaftar->Waktu->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Waktu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_Pasien->Visible) { // Id_Pasien ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_Pasien" class="form-group row">
		<label id="elh_ugddaftar_Id_Pasien" for="x_Id_Pasien" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Id_Pasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Pasien->caption() ?><?php echo ($ugddaftar->Id_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Id_Pasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Pasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Pasien">
<input type="text" data-table="ugddaftar" data-field="x_Id_Pasien" name="x_Id_Pasien" id="x_Id_Pasien" size="30" maxlength="50" value="<?php echo $ugddaftar->Id_Pasien->EditValue ?>"<?php echo $ugddaftar->Id_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Id_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Pasien">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Id_Pasien"><script id="tpc_ugddaftar_Id_Pasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Pasien->caption() ?><?php echo ($ugddaftar->Id_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Id_Pasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Pasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Pasien">
<input type="text" data-table="ugddaftar" data-field="x_Id_Pasien" name="x_Id_Pasien" id="x_Id_Pasien" size="30" maxlength="50" value="<?php echo $ugddaftar->Id_Pasien->EditValue ?>"<?php echo $ugddaftar->Id_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Id_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
	<script id="tpx_ugddaftar_Id_Poliklinik" class="ugddaftaradd" type="text/html">
	<span id="el_ugddaftar_Id_Poliklinik">
	<input type="hidden" data-table="ugddaftar" data-field="x_Id_Poliklinik" name="x_Id_Poliklinik" id="x_Id_Poliklinik" value="<?php echo HtmlEncode($ugddaftar->Id_Poliklinik->CurrentValue) ?>">
	</span>
	</script>
<?php if ($ugddaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_Rujukan" class="form-group row">
		<label id="elh_ugddaftar_Id_Rujukan" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Id_Rujukan" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Rujukan->caption() ?><?php echo ($ugddaftar->Id_Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Id_Rujukan->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Rujukan" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Rujukan">
<div id="tp_x_Id_Rujukan" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_Rujukan" data-value-separator="<?php echo $ugddaftar->Id_Rujukan->displayValueSeparatorAttribute() ?>" name="x_Id_Rujukan" id="x_Id_Rujukan" value="{value}"<?php echo $ugddaftar->Id_Rujukan->editAttributes() ?>></div>
<div id="dsl_x_Id_Rujukan" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_Rujukan->radioButtonListHtml(FALSE, "x_Id_Rujukan") ?>
</div></div>
<?php echo $ugddaftar->Id_Rujukan->Lookup->getParamTag("p_x_Id_Rujukan") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokasalrujukan") && !$ugddaftar->Id_Rujukan->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Rujukan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_Rujukan->caption() ?>" data-title="<?php echo $ugddaftar->Id_Rujukan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Rujukan',url:'lokasalrujukanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_Rujukan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Rujukan">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Id_Rujukan"><script id="tpc_ugddaftar_Id_Rujukan" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_Rujukan->caption() ?><?php echo ($ugddaftar->Id_Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Id_Rujukan->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_Rujukan" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_Rujukan">
<div id="tp_x_Id_Rujukan" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_Rujukan" data-value-separator="<?php echo $ugddaftar->Id_Rujukan->displayValueSeparatorAttribute() ?>" name="x_Id_Rujukan" id="x_Id_Rujukan" value="{value}"<?php echo $ugddaftar->Id_Rujukan->editAttributes() ?>></div>
<div id="dsl_x_Id_Rujukan" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_Rujukan->radioButtonListHtml(FALSE, "x_Id_Rujukan") ?>
</div></div>
<?php echo $ugddaftar->Id_Rujukan->Lookup->getParamTag("p_x_Id_Rujukan") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokasalrujukan") && !$ugddaftar->Id_Rujukan->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_Rujukan" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_Rujukan->caption() ?>" data-title="<?php echo $ugddaftar->Id_Rujukan->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_Rujukan',url:'lokasalrujukanaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_Rujukan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_JenisPasien" class="form-group row">
		<label id="elh_ugddaftar_Id_JenisPasien" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Id_JenisPasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_JenisPasien->caption() ?><?php echo ($ugddaftar->Id_JenisPasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Id_JenisPasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_JenisPasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_JenisPasien">
<div id="tp_x_Id_JenisPasien" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_JenisPasien" data-value-separator="<?php echo $ugddaftar->Id_JenisPasien->displayValueSeparatorAttribute() ?>" name="x_Id_JenisPasien" id="x_Id_JenisPasien" value="{value}"<?php echo $ugddaftar->Id_JenisPasien->editAttributes() ?>></div>
<div id="dsl_x_Id_JenisPasien" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_JenisPasien->radioButtonListHtml(FALSE, "x_Id_JenisPasien") ?>
</div></div>
<?php echo $ugddaftar->Id_JenisPasien->Lookup->getParamTag("p_x_Id_JenisPasien") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokjenispasien") && !$ugddaftar->Id_JenisPasien->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_JenisPasien" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_JenisPasien->caption() ?>" data-title="<?php echo $ugddaftar->Id_JenisPasien->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_JenisPasien',url:'lokjenispasienaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_JenisPasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_JenisPasien">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Id_JenisPasien"><script id="tpc_ugddaftar_Id_JenisPasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_JenisPasien->caption() ?><?php echo ($ugddaftar->Id_JenisPasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Id_JenisPasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_JenisPasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_JenisPasien">
<div id="tp_x_Id_JenisPasien" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_JenisPasien" data-value-separator="<?php echo $ugddaftar->Id_JenisPasien->displayValueSeparatorAttribute() ?>" name="x_Id_JenisPasien" id="x_Id_JenisPasien" value="{value}"<?php echo $ugddaftar->Id_JenisPasien->editAttributes() ?>></div>
<div id="dsl_x_Id_JenisPasien" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_JenisPasien->radioButtonListHtml(FALSE, "x_Id_JenisPasien") ?>
</div></div>
<?php echo $ugddaftar->Id_JenisPasien->Lookup->getParamTag("p_x_Id_JenisPasien") ?>
<?php if (AllowAdd(CurrentProjectID() . "lokjenispasien") && !$ugddaftar->Id_JenisPasien->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_JenisPasien" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_JenisPasien->caption() ?>" data-title="<?php echo $ugddaftar->Id_JenisPasien->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_JenisPasien',url:'lokjenispasienaddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_JenisPasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Lama_Baru->Visible) { // Lama_Baru ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Lama_Baru" class="form-group row">
		<label id="elh_ugddaftar_Lama_Baru" for="x_Lama_Baru" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Lama_Baru" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Lama_Baru->caption() ?><?php echo ($ugddaftar->Lama_Baru->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Lama_Baru->cellAttributes() ?>>
<script id="tpx_ugddaftar_Lama_Baru" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Lama_Baru">
<input type="text" data-table="ugddaftar" data-field="x_Lama_Baru" name="x_Lama_Baru" id="x_Lama_Baru" size="15" maxlength="50" value="<?php echo $ugddaftar->Lama_Baru->EditValue ?>"<?php echo $ugddaftar->Lama_Baru->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Lama_Baru->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Lama_Baru">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Lama_Baru"><script id="tpc_ugddaftar_Lama_Baru" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Lama_Baru->caption() ?><?php echo ($ugddaftar->Lama_Baru->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Lama_Baru->cellAttributes() ?>>
<script id="tpx_ugddaftar_Lama_Baru" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Lama_Baru">
<input type="text" data-table="ugddaftar" data-field="x_Lama_Baru" name="x_Lama_Baru" id="x_Lama_Baru" size="15" maxlength="50" value="<?php echo $ugddaftar->Lama_Baru->EditValue ?>"<?php echo $ugddaftar->Lama_Baru->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Lama_Baru->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Id_BiayaDaftar" class="form-group row">
		<label id="elh_ugddaftar_Id_BiayaDaftar" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Id_BiayaDaftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?><?php echo ($ugddaftar->Id_BiayaDaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Id_BiayaDaftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_BiayaDaftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_BiayaDaftar">
<?php $ugddaftar->Id_BiayaDaftar->EditAttrs["onclick"] = "ew.autoFill(this); " . @$ugddaftar->Id_BiayaDaftar->EditAttrs["onclick"]; ?>
<div id="tp_x_Id_BiayaDaftar" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_BiayaDaftar" data-value-separator="<?php echo $ugddaftar->Id_BiayaDaftar->displayValueSeparatorAttribute() ?>" name="x_Id_BiayaDaftar" id="x_Id_BiayaDaftar" value="{value}"<?php echo $ugddaftar->Id_BiayaDaftar->editAttributes() ?>></div>
<div id="dsl_x_Id_BiayaDaftar" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_BiayaDaftar->radioButtonListHtml(FALSE, "x_Id_BiayaDaftar") ?>
</div></div>
<?php echo $ugddaftar->Id_BiayaDaftar->Lookup->getParamTag("p_x_Id_BiayaDaftar") ?>
<?php if (AllowAdd(CurrentProjectID() . "ugdbiayadaftar") && !$ugddaftar->Id_BiayaDaftar->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_BiayaDaftar" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_BiayaDaftar->caption() ?>" data-title="<?php echo $ugddaftar->Id_BiayaDaftar->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_BiayaDaftar',url:'ugdbiayadaftaraddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_BiayaDaftar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_BiayaDaftar">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Id_BiayaDaftar"><script id="tpc_ugddaftar_Id_BiayaDaftar" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?><?php echo ($ugddaftar->Id_BiayaDaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Id_BiayaDaftar->cellAttributes() ?>>
<script id="tpx_ugddaftar_Id_BiayaDaftar" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Id_BiayaDaftar">
<?php $ugddaftar->Id_BiayaDaftar->EditAttrs["onclick"] = "ew.autoFill(this); " . @$ugddaftar->Id_BiayaDaftar->EditAttrs["onclick"]; ?>
<div id="tp_x_Id_BiayaDaftar" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Id_BiayaDaftar" data-value-separator="<?php echo $ugddaftar->Id_BiayaDaftar->displayValueSeparatorAttribute() ?>" name="x_Id_BiayaDaftar" id="x_Id_BiayaDaftar" value="{value}"<?php echo $ugddaftar->Id_BiayaDaftar->editAttributes() ?>></div>
<div id="dsl_x_Id_BiayaDaftar" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Id_BiayaDaftar->radioButtonListHtml(FALSE, "x_Id_BiayaDaftar") ?>
</div></div>
<?php echo $ugddaftar->Id_BiayaDaftar->Lookup->getParamTag("p_x_Id_BiayaDaftar") ?>
<?php if (AllowAdd(CurrentProjectID() . "ugdbiayadaftar") && !$ugddaftar->Id_BiayaDaftar->ReadOnly) { ?>
<div class="input-group-append"><button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x_Id_BiayaDaftar" title="<?php echo HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $ugddaftar->Id_BiayaDaftar->caption() ?>" data-title="<?php echo $ugddaftar->Id_BiayaDaftar->caption() ?>" onclick="ew.addOptionDialogShow({lnk:this,el:'x_Id_BiayaDaftar',url:'ugdbiayadaftaraddopt.php'});"><i class="fa fa-plus ew-icon"></i></button></div>
<?php } ?>
</span>
</script>
<?php echo $ugddaftar->Id_BiayaDaftar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Total_Biaya->Visible) { // Total_Biaya ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Total_Biaya" class="form-group row">
		<label id="elh_ugddaftar_Total_Biaya" for="x_Total_Biaya" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Total_Biaya" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Total_Biaya->caption() ?><?php echo ($ugddaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Total_Biaya->cellAttributes() ?>>
<script id="tpx_ugddaftar_Total_Biaya" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Total_Biaya">
<input type="text" data-table="ugddaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $ugddaftar->Total_Biaya->EditValue ?>"<?php echo $ugddaftar->Total_Biaya->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Total_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Total_Biaya">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Total_Biaya"><script id="tpc_ugddaftar_Total_Biaya" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Total_Biaya->caption() ?><?php echo ($ugddaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Total_Biaya->cellAttributes() ?>>
<script id="tpx_ugddaftar_Total_Biaya" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Total_Biaya">
<input type="text" data-table="ugddaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $ugddaftar->Total_Biaya->EditValue ?>"<?php echo $ugddaftar->Total_Biaya->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Total_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Rawat->Visible) { // Rawat ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Rawat" class="form-group row">
		<label id="elh_ugddaftar_Rawat" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Rawat" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Rawat->caption() ?><?php echo ($ugddaftar->Rawat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Rawat->cellAttributes() ?>>
<script id="tpx_ugddaftar_Rawat" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Rawat">
<div id="tp_x_Rawat" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Rawat" data-value-separator="<?php echo $ugddaftar->Rawat->displayValueSeparatorAttribute() ?>" name="x_Rawat" id="x_Rawat" value="{value}"<?php echo $ugddaftar->Rawat->editAttributes() ?>></div>
<div id="dsl_x_Rawat" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Rawat->radioButtonListHtml(FALSE, "x_Rawat") ?>
</div></div>
</span>
</script>
<?php echo $ugddaftar->Rawat->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Rawat">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Rawat"><script id="tpc_ugddaftar_Rawat" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Rawat->caption() ?><?php echo ($ugddaftar->Rawat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Rawat->cellAttributes() ?>>
<script id="tpx_ugddaftar_Rawat" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Rawat">
<div id="tp_x_Rawat" class="ew-template"><input type="radio" class="form-check-input" data-table="ugddaftar" data-field="x_Rawat" data-value-separator="<?php echo $ugddaftar->Rawat->displayValueSeparatorAttribute() ?>" name="x_Rawat" id="x_Rawat" value="{value}"<?php echo $ugddaftar->Rawat->editAttributes() ?>></div>
<div id="dsl_x_Rawat" data-repeatcolumn="1" class="ew-item-list d-none"><div>
<?php echo $ugddaftar->Rawat->radioButtonListHtml(FALSE, "x_Rawat") ?>
</div></div>
</span>
</script>
<?php echo $ugddaftar->Rawat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
	<script id="tpx_ugddaftar_Status" class="ugddaftaradd" type="text/html">
	<span id="el_ugddaftar_Status">
	<input type="hidden" data-table="ugddaftar" data-field="x_Status" name="x_Status" id="x_Status" value="<?php echo HtmlEncode($ugddaftar->Status->CurrentValue) ?>">
	</span>
	</script>
	<script id="tpx_ugddaftar_Petugas" class="ugddaftaradd" type="text/html">
	<span id="el_ugddaftar_Petugas">
	<input type="hidden" data-table="ugddaftar" data-field="x_Petugas" name="x_Petugas" id="x_Petugas" value="<?php echo HtmlEncode($ugddaftar->Petugas->CurrentValue) ?>">
	</span>
	</script>
<?php if ($ugddaftar->No_RM->Visible) { // No_RM ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_No_RM" class="form-group row">
		<label id="elh_ugddaftar_No_RM" for="x_No_RM" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_No_RM" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->No_RM->caption() ?><?php echo ($ugddaftar->No_RM->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->No_RM->cellAttributes() ?>>
<script id="tpx_ugddaftar_No_RM" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_No_RM">
<input type="text" data-table="ugddaftar" data-field="x_No_RM" name="x_No_RM" id="x_No_RM" size="15" maxlength="50" value="<?php echo $ugddaftar->No_RM->EditValue ?>"<?php echo $ugddaftar->No_RM->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->No_RM->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_No_RM">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_No_RM"><script id="tpc_ugddaftar_No_RM" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->No_RM->caption() ?><?php echo ($ugddaftar->No_RM->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->No_RM->cellAttributes() ?>>
<script id="tpx_ugddaftar_No_RM" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_No_RM">
<input type="text" data-table="ugddaftar" data-field="x_No_RM" name="x_No_RM" id="x_No_RM" size="15" maxlength="50" value="<?php echo $ugddaftar->No_RM->EditValue ?>"<?php echo $ugddaftar->No_RM->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->No_RM->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Pasien" class="form-group row">
		<label id="elh_ugddaftar_Nama_Pasien" for="x_Nama_Pasien" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Nama_Pasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Nama_Pasien->caption() ?><?php echo ($ugddaftar->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Nama_Pasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Nama_Pasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Nama_Pasien">
<input type="text" data-table="ugddaftar" data-field="x_Nama_Pasien" name="x_Nama_Pasien" id="x_Nama_Pasien" size="22" maxlength="50" value="<?php echo $ugddaftar->Nama_Pasien->EditValue ?>"<?php echo $ugddaftar->Nama_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Nama_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Pasien">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Nama_Pasien"><script id="tpc_ugddaftar_Nama_Pasien" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Nama_Pasien->caption() ?><?php echo ($ugddaftar->Nama_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Nama_Pasien->cellAttributes() ?>>
<script id="tpx_ugddaftar_Nama_Pasien" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Nama_Pasien">
<input type="text" data-table="ugddaftar" data-field="x_Nama_Pasien" name="x_Nama_Pasien" id="x_Nama_Pasien" size="22" maxlength="50" value="<?php echo $ugddaftar->Nama_Pasien->EditValue ?>"<?php echo $ugddaftar->Nama_Pasien->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Nama_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Tgl_Lahir" class="form-group row">
		<label id="elh_ugddaftar_Tgl_Lahir" for="x_Tgl_Lahir" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Tgl_Lahir" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Tgl_Lahir->caption() ?><?php echo ($ugddaftar->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Tgl_Lahir->cellAttributes() ?>>
<script id="tpx_ugddaftar_Tgl_Lahir" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Tgl_Lahir">
<input type="text" data-table="ugddaftar" data-field="x_Tgl_Lahir" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="15" value="<?php echo $ugddaftar->Tgl_Lahir->EditValue ?>"<?php echo $ugddaftar->Tgl_Lahir->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Tgl_Lahir->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Tgl_Lahir">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Tgl_Lahir"><script id="tpc_ugddaftar_Tgl_Lahir" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Tgl_Lahir->caption() ?><?php echo ($ugddaftar->Tgl_Lahir->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Tgl_Lahir->cellAttributes() ?>>
<script id="tpx_ugddaftar_Tgl_Lahir" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Tgl_Lahir">
<input type="text" data-table="ugddaftar" data-field="x_Tgl_Lahir" data-format="7" name="x_Tgl_Lahir" id="x_Tgl_Lahir" size="15" value="<?php echo $ugddaftar->Tgl_Lahir->EditValue ?>"<?php echo $ugddaftar->Tgl_Lahir->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Tgl_Lahir->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jenis_Kelamin" class="form-group row">
		<label id="elh_ugddaftar_Jenis_Kelamin" for="x_Jenis_Kelamin" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Jenis_Kelamin" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Jenis_Kelamin->caption() ?><?php echo ($ugddaftar->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Jenis_Kelamin->cellAttributes() ?>>
<script id="tpx_ugddaftar_Jenis_Kelamin" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Jenis_Kelamin">
<input type="text" data-table="ugddaftar" data-field="x_Jenis_Kelamin" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" size="15" maxlength="50" value="<?php echo $ugddaftar->Jenis_Kelamin->EditValue ?>"<?php echo $ugddaftar->Jenis_Kelamin->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Jenis_Kelamin->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Kelamin">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Jenis_Kelamin"><script id="tpc_ugddaftar_Jenis_Kelamin" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Jenis_Kelamin->caption() ?><?php echo ($ugddaftar->Jenis_Kelamin->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Jenis_Kelamin->cellAttributes() ?>>
<script id="tpx_ugddaftar_Jenis_Kelamin" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Jenis_Kelamin">
<input type="text" data-table="ugddaftar" data-field="x_Jenis_Kelamin" name="x_Jenis_Kelamin" id="x_Jenis_Kelamin" size="15" maxlength="50" value="<?php echo $ugddaftar->Jenis_Kelamin->EditValue ?>"<?php echo $ugddaftar->Jenis_Kelamin->editAttributes() ?>>
</span>
</script>
<?php echo $ugddaftar->Jenis_Kelamin->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Alamat->Visible) { // Alamat ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
	<div id="r_Alamat" class="form-group row">
		<label id="elh_ugddaftar_Alamat" for="x_Alamat" class="<?php echo $ugddaftar_add->LeftColumnClass ?>"><script id="tpc_ugddaftar_Alamat" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Alamat->caption() ?><?php echo ($ugddaftar->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></label>
		<div class="<?php echo $ugddaftar_add->RightColumnClass ?>"><div<?php echo $ugddaftar->Alamat->cellAttributes() ?>>
<script id="tpx_ugddaftar_Alamat" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Alamat">
<textarea data-table="ugddaftar" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="2"<?php echo $ugddaftar->Alamat->editAttributes() ?>><?php echo $ugddaftar->Alamat->EditValue ?></textarea>
</span>
</script>
<?php echo $ugddaftar->Alamat->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Alamat">
		<td class="<?php echo $ugddaftar_add->TableLeftColumnClass ?>"><span id="elh_ugddaftar_Alamat"><script id="tpc_ugddaftar_Alamat" class="ugddaftaradd" type="text/html"><span><?php echo $ugddaftar->Alamat->caption() ?><?php echo ($ugddaftar->Alamat->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></script></span></td>
		<td<?php echo $ugddaftar->Alamat->cellAttributes() ?>>
<script id="tpx_ugddaftar_Alamat" class="ugddaftaradd" type="text/html">
<span id="el_ugddaftar_Alamat">
<textarea data-table="ugddaftar" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" cols="35" rows="2"<?php echo $ugddaftar->Alamat->editAttributes() ?>><?php echo $ugddaftar->Alamat->EditValue ?></textarea>
</span>
</script>
<?php echo $ugddaftar->Alamat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($ugddaftar_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<div id="tpd_ugddaftaradd" class="ew-custom-template"></div>
<script id="tpm_ugddaftaradd" type="text/html">
<div id="ct_ugddaftar_add">	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3">
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Tgl_Daftar->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Tgl_Daftar"/}} {{include tmpl="#tpx_ugddaftar_Status"/}}</div>
			<div>{{include tmpl="#tpx_ugddaftar_Id_Pasien"/}} {{include tmpl="#tpx_ugddaftar_Petugas"/}} {{include tmpl="#tpx_ugddaftar_Waktu"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->No_RM->caption() ?></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_No_RM"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Nama_Pasien->caption() ?></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Nama_Pasien"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Tgl_Lahir->caption() ?></label></div>			
			<div>{{include tmpl="#tpx_ugddaftar_Tgl_Lahir"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Jenis_Kelamin->caption() ?></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Jenis_Kelamin"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Alamat->caption() ?></label></div>			
			<div>{{include tmpl="#tpx_ugddaftar_Alamat"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Lama_Baru->caption() ?></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Lama_Baru"/}}</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4">
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Id_Rujukan->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Id_Rujukan"/}}</div>
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Id_JenisPasien->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Id_JenisPasien"/}}</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Rawat->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Rawat"/}} {{include tmpl="#tpx_ugddaftar_Id_Poliklinik"/}}</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?> <font color="red">*</font></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Id_BiayaDaftar"/}}</div> 		
			<div><label class="control-label ewLabel"><?php echo $ugddaftar->Total_Biaya->caption() ?></label></div>
			<div>{{include tmpl="#tpx_ugddaftar_Total_Biaya"/}}</div>		
		</div>
	</div>
</div>
</script>
<?php if (!$ugddaftar_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $ugddaftar_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $ugddaftar_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$ugddaftar_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script>
ew.vars.templateData = { rows: <?php echo JsonEncode($ugddaftar->Rows) ?> };
ew.applyTemplate("tpd_ugddaftaradd", "tpm_ugddaftaradd", "ugddaftaradd", "<?php echo $ugddaftar->CustomExport ?>", ew.vars.templateData.rows[0]);
jQuery("script.ugddaftaradd_js").each(function(){ew.addScript(this.text);});
</script>
<?php
$ugddaftar_add->showPageFooter();
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
$('#btnAction').on('click', function(){
	if ($('input[name=x_Lama_Baru]:radio:checked').val()=="PASIEN BARU"){
	   window.open("kartu_fargo.php?Id_Pasien=" + $("#x_Id_Pasien").val(), "_blank");
	}
});
</script>
<?php include_once "footer.php" ?>
<?php
$ugddaftar_add->terminate();
?>