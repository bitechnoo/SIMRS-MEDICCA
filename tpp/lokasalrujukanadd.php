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
$lokasalrujukan_add = new lokasalrujukan_add();

// Run the page
$lokasalrujukan_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokasalrujukan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokasalrujukanadd = currentForm = new ew.Form("flokasalrujukanadd", "add");

// Validate form
flokasalrujukanadd.validate = function() {
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
		<?php if ($lokasalrujukan_add->Id_Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokasalrujukan->Id_Rujukan->caption(), $lokasalrujukan->Id_Rujukan->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokasalrujukan_add->Rujukan->Required) { ?>
			elm = this.getElements("x" + infix + "_Rujukan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokasalrujukan->Rujukan->caption(), $lokasalrujukan->Rujukan->RequiredErrorMessage)) ?>");
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
flokasalrujukanadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokasalrujukanadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokasalrujukan_add->showPageHeader(); ?>
<?php
$lokasalrujukan_add->showMessage();
?>
<form name="flokasalrujukanadd" id="flokasalrujukanadd" class="<?php echo $lokasalrujukan_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokasalrujukan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokasalrujukan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokasalrujukan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokasalrujukan_add->IsModal ?>">
<?php if (!$lokasalrujukan_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokasalrujukan_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokasalrujukanadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
<?php if ($lokasalrujukan_add->IsMobileOrModal) { ?>
	<div id="r_Rujukan" class="form-group row">
		<label id="elh_lokasalrujukan_Rujukan" for="x_Rujukan" class="<?php echo $lokasalrujukan_add->LeftColumnClass ?>"><?php echo $lokasalrujukan->Rujukan->caption() ?><?php echo ($lokasalrujukan->Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokasalrujukan_add->RightColumnClass ?>"><div<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
<span id="el_lokasalrujukan_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Rujukan" name="x_Rujukan" id="x_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Rujukan->editAttributes() ?>>
</span>
<?php echo $lokasalrujukan->Rujukan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Rujukan">
		<td class="<?php echo $lokasalrujukan_add->TableLeftColumnClass ?>"><span id="elh_lokasalrujukan_Rujukan"><?php echo $lokasalrujukan->Rujukan->caption() ?><?php echo ($lokasalrujukan->Rujukan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
<span id="el_lokasalrujukan_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Rujukan" name="x_Rujukan" id="x_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Rujukan->editAttributes() ?>>
</span>
<?php echo $lokasalrujukan->Rujukan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokasalrujukan_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokasalrujukan_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokasalrujukan_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokasalrujukan_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokasalrujukan_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokasalrujukan_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokasalrujukan_add->terminate();
?>