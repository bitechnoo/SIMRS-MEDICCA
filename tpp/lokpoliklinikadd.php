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
$lokpoliklinik_add = new lokpoliklinik_add();

// Run the page
$lokpoliklinik_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpoliklinik_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokpoliklinikadd = currentForm = new ew.Form("flokpoliklinikadd", "add");

// Validate form
flokpoliklinikadd.validate = function() {
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
		<?php if ($lokpoliklinik_add->Id_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpoliklinik->Id_Poliklinik->caption(), $lokpoliklinik->Id_Poliklinik->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokpoliklinik_add->Nama_Poliklinik->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Poliklinik");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokpoliklinik->Nama_Poliklinik->caption(), $lokpoliklinik->Nama_Poliklinik->RequiredErrorMessage)) ?>");
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
flokpoliklinikadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpoliklinikadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokpoliklinik_add->showPageHeader(); ?>
<?php
$lokpoliklinik_add->showMessage();
?>
<form name="flokpoliklinikadd" id="flokpoliklinikadd" class="<?php echo $lokpoliklinik_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpoliklinik_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpoliklinik_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpoliklinik">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokpoliklinik_add->IsModal ?>">
<?php if (!$lokpoliklinik_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokpoliklinik_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokpoliklinikadd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
<?php if ($lokpoliklinik_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Poliklinik" class="form-group row">
		<label id="elh_lokpoliklinik_Nama_Poliklinik" for="x_Nama_Poliklinik" class="<?php echo $lokpoliklinik_add->LeftColumnClass ?>"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?><?php echo ($lokpoliklinik->Nama_Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokpoliklinik_add->RightColumnClass ?>"><div<?php echo $lokpoliklinik->Nama_Poliklinik->cellAttributes() ?>>
<span id="el_lokpoliklinik_Nama_Poliklinik">
<input type="text" data-table="lokpoliklinik" data-field="x_Nama_Poliklinik" name="x_Nama_Poliklinik" id="x_Nama_Poliklinik" size="30" maxlength="50" value="<?php echo $lokpoliklinik->Nama_Poliklinik->EditValue ?>"<?php echo $lokpoliklinik->Nama_Poliklinik->editAttributes() ?>>
</span>
<?php echo $lokpoliklinik->Nama_Poliklinik->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Poliklinik">
		<td class="<?php echo $lokpoliklinik_add->TableLeftColumnClass ?>"><span id="elh_lokpoliklinik_Nama_Poliklinik"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?><?php echo ($lokpoliklinik->Nama_Poliklinik->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokpoliklinik->Nama_Poliklinik->cellAttributes() ?>>
<span id="el_lokpoliklinik_Nama_Poliklinik">
<input type="text" data-table="lokpoliklinik" data-field="x_Nama_Poliklinik" name="x_Nama_Poliklinik" id="x_Nama_Poliklinik" size="30" maxlength="50" value="<?php echo $lokpoliklinik->Nama_Poliklinik->EditValue ?>"<?php echo $lokpoliklinik->Nama_Poliklinik->editAttributes() ?>>
</span>
<?php echo $lokpoliklinik->Nama_Poliklinik->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokpoliklinik_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokpoliklinik_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokpoliklinik_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokpoliklinik_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokpoliklinik_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokpoliklinik_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokpoliklinik_add->terminate();
?>