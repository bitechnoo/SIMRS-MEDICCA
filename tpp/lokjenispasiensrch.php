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
$lokjenispasien_search = new lokjenispasien_search();

// Run the page
$lokjenispasien_search->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokjenispasien_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "search";
<?php if ($lokjenispasien_search->IsModal) { ?>
var flokjenispasiensearch = currentAdvancedSearchForm = new ew.Form("flokjenispasiensearch", "search");
<?php } else { ?>
var flokjenispasiensearch = currentForm = new ew.Form("flokjenispasiensearch", "search");
<?php } ?>

// Form_CustomValidate event
flokjenispasiensearch.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokjenispasiensearch.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search
// Validate function for search

flokjenispasiensearch.validate = function(fobj) {
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
<?php $lokjenispasien_search->showPageHeader(); ?>
<?php
$lokjenispasien_search->showMessage();
?>
<form name="flokjenispasiensearch" id="flokjenispasiensearch" class="<?php echo $lokjenispasien_search->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokjenispasien_search->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokjenispasien_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokjenispasien">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?php echo (int)$lokjenispasien_search->IsModal ?>">
<?php if (!$lokjenispasien_search->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($lokjenispasien_search->IsMobileOrModal) { ?>
<div class="ew-search-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_lokjenispasiensearch" class="table table-striped table-sm ew-desktop-table"><!-- table* -->
<?php } ?>
<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
<?php if ($lokjenispasien_search->IsMobileOrModal) { ?>
	<div id="r_Id_JenisPasien" class="form-group row">
		<label for="x_Id_JenisPasien" class="<?php echo $lokjenispasien_search->LeftColumnClass ?>"><span id="elh_lokjenispasien_Id_JenisPasien"><?php echo $lokjenispasien->Id_JenisPasien->caption() ?></span>
		<span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Id_JenisPasien" id="z_Id_JenisPasien" value="LIKE"></span>
		</label>
		<div class="<?php echo $lokjenispasien_search->RightColumnClass ?>"><div<?php echo $lokjenispasien->Id_JenisPasien->cellAttributes() ?>>
			<span id="el_lokjenispasien_Id_JenisPasien">
<input type="text" data-table="lokjenispasien" data-field="x_Id_JenisPasien" name="x_Id_JenisPasien" id="x_Id_JenisPasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Id_JenisPasien->EditValue ?>"<?php echo $lokjenispasien->Id_JenisPasien->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_Id_JenisPasien">
		<td class="<?php echo $lokjenispasien_search->TableLeftColumnClass ?>"><span id="elh_lokjenispasien_Id_JenisPasien"><?php echo $lokjenispasien->Id_JenisPasien->caption() ?></span></td>
		<td class="w-col-1"><span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Id_JenisPasien" id="z_Id_JenisPasien" value="LIKE"></span></td>
		<td<?php echo $lokjenispasien->Id_JenisPasien->cellAttributes() ?>>
			<div class="text-nowrap">
				<span id="el_lokjenispasien_Id_JenisPasien">
<input type="text" data-table="lokjenispasien" data-field="x_Id_JenisPasien" name="x_Id_JenisPasien" id="x_Id_JenisPasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Id_JenisPasien->EditValue ?>"<?php echo $lokjenispasien->Id_JenisPasien->editAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
<?php if ($lokjenispasien_search->IsMobileOrModal) { ?>
	<div id="r_Jenis_Pasien" class="form-group row">
		<label for="x_Jenis_Pasien" class="<?php echo $lokjenispasien_search->LeftColumnClass ?>"><span id="elh_lokjenispasien_Jenis_Pasien"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?></span>
		<span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Jenis_Pasien" id="z_Jenis_Pasien" value="LIKE"></span>
		</label>
		<div class="<?php echo $lokjenispasien_search->RightColumnClass ?>"><div<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
			<span id="el_lokjenispasien_Jenis_Pasien">
<input type="text" data-table="lokjenispasien" data-field="x_Jenis_Pasien" name="x_Jenis_Pasien" id="x_Jenis_Pasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Jenis_Pasien->EditValue ?>"<?php echo $lokjenispasien->Jenis_Pasien->editAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } else { ?>
	<tr id="r_Jenis_Pasien">
		<td class="<?php echo $lokjenispasien_search->TableLeftColumnClass ?>"><span id="elh_lokjenispasien_Jenis_Pasien"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?></span></td>
		<td class="w-col-1"><span class="ew-search-operator"><?php echo $Language->phrase("LIKE") ?><input type="hidden" name="z_Jenis_Pasien" id="z_Jenis_Pasien" value="LIKE"></span></td>
		<td<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
			<div class="text-nowrap">
				<span id="el_lokjenispasien_Jenis_Pasien">
<input type="text" data-table="lokjenispasien" data-field="x_Jenis_Pasien" name="x_Jenis_Pasien" id="x_Jenis_Pasien" size="30" maxlength="50" value="<?php echo $lokjenispasien->Jenis_Pasien->EditValue ?>"<?php echo $lokjenispasien->Jenis_Pasien->editAttributes() ?>>
</span>
			</div>
		</td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($lokjenispasien_search->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$lokjenispasien_search->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $lokjenispasien_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("Search") ?></button>
<button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" onclick="ew.clearForm(this.form);"><?php echo $Language->phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$lokjenispasien_search->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<?php
$lokjenispasien_search->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lokjenispasien_search->terminate();
?>