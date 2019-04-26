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
$lokbiayadaftar_add = new lokbiayadaftar_add();

// Run the page
$lokbiayadaftar_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokbiayadaftar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flokbiayadaftaradd = currentForm = new ew.Form("flokbiayadaftaradd", "add");

// Validate form
flokbiayadaftaradd.validate = function() {
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
		<?php if ($lokbiayadaftar_add->Id_Biayadaftar->Required) { ?>
			elm = this.getElements("x" + infix + "_Id_Biayadaftar");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Id_Biayadaftar->caption(), $lokbiayadaftar->Id_Biayadaftar->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokbiayadaftar_add->Nama_Biaya->Required) { ?>
			elm = this.getElements("x" + infix + "_Nama_Biaya");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Nama_Biaya->caption(), $lokbiayadaftar->Nama_Biaya->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($lokbiayadaftar_add->Jasa_Dokter->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Dokter->caption(), $lokbiayadaftar->Jasa_Dokter->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Dokter");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Dokter->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_add->Jasa_Layanan->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Layanan->caption(), $lokbiayadaftar->Jasa_Layanan->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Layanan");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Layanan->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_add->Jasa_Sarana->Required) { ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $lokbiayadaftar->Jasa_Sarana->caption(), $lokbiayadaftar->Jasa_Sarana->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_Jasa_Sarana");
			if (elm && !ew.checkNumber(elm.value))
				return this.onError(elm, "<?php echo JsEncode($lokbiayadaftar->Jasa_Sarana->errorMessage()) ?>");
		<?php if ($lokbiayadaftar_add->Total_Biaya->Required) { ?>
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
flokbiayadaftaradd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokbiayadaftaradd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokbiayadaftar_add->showPageHeader(); ?>
<?php
$lokbiayadaftar_add->showMessage();
?>
<form name="flokbiayadaftaradd" id="flokbiayadaftaradd" class="<?php echo $lokbiayadaftar_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokbiayadaftar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokbiayadaftar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokbiayadaftar">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$lokbiayadaftar_add->IsModal ?>">
<?php if (!$lokbiayadaftar_add->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokbiayadaftaradd" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Nama_Biaya" class="form-group row">
		<label id="elh_lokbiayadaftar_Nama_Biaya" for="x_Nama_Biaya" class="<?php echo $lokbiayadaftar_add->LeftColumnClass ?>"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?><?php echo ($lokbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokbiayadaftar_add->RightColumnClass ?>"><div<?php echo $lokbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Nama_Biaya">
<input type="text" data-table="lokbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="60" maxlength="75" value="<?php echo $lokbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Nama_Biaya->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Nama_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_Biaya">
		<td class="<?php echo $lokbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_lokbiayadaftar_Nama_Biaya"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?><?php echo ($lokbiayadaftar->Nama_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Nama_Biaya">
<input type="text" data-table="lokbiayadaftar" data-field="x_Nama_Biaya" name="x_Nama_Biaya" id="x_Nama_Biaya" size="60" maxlength="75" value="<?php echo $lokbiayadaftar->Nama_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Nama_Biaya->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Nama_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Dokter" class="form-group row">
		<label id="elh_lokbiayadaftar_Jasa_Dokter" for="x_Jasa_Dokter" class="<?php echo $lokbiayadaftar_add->LeftColumnClass ?>"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($lokbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokbiayadaftar_add->RightColumnClass ?>"><div<?php echo $lokbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Dokter">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $lokbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Dokter->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Dokter->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Dokter">
		<td class="<?php echo $lokbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_lokbiayadaftar_Jasa_Dokter"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?><?php echo ($lokbiayadaftar->Jasa_Dokter->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Dokter">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Dokter" name="x_Jasa_Dokter" id="x_Jasa_Dokter" size="30" value="<?php echo $lokbiayadaftar->Jasa_Dokter->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Dokter->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Dokter->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Layanan" class="form-group row">
		<label id="elh_lokbiayadaftar_Jasa_Layanan" for="x_Jasa_Layanan" class="<?php echo $lokbiayadaftar_add->LeftColumnClass ?>"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($lokbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokbiayadaftar_add->RightColumnClass ?>"><div<?php echo $lokbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Layanan">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $lokbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Layanan->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Layanan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Layanan">
		<td class="<?php echo $lokbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_lokbiayadaftar_Jasa_Layanan"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?><?php echo ($lokbiayadaftar->Jasa_Layanan->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Layanan">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Layanan" name="x_Jasa_Layanan" id="x_Jasa_Layanan" size="30" value="<?php echo $lokbiayadaftar->Jasa_Layanan->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Layanan->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Layanan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Jasa_Sarana" class="form-group row">
		<label id="elh_lokbiayadaftar_Jasa_Sarana" for="x_Jasa_Sarana" class="<?php echo $lokbiayadaftar_add->LeftColumnClass ?>"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($lokbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokbiayadaftar_add->RightColumnClass ?>"><div<?php echo $lokbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Sarana">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $lokbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Sarana->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Sarana->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jasa_Sarana">
		<td class="<?php echo $lokbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_lokbiayadaftar_Jasa_Sarana"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?><?php echo ($lokbiayadaftar->Jasa_Sarana->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Jasa_Sarana">
<input type="text" data-table="lokbiayadaftar" data-field="x_Jasa_Sarana" name="x_Jasa_Sarana" id="x_Jasa_Sarana" size="30" value="<?php echo $lokbiayadaftar->Jasa_Sarana->EditValue ?>"<?php echo $lokbiayadaftar->Jasa_Sarana->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Jasa_Sarana->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
	<div id="r_Total_Biaya" class="form-group row">
		<label id="elh_lokbiayadaftar_Total_Biaya" for="x_Total_Biaya" class="<?php echo $lokbiayadaftar_add->LeftColumnClass ?>"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?><?php echo ($lokbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $lokbiayadaftar_add->RightColumnClass ?>"><div<?php echo $lokbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Total_Biaya">
<input type="text" data-table="lokbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $lokbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Total_Biaya->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Total_Biaya->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Total_Biaya">
		<td class="<?php echo $lokbiayadaftar_add->TableLeftColumnClass ?>"><span id="elh_lokbiayadaftar_Total_Biaya"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?><?php echo ($lokbiayadaftar->Total_Biaya->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
		<td<?php echo $lokbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el_lokbiayadaftar_Total_Biaya">
<input type="text" data-table="lokbiayadaftar" data-field="x_Total_Biaya" name="x_Total_Biaya" id="x_Total_Biaya" size="30" value="<?php echo $lokbiayadaftar->Total_Biaya->EditValue ?>"<?php echo $lokbiayadaftar->Total_Biaya->editAttributes() ?>>
</span>
<?php echo $lokbiayadaftar->Total_Biaya->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokbiayadaftar_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokbiayadaftar_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $lokbiayadaftar_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokbiayadaftar_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokbiayadaftar_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

$(document).ready(function() {
	$("#x_Jasa_Dokter, #x_Jasa_Layanan, #x_Jasa_Sarana").keyup(function() {
	   $("#x_Total_Biaya").val(eval($("#x_Jasa_Dokter").val()) + eval($("#x_Jasa_Layanan").val()) + eval($("#x_Jasa_Sarana").val()));    
	}); 
});
</script>
<?php include_once "footer.php" ?>
<?php
$lokbiayadaftar_add->terminate();
?>