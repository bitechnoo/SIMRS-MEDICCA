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
$lokasalrujukan_addopt = new lokasalrujukan_addopt();

// Run the page
$lokasalrujukan_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokasalrujukan_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var flokasalrujukanaddopt = currentForm = new ew.Form("flokasalrujukanaddopt", "addopt");

// Validate form
flokasalrujukanaddopt.validate = function() {
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
		<?php if ($lokasalrujukan_addopt->Id_Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokasalrujukan->Id_Rujukan->caption(), $lokasalrujukan->Id_Rujukan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokasalrujukan_addopt->Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokasalrujukan->Rujukan->caption(), $lokasalrujukan->Rujukan->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flokasalrujukanaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokasalrujukanaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokasalrujukan_addopt->showPageHeader(); ?>
<?php
$lokasalrujukan_addopt->showMessage();
?>
<form name="flokasalrujukanaddopt" id="flokasalrujukanaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($lokasalrujukan_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokasalrujukan_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $lokasalrujukan_addopt->TableVar ?>">
<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
	<input type="hidden" data-table="lokasalrujukan" data-field="x_Id_Rujukan" name="x_Id_Rujukan" id="x_Id_Rujukan" value="<?php echo HtmlEncode($lokasalrujukan->Id_Rujukan->CurrentValue) ?>">
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Rujukan"><?php echo $lokasalrujukan->Rujukan->caption() ?><?php echo ($lokasalrujukan->Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokasalrujukan" data-field="x_Rujukan" name="x_Rujukan" id="x_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Rujukan->editAttributes() ?>>
<?php echo $lokasalrujukan->Rujukan->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$lokasalrujukan_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$lokasalrujukan_addopt->terminate();
?>