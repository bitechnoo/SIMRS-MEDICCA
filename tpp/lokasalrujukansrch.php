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
$lokasalrujukan_search = new lokasalrujukan_search();

// Run the page
$lokasalrujukan_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokasalrujukan_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "search";
<?php if ($lokasalrujukan_search->IsModal) { ?>
var flokasalrujukansearch = currentAdvancedSearchForm = new ew.Form("flokasalrujukansearch", "search");
<?php } else { ?>
var flokasalrujukansearch = currentForm = new ew.Form("flokasalrujukansearch", "search");
<?php } ?>

// Form_CustomValidate event
flokasalrujukansearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokasalrujukansearch.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search
// Validate function for search

flokasalrujukansearch.validate = function(fobj) {
	if (!this.validateRequired)
		return true; // Ignore validation
	fobj = fobj || this._form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $lokasalrujukan_search->showPageHeader(); ?>
<?php
$lokasalrujukan_search->showMessage();
?>
<form name="flokasalrujukansearch" id="flokasalrujukansearch" class="<?php echo $lokasalrujukan_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokasalrujukan_search->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokasalrujukan_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokasalrujukan">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$lokasalrujukan_search->IsModal ?>">
<?php if (!$lokasalrujukan_search->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokasalrujukan_search->IsMobileOrModal) { ?>
<div class="ew-search-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokasalrujukansearch" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
<?php if ($lokasalrujukan_search->IsMobileOrModal) { ?>
	<div id="r_Id_Rujukan" class="form-group row">
		<label for="x_Id_Rujukan" class="<?php echo $lokasalrujukan_search->LeftColumnClass ?>"><span id="elh_lokasalrujukan_Id_Rujukan"><?php echo $lokasalrujukan->Id_Rujukan->caption() ?></span>
		<span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Id_Rujukan" id="z_Id_Rujukan" value="LIKE"></span>
		</label>
		<div class="<?php echo $lokasalrujukan_search->RightColumnClass ?>"><div<?php echo $lokasalrujukan->Id_Rujukan->cellAttributes() ?>>
			<span id="el_lokasalrujukan_Id_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Id_Rujukan" name="x_Id_Rujukan" id="x_Id_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Id_Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Id_Rujukan->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_Rujukan">
		<td class="<?php echo $lokasalrujukan_search->TableLeftColumnClass ?>"><span id="elh_lokasalrujukan_Id_Rujukan"><?php echo $lokasalrujukan->Id_Rujukan->caption() ?></span></td>
		<td class="w-col-1"><span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Id_Rujukan" id="z_Id_Rujukan" value="LIKE"></span></td>
		<td<?php echo $lokasalrujukan->Id_Rujukan->cellAttributes() ?>>
			<div class="text-nowrap">
				<span id="el_lokasalrujukan_Id_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Id_Rujukan" name="x_Id_Rujukan" id="x_Id_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Id_Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Id_Rujukan->editAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
<?php if ($lokasalrujukan_search->IsMobileOrModal) { ?>
	<div id="r_Rujukan" class="form-group row">
		<label for="x_Rujukan" class="<?php echo $lokasalrujukan_search->LeftColumnClass ?>"><span id="elh_lokasalrujukan_Rujukan"><?php echo $lokasalrujukan->Rujukan->caption() ?></span>
		<span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Rujukan" id="z_Rujukan" value="LIKE"></span>
		</label>
		<div class="<?php echo $lokasalrujukan_search->RightColumnClass ?>"><div<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
			<span id="el_lokasalrujukan_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Rujukan" name="x_Rujukan" id="x_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Rujukan->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_Rujukan">
		<td class="<?php echo $lokasalrujukan_search->TableLeftColumnClass ?>"><span id="elh_lokasalrujukan_Rujukan"><?php echo $lokasalrujukan->Rujukan->caption() ?></span></td>
		<td class="w-col-1"><span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Rujukan" id="z_Rujukan" value="LIKE"></span></td>
		<td<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
			<div class="text-nowrap">
				<span id="el_lokasalrujukan_Rujukan">
<input type="text" data-table="lokasalrujukan" data-field="x_Rujukan" name="x_Rujukan" id="x_Rujukan" size="30" maxlength="50" value="<?php echo $lokasalrujukan->Rujukan->EditValue ?>"<?php echo $lokasalrujukan->Rujukan->editAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokasalrujukan_search->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokasalrujukan_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokasalrujukan_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokasalrujukan_search->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokasalrujukan_search->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokasalrujukan_search->terminate();
?>