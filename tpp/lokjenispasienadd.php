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
$lokjenispasien_add = new lokjenispasien_add();

// Run the page
$lokjenispasien_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokjenispasien_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokjenispasienadd = currentForm = new ew.Form("flokjenispasienadd", "add");

// Validate form
flokjenispasienadd.validate = function() {
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
		<?php if ($lokjenispasien_add->Id_JenisPasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_JenisPasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokjenispasien->Id_JenisPasien->caption(), $lokjenispasien->Id_JenisPasien->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokjenispasien_add->Jenis_Pasien->Required) { ?>
			elm = this.getElements("x" + infix + "_Jenis_Pasien");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokjenispasien->Jenis_Pasien->caption(), $lokjenispasien->Jenis_Pasien->RequiredErrorMessage)) ?>");
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
flokjenispasienadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokjenispasienadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokjenispasien_add->showPageHeader(); ?>
<?php
$lokjenispasien_add->showMessage();
?>
<form name="flokjenispasienadd" id="flokjenispasienadd" class="<?php echo $lokjenispasien_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokjenispasien_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokjenispasien_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokjenispasien">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokjenispasien_add->IsModal ?>">
<?php if (!$lokjenispasien_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokjenispasien_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokjenispasienadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
<?php if ($lokjenispasien_add->IsMobileOrModal) { ?>
	<div id="r_Jenis_Pasien" class="form-group row">
		<label id="elh_lokjenispasien_Jenis_Pasien" for="x_Jenis_Pasien" class="<?php echo $lokjenispasien_add->LeftColumnClass ?>"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?><?php echo ($lokjenispasien->Jenis_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokjenispasien_add->RightColumnClass ?>"><div<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
<span id="el_lokjenispasien_Jenis_Pasien">
<input type="text" data-table="lokjenispasien" data-field="x_Jenis_Pasien" name="x_Jenis_Pasien" id="x_Jenis_Pasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Jenis_Pasien->EditValue ?>"<?php echo $lokjenispasien->Jenis_Pasien->editAttributes() ?>>
</span>
<?php echo $lokjenispasien->Jenis_Pasien->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Pasien">
		<td class="<?php echo $lokjenispasien_add->TableLeftColumnClass ?>"><span id="elh_lokjenispasien_Jenis_Pasien"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?><?php echo ($lokjenispasien->Jenis_Pasien->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
<span id="el_lokjenispasien_Jenis_Pasien">
<input type="text" data-table="lokjenispasien" data-field="x_Jenis_Pasien" name="x_Jenis_Pasien" id="x_Jenis_Pasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Jenis_Pasien->EditValue ?>"<?php echo $lokjenispasien->Jenis_Pasien->editAttributes() ?>>
</span>
<?php echo $lokjenispasien->Jenis_Pasien->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokjenispasien_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokjenispasien_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokjenispasien_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokjenispasien_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokjenispasien_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokjenispasien_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokjenispasien_add->terminate();
?>