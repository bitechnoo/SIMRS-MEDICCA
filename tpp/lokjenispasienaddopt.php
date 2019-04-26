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
$lokjenispasien_addopt = new lokjenispasien_addopt();

// Run the page
$lokjenispasien_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokjenispasien_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var flokjenispasienaddopt = currentForm = new ew.Form("flokjenispasienaddopt", "addopt");

// Validate form
flokjenispasienaddopt.validate = function() {
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
		<?php if ($lokjenispasien_addopt->Id_JenisPasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_JenisPasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokjenispasien->Id_JenisPasien->caption(), $lokjenispasien->Id_JenisPasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokjenispasien_addopt->Jenis_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokjenispasien->Jenis_Pasien->caption(), $lokjenispasien->Jenis_Pasien->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flokjenispasienaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokjenispasienaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokjenispasien_addopt->showPageHeader(); ?>
<?php
$lokjenispasien_addopt->showMessage();
?>
<form name="flokjenispasienaddopt" id="flokjenispasienaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($lokjenispasien_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokjenispasien_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $lokjenispasien_addopt->TableVar ?>">
<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
	<input type="hidden" data-table="lokjenispasien" data-field="x_Id_JenisPasien" name="x_Id_JenisPasien" id="x_Id_JenisPasien" value="<?php echo HtmlEncode($lokjenispasien->Id_JenisPasien->CurrentValue) ?>">
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Jenis_Pasien"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?><?php echo ($lokjenispasien->Jenis_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokjenispasien" data-field="x_Jenis_Pasien" name="x_Jenis_Pasien" id="x_Jenis_Pasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Jenis_Pasien->EditValue ?>"<?php echo $lokjenispasien->Jenis_Pasien->editAttributes() ?>>
<?php echo $lokjenispasien->Jenis_Pasien->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$lokjenispasien_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$lokjenispasien_addopt->terminate();
?>