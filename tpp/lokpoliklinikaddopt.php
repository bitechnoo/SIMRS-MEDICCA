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
$lokpoliklinik_addopt = new lokpoliklinik_addopt();

// Run the page
$lokpoliklinik_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpoliklinik_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var flokpoliklinikaddopt = currentForm = new ew.Form("flokpoliklinikaddopt", "addopt");

// Validate form
flokpoliklinikaddopt.validate = function() {
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
		<?php if ($lokpoliklinik_addopt->Id_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpoliklinik->Id_Poliklinik->caption(), $lokpoliklinik->Id_Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpoliklinik_addopt->Nama_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpoliklinik->Nama_Poliklinik->caption(), $lokpoliklinik->Nama_Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flokpoliklinikaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpoliklinikaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpoliklinik_addopt->showPageHeader(); ?>
<?php
$lokpoliklinik_addopt->showMessage();
?>
<form name="flokpoliklinikaddopt" id="flokpoliklinikaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($lokpoliklinik_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpoliklinik_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $lokpoliklinik_addopt->TableVar ?>">
<?php if ($lokpoliklinik->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
	<input type="hidden" data-table="lokpoliklinik" data-field="x_Id_Poliklinik" name="x_Id_Poliklinik" id="x_Id_Poliklinik" value="<?php echo HtmlEncode($lokpoliklinik->Id_Poliklinik->CurrentValue) ?>">
<?php } ?>
<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Nama_Poliklinik"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?><?php echo ($lokpoliklinik->Nama_Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokpoliklinik" data-field="x_Nama_Poliklinik" name="x_Nama_Poliklinik" id="x_Nama_Poliklinik" size="30" maxlength="50" value="<?php echo $lokpoliklinik->Nama_Poliklinik->EditValue ?>"<?php echo $lokpoliklinik->Nama_Poliklinik->editAttributes() ?>>
<?php echo $lokpoliklinik->Nama_Poliklinik->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$lokpoliklinik_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$lokpoliklinik_addopt->terminate();
?>