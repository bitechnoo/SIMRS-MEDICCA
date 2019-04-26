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
$lokbiayadaftar_addopt = new lokbiayadaftar_addopt();

// Run the page
$lokbiayadaftar_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokbiayadaftar_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var flokbiayadaftaraddopt = currentForm = new ew.Form("flokbiayadaftaraddopt", "addopt");

// Validate form
flokbiayadaftaraddopt.validate = function() {
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
		<?php if ($lokbiayadaftar_addopt->Id_Biayadaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Biayadaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Id_Biayadaftar->caption(), $lokbiayadaftar->Id_Biayadaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokbiayadaftar_addopt->Nama_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Nama_Biaya->caption(), $lokbiayadaftar->Nama_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokbiayadaftar_addopt->Jasa_Dokter->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Dokter->caption(), $lokbiayadaftar->Jasa_Dokter->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Dokter->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_addopt->Jasa_Layanan->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Layanan->caption(), $lokbiayadaftar->Jasa_Layanan->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Layanan->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_addopt->Jasa_Sarana->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Sarana->caption(), $lokbiayadaftar->Jasa_Sarana->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Sarana->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_addopt->Total_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Total_Biaya->caption(), $lokbiayadaftar->Total_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Total_Biaya");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Total_Biaya->errorMessage()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flokbiayadaftaraddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokbiayadaftaraddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokbiayadaftar_addopt->showPageHeader(); ?>
<?php
$lokbiayadaftar_addopt->showMessage();
?>
<form name="flokbiayadaftaraddopt" id="flokbiayadaftaraddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($lokbiayadaftar_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokbiayadaftar_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $lokbiayadaftar_addopt->TableVar ?>">
<?php if ($lokbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
	<input type="hidden" data-table="lokbiayadaftar" data-field="x_Id_Biayadaftar" name="x_Id_Biayadaftar" id="x_Id_Biayadaftar" value="<?php echo HtmlEncode($lokbiayadaftar->Id_Biayadaftar->CurrentValue) ?>">
<?php } ?>
<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Nama_Biaya"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?><?php echo ($lokbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="60" maxlength="75" value="<?php echo $lokbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Nama_Biaya->editAttributes() ?>>
<?php echo $lokbiayadaftar->Nama_Biaya->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Dokter"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($lokbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $lokbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Dokter->editAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Dokter->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Layanan"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($lokbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $lokbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Layanan->editAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Layanan->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jasa_Sarana"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($lokbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $lokbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Sarana->editAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Sarana->CustomMsg ?></div>
	</div>
<?php } ?>
<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Total_Biaya"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?><?php echo ($lokbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $lokbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Total_Biaya->editAttributes() ?>>
<?php echo $lokbiayadaftar->Total_Biaya->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$lokbiayadaftar_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$lokbiayadaftar_addopt->terminate();
?>