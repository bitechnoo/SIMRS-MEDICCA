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
$ugdbiayadaftar_addopt = new ugdbiayadaftar_addopt();

// Run the page
$ugdbiayadaftar_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugdbiayadaftar_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var fugdbiayadaftaraddopt = currentForm = new ew.Form("fugdbiayadaftaraddopt", "addopt");

// Validate form
fugdbiayadaftaraddopt.validate = function() {
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
		<?php if ($ugdbiayadaftar_addopt->Id_Biayadaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Biayadaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Id_Biayadaftar->caption(), $ugdbiayadaftar->Id_Biayadaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugdbiayadaftar_addopt->Nama_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Nama_Biaya->caption(), $ugdbiayadaftar->Nama_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($ugdbiayadaftar_addopt->Jasa_Dokter->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Dokter->caption(), $ugdbiayadaftar->Jasa_Dokter->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Dokter->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_addopt->Jasa_Layanan->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Layanan->caption(), $ugdbiayadaftar->Jasa_Layanan->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Layanan->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_addopt->Jasa_Sarana->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $ugdbiayadaftar->Jasa_Sarana->caption(), $ugdbiayadaftar->Jasa_Sarana->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($ugdbiayadaftar->Jasa_Sarana->errorMessage()) ?>");
		<?php if ($ugdbiayadaftar_addopt->Total_Biaya->Required) { ?>
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
	return true;
}

// Form_CustomValidate event
fugdbiayadaftaraddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugdbiayadaftaraddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $ugdbiayadaftar_addopt->showPageHeader(); ?>
<?php
$ugdbiayadaftar_addopt->showMessage();
?>
<form name="fugdbiayadaftaraddopt" id="fugdbiayadaftaraddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($ugdbiayadaftar_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugdbiayadaftar_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $ugdbiayadaftar_addopt->TableVar ?>">
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Id_Biayadaftar"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?><?php echo ($ugdbiayadaftar->Id_Biayadaftar->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Id_Biayadaftar" name="x_Id_Biayadaftar" id="x_Id_Biayadaftar" size="30" maxlength="50" value="<?php echo $ugdbiayadaftar->Id_Biayadaftar->EditValue ?>"<?php echo $ugdbiayadaftar->Id_Biayadaftar->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Nama_Biaya"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="30" maxlength="250" value="<?php echo $ugdbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Nama_Biaya->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Nama_Biaya->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Dokter"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Dokter->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Dokter->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Layanan"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Layanan->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Layanan->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Sarana"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($ugdbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $ugdbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $ugdbiayadaftar->Jasa_Sarana->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Sarana->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Total_Biaya"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?><?php echo ($ugdbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="ugdbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $ugdbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $ugdbiayadaftar->Total_Biaya->editAttributes() ?>>
<?php echo $ugdbiayadaftar->Total_Biaya->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$ugdbiayadaftar_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$ugdbiayadaftar_addopt->terminate();
?>