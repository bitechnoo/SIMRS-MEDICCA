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
$lokkelurahan_addopt = new lokkelurahan_addopt();

// Run the page
$lokkelurahan_addopt->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokkelurahan_addopt->Page_Render();
?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "addopt";
var flokkelurahanaddopt = currentForm = new ew.Form("flokkelurahanaddopt", "addopt");

// Validate form
flokkelurahanaddopt.validate = function() {
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
		<?php if ($lokkelurahan_addopt->Id_Kelurahan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Kelurahan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokkelurahan->Id_Kelurahan->caption(), $lokkelurahan->Id_Kelurahan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokkelurahan_addopt->Kelurahan->Required) { ?>
			elm = this.getElements("x" + infix + "_Kelurahan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokkelurahan->Kelurahan->caption(), $lokkelurahan->Kelurahan->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
flokkelurahanaddopt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokkelurahanaddopt.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokkelurahan_addopt->showPageHeader(); ?>
<?php
$lokkelurahan_addopt->showMessage();
?>
<form name="flokkelurahanaddopt" id="flokkelurahanaddopt" class="ew-form ew-horizontal" action="<?php echo API_URL ?>" method="post">
<?php //if ($lokkelurahan_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokkelurahan_addopt->Token ?>">
<?php //} ?>
<input type="hidden" name="<?php echo API_ACTION_NAME ?>" id="<?php echo API_ACTION_NAME ?>" value="<?php echo API_ADD_ACTION ?>">
<input type="hidden" name="<?php echo API_OBJECT_NAME ?>" id="<?php echo API_OBJECT_NAME ?>" value="<?php echo $lokkelurahan_addopt->TableVar ?>">
<?php if ($lokkelurahan->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
	<input type="hidden" data-table="lokkelurahan" data-field="x_Id_Kelurahan" name="x_Id_Kelurahan" id="x_Id_Kelurahan" value="<?php echo HtmlEncode($lokkelurahan->Id_Kelurahan->CurrentValue) ?>">
<?php } ?>
<?php if ($lokkelurahan->Kelurahan->Visible) { // Kelurahan ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="x_Kelurahan"><?php echo $lokkelurahan->Kelurahan->caption() ?><?php echo ($lokkelurahan->Kelurahan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="col-sm-10">
<input type="text" data-table="lokkelurahan" data-field="x_Kelurahan" name="x_Kelurahan" id="x_Kelurahan" size="30" maxlength="30" value="<?php echo $lokkelurahan->Kelurahan->EditValue ?>"<?php echo $lokkelurahan->Kelurahan->editAttributes() ?>>
<?php echo $lokkelurahan->Kelurahan->CustomMsg ?></div>
	</div>
<?php } ?>
</form>
<?php
$lokkelurahan_addopt->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$lokkelurahan_addopt->terminate();
?>