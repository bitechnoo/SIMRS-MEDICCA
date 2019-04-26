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
$lokpegawai_view = new lokpegawai_view();

// Run the page
$lokpegawai_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpegawai_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokpegawai->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var flokpegawaiview = currentForm = new ew.Form("flokpegawaiview", "view");

// Form_CustomValidate event
flokpegawaiview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpegawaiview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokpegawai->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $lokpegawai_view->ExportOptions->render("body") ?>
<?php $lokpegawai_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $lokpegawai_view->showPageHeader(); ?>
<?php
$lokpegawai_view->showMessage();
?>
<form name="flokpegawaiview" id="flokpegawaiview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpegawai_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpegawai_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpegawai">
<input type="hidden" name="modal" value="<?php echo (int)$lokpegawai_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
	<tr id="r_Id_Pegawai">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Id_Pegawai"><?php echo $lokpegawai->Id_Pegawai->caption() ?></span></td>
		<td data-name="Id_Pegawai"<?php echo $lokpegawai->Id_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Id_Pegawai">
<span<?php echo $lokpegawai->Id_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Id_Pegawai->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
	<tr id="r_Nama_Pegawai">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Nama_Pegawai"><?php echo $lokpegawai->Nama_Pegawai->caption() ?></span></td>
		<td data-name="Nama_Pegawai"<?php echo $lokpegawai->Nama_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Nama_Pegawai">
<span<?php echo $lokpegawai->Nama_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Nama_Pegawai->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
	<tr id="r_NIK">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_NIK"><?php echo $lokpegawai->NIK->caption() ?></span></td>
		<td data-name="NIK"<?php echo $lokpegawai->NIK->cellAttributes() ?>>
<span id="el_lokpegawai_NIK">
<span<?php echo $lokpegawai->NIK->viewAttributes() ?>>
<?php echo $lokpegawai->NIK->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
	<tr id="r_Unit">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Unit"><?php echo $lokpegawai->Unit->caption() ?></span></td>
		<td data-name="Unit"<?php echo $lokpegawai->Unit->cellAttributes() ?>>
<span id="el_lokpegawai_Unit">
<span<?php echo $lokpegawai->Unit->viewAttributes() ?>>
<?php echo $lokpegawai->Unit->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
	<tr id="r_Jenis_Pegawai">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Jenis_Pegawai"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?></span></td>
		<td data-name="Jenis_Pegawai"<?php echo $lokpegawai->Jenis_Pegawai->cellAttributes() ?>>
<span id="el_lokpegawai_Jenis_Pegawai">
<span<?php echo $lokpegawai->Jenis_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Jenis_Pegawai->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Username->Visible) { // Username ?>
	<tr id="r_Username">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Username"><?php echo $lokpegawai->Username->caption() ?></span></td>
		<td data-name="Username"<?php echo $lokpegawai->Username->cellAttributes() ?>>
<span id="el_lokpegawai_Username">
<span<?php echo $lokpegawai->Username->viewAttributes() ?>>
<?php echo $lokpegawai->Username->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Password->Visible) { // Password ?>
	<tr id="r_Password">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Password"><?php echo $lokpegawai->Password->caption() ?></span></td>
		<td data-name="Password"<?php echo $lokpegawai->Password->cellAttributes() ?>>
<span id="el_lokpegawai_Password">
<span<?php echo $lokpegawai->Password->viewAttributes() ?>>
<?php echo $lokpegawai->Password->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
	<tr id="r_Userlevel">
		<td class="<?php echo $lokpegawai_view->TableLeftColumnClass ?>"><span id="elh_lokpegawai_Userlevel"><?php echo $lokpegawai->Userlevel->caption() ?></span></td>
		<td data-name="Userlevel"<?php echo $lokpegawai->Userlevel->cellAttributes() ?>>
<span id="el_lokpegawai_Userlevel">
<span<?php echo $lokpegawai->Userlevel->viewAttributes() ?>>
<?php echo $lokpegawai->Userlevel->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$lokpegawai_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokpegawai->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokpegawai_view->terminate();
?>