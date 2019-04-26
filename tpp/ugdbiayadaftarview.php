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
$ugdbiayadaftar_view = new ugdbiayadaftar_view();

// Run the page
$ugdbiayadaftar_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugdbiayadaftar_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fugdbiayadaftarview = currentForm = new ew.Form("fugdbiayadaftarview", "view");

// Form_CustomValidate event
fugdbiayadaftarview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugdbiayadaftarview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $ugdbiayadaftar_view->ExportOptions->render("body") ?>
<?php $ugdbiayadaftar_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ugdbiayadaftar_view->showPageHeader(); ?>
<?php
$ugdbiayadaftar_view->showMessage();
?>
<form name="fugdbiayadaftarview" id="fugdbiayadaftarview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugdbiayadaftar_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugdbiayadaftar_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugdbiayadaftar">
<input type="hidden" name="modal" value="<?php echo (int)$ugdbiayadaftar_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
	<tr id="r_Id_Biayadaftar">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Id_Biayadaftar"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?></span></td>
		<td data-name="Id_Biayadaftar"<?php echo $ugdbiayadaftar->Id_Biayadaftar->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Id_Biayadaftar">
<span<?php echo $ugdbiayadaftar->Id_Biayadaftar->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
	<tr id="r_Nama_Biaya">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Nama_Biaya"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?></span></td>
		<td data-name="Nama_Biaya"<?php echo $ugdbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Nama_Biaya">
<span<?php echo $ugdbiayadaftar->Nama_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Nama_Biaya->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
	<tr id="r_Jasa_Dokter">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Dokter"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?></span></td>
		<td data-name="Jasa_Dokter"<?php echo $ugdbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Dokter">
<span<?php echo $ugdbiayadaftar->Jasa_Dokter->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Dokter->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
	<tr id="r_Jasa_Layanan">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Layanan"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?></span></td>
		<td data-name="Jasa_Layanan"<?php echo $ugdbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Layanan">
<span<?php echo $ugdbiayadaftar->Jasa_Layanan->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Layanan->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
	<tr id="r_Jasa_Sarana">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Jasa_Sarana"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?></span></td>
		<td data-name="Jasa_Sarana"<?php echo $ugdbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Jasa_Sarana">
<span<?php echo $ugdbiayadaftar->Jasa_Sarana->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Sarana->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<tr id="r_Total_Biaya">
		<td class="<?php echo $ugdbiayadaftar_view->TableLeftColumnClass ?>"><span id="elh_ugdbiayadaftar_Total_Biaya"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?></span></td>
		<td data-name="Total_Biaya"<?php echo $ugdbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el_ugdbiayadaftar_Total_Biaya">
<span<?php echo $ugdbiayadaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$ugdbiayadaftar_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ugdbiayadaftar_view->terminate();
?>