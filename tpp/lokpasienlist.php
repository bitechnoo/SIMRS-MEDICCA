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
$lokpasien_list = new lokpasien_list();

// Run the page
$lokpasien_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpasien_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokpasien->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokpasienlist = currentForm = new ew.Form("flokpasienlist", "list");
flokpasienlist.formKeyCountName = '<?php echo $lokpasien_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokpasienlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpasienlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokpasienlist.lists["x_Jenis_Kelamin"] = <?php echo $lokpasien_list->Jenis_Kelamin->Lookup->toClientList() ?>;
flokpasienlist.lists["x_Jenis_Kelamin"].options = <?php echo JsonEncode($lokpasien_list->Jenis_Kelamin->options(FALSE, TRUE)) ?>;
flokpasienlist.lists["x_Id_Kelurahan"] = <?php echo $lokpasien_list->Id_Kelurahan->Lookup->toClientList() ?>;
flokpasienlist.lists["x_Id_Kelurahan"].options = <?php echo JsonEncode($lokpasien_list->Id_Kelurahan->lookupOptions()) ?>;
flokpasienlist.lists["x_Agama"] = <?php echo $lokpasien_list->Agama->Lookup->toClientList() ?>;
flokpasienlist.lists["x_Agama"].options = <?php echo JsonEncode($lokpasien_list->Agama->options(FALSE, TRUE)) ?>;

// Form object for search
var flokpasienlistsrch = currentSearchForm = new ew.Form("flokpasienlistsrch");

// Filters
flokpasienlistsrch.filterList = <?php echo $lokpasien_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokpasien->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokpasien_list->TotalRecs > 0 && $lokpasien_list->ExportOptions->visible()) { ?>
<?php $lokpasien_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpasien_list->ImportOptions->visible()) { ?>
<?php $lokpasien_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpasien_list->SearchOptions->visible()) { ?>
<?php $lokpasien_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokpasien_list->FilterOptions->visible()) { ?>
<?php $lokpasien_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokpasien_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokpasien->isExport() && !$lokpasien->CurrentAction) { ?>
<form name="flokpasienlistsrch" id="flokpasienlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokpasien_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokpasienlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokpasien">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokpasien_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokpasien_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokpasien_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokpasien_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokpasien_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokpasien_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokpasien_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokpasien_list->showPageHeader(); ?>
<?php
$lokpasien_list->showMessage();
?>
<?php if ($lokpasien_list->TotalRecs > 0 || $lokpasien->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokpasien_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokpasien">
<?php if (!$lokpasien->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokpasien->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokpasien_list->Pager)) $lokpasien_list->Pager = new PrevNextPager($lokpasien_list->StartRec, $lokpasien_list->DisplayRecs, $lokpasien_list->TotalRecs, $lokpasien_list->AutoHidePager) ?>
<?php if ($lokpasien_list->Pager->RecordCount > 0 && $lokpasien_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokpasien_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokpasien_list->pageUrl() ?>start=<?php echo $lokpasien_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokpasien_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokpasien_list->pageUrl() ?>start=<?php echo $lokpasien_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokpasien_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokpasien_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokpasien_list->pageUrl() ?>start=<?php echo $lokpasien_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokpasien_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokpasien_list->pageUrl() ?>start=<?php echo $lokpasien_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokpasien_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokpasien_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokpasien_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokpasien_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokpasien_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokpasien_list->TotalRecs > 0 && (!$lokpasien_list->AutoHidePageSizeSelector || $lokpasien_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokpasien">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokpasien_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokpasien_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokpasien_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokpasien_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokpasien_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokpasien_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokpasien_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokpasien->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokpasien_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokpasienlist" id="flokpasienlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpasien_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpasien_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpasien">
<div id="gmp_lokpasien" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokpasien_list->TotalRecs > 0 || $lokpasien->isGridEdit()) { ?>
<table id="tbl_lokpasienlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokpasien_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokpasien_list->renderListOptions();

// Render list options (header, left)
$lokpasien_list->ListOptions->render("header", "left");
?>
<?php if ($lokpasien->No_RM->Visible) { // No_RM ?>
	<?php if ($lokpasien->sortUrl($lokpasien->No_RM) == "") { ?>
		<th data-name="No_RM" class="<?php echo $lokpasien->No_RM->headerCellClass() ?>"><div id="elh_lokpasien_No_RM" class="lokpasien_No_RM"><div class="ew-table-header-caption"><?php echo $lokpasien->No_RM->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_RM" class="<?php echo $lokpasien->No_RM->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->No_RM) ?>',2);"><div id="elh_lokpasien_No_RM" class="lokpasien_No_RM">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->No_RM->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->No_RM->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->No_RM->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Nama_Pasien->Visible) { // Nama_Pasien ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Nama_Pasien) == "") { ?>
		<th data-name="Nama_Pasien" class="<?php echo $lokpasien->Nama_Pasien->headerCellClass() ?>"><div id="elh_lokpasien_Nama_Pasien" class="lokpasien_Nama_Pasien"><div class="ew-table-header-caption"><?php echo $lokpasien->Nama_Pasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Pasien" class="<?php echo $lokpasien->Nama_Pasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Nama_Pasien) ?>',2);"><div id="elh_lokpasien_Nama_Pasien" class="lokpasien_Nama_Pasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Nama_Pasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Nama_Pasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Nama_Pasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->No_BPJS->Visible) { // No_BPJS ?>
	<?php if ($lokpasien->sortUrl($lokpasien->No_BPJS) == "") { ?>
		<th data-name="No_BPJS" class="<?php echo $lokpasien->No_BPJS->headerCellClass() ?>"><div id="elh_lokpasien_No_BPJS" class="lokpasien_No_BPJS"><div class="ew-table-header-caption"><?php echo $lokpasien->No_BPJS->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_BPJS" class="<?php echo $lokpasien->No_BPJS->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->No_BPJS) ?>',2);"><div id="elh_lokpasien_No_BPJS" class="lokpasien_No_BPJS">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->No_BPJS->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->No_BPJS->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->No_BPJS->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->No_KTP->Visible) { // No_KTP ?>
	<?php if ($lokpasien->sortUrl($lokpasien->No_KTP) == "") { ?>
		<th data-name="No_KTP" class="<?php echo $lokpasien->No_KTP->headerCellClass() ?>"><div id="elh_lokpasien_No_KTP" class="lokpasien_No_KTP"><div class="ew-table-header-caption"><?php echo $lokpasien->No_KTP->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_KTP" class="<?php echo $lokpasien->No_KTP->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->No_KTP) ?>',2);"><div id="elh_lokpasien_No_KTP" class="lokpasien_No_KTP">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->No_KTP->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->No_KTP->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->No_KTP->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Tempat_Lahir->Visible) { // Tempat_Lahir ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Tempat_Lahir) == "") { ?>
		<th data-name="Tempat_Lahir" class="<?php echo $lokpasien->Tempat_Lahir->headerCellClass() ?>"><div id="elh_lokpasien_Tempat_Lahir" class="lokpasien_Tempat_Lahir"><div class="ew-table-header-caption"><?php echo $lokpasien->Tempat_Lahir->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tempat_Lahir" class="<?php echo $lokpasien->Tempat_Lahir->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Tempat_Lahir) ?>',2);"><div id="elh_lokpasien_Tempat_Lahir" class="lokpasien_Tempat_Lahir">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Tempat_Lahir->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Tempat_Lahir->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Tempat_Lahir->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Tgl_Lahir) == "") { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $lokpasien->Tgl_Lahir->headerCellClass() ?>"><div id="elh_lokpasien_Tgl_Lahir" class="lokpasien_Tgl_Lahir"><div class="ew-table-header-caption"><?php echo $lokpasien->Tgl_Lahir->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $lokpasien->Tgl_Lahir->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Tgl_Lahir) ?>',2);"><div id="elh_lokpasien_Tgl_Lahir" class="lokpasien_Tgl_Lahir">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Tgl_Lahir->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Tgl_Lahir->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Tgl_Lahir->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Jenis_Kelamin) == "") { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $lokpasien->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_lokpasien_Jenis_Kelamin" class="lokpasien_Jenis_Kelamin"><div class="ew-table-header-caption"><?php echo $lokpasien->Jenis_Kelamin->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $lokpasien->Jenis_Kelamin->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Jenis_Kelamin) ?>',2);"><div id="elh_lokpasien_Jenis_Kelamin" class="lokpasien_Jenis_Kelamin">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Jenis_Kelamin->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Jenis_Kelamin->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Jenis_Kelamin->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Alamat->Visible) { // Alamat ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Alamat) == "") { ?>
		<th data-name="Alamat" class="<?php echo $lokpasien->Alamat->headerCellClass() ?>"><div id="elh_lokpasien_Alamat" class="lokpasien_Alamat"><div class="ew-table-header-caption"><?php echo $lokpasien->Alamat->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alamat" class="<?php echo $lokpasien->Alamat->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Alamat) ?>',2);"><div id="elh_lokpasien_Alamat" class="lokpasien_Alamat">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Alamat->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Alamat->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Alamat->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Id_Kelurahan) == "") { ?>
		<th data-name="Id_Kelurahan" class="<?php echo $lokpasien->Id_Kelurahan->headerCellClass() ?>"><div id="elh_lokpasien_Id_Kelurahan" class="lokpasien_Id_Kelurahan"><div class="ew-table-header-caption"><?php echo $lokpasien->Id_Kelurahan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Kelurahan" class="<?php echo $lokpasien->Id_Kelurahan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Id_Kelurahan) ?>',2);"><div id="elh_lokpasien_Id_Kelurahan" class="lokpasien_Id_Kelurahan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Id_Kelurahan->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Id_Kelurahan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Id_Kelurahan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpasien->Agama->Visible) { // Agama ?>
	<?php if ($lokpasien->sortUrl($lokpasien->Agama) == "") { ?>
		<th data-name="Agama" class="<?php echo $lokpasien->Agama->headerCellClass() ?>"><div id="elh_lokpasien_Agama" class="lokpasien_Agama"><div class="ew-table-header-caption"><?php echo $lokpasien->Agama->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Agama" class="<?php echo $lokpasien->Agama->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpasien->SortUrl($lokpasien->Agama) ?>',2);"><div id="elh_lokpasien_Agama" class="lokpasien_Agama">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpasien->Agama->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokpasien->Agama->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpasien->Agama->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokpasien_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokpasien->ExportAll && $lokpasien->isExport()) {
	$lokpasien_list->StopRec = $lokpasien_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokpasien_list->TotalRecs > $lokpasien_list->StartRec + $lokpasien_list->DisplayRecs - 1)
		$lokpasien_list->StopRec = $lokpasien_list->StartRec + $lokpasien_list->DisplayRecs - 1;
	else
		$lokpasien_list->StopRec = $lokpasien_list->TotalRecs;
}
$lokpasien_list->RecCnt = $lokpasien_list->StartRec - 1;
if ($lokpasien_list->Recordset && !$lokpasien_list->Recordset->EOF) {
	$lokpasien_list->Recordset->moveFirst();
	$selectLimit = $lokpasien_list->UseSelectLimit;
	if (!$selectLimit && $lokpasien_list->StartRec > 1)
		$lokpasien_list->Recordset->move($lokpasien_list->StartRec - 1);
} elseif (!$lokpasien->AllowAddDeleteRow && $lokpasien_list->StopRec == 0) {
	$lokpasien_list->StopRec = $lokpasien->GridAddRowCount;
}

// Initialize aggregate
$lokpasien->RowType = ROWTYPE_AGGREGATEINIT;
$lokpasien->resetAttributes();
$lokpasien_list->renderRow();
while ($lokpasien_list->RecCnt < $lokpasien_list->StopRec) {
	$lokpasien_list->RecCnt++;
	if ($lokpasien_list->RecCnt >= $lokpasien_list->StartRec) {
		$lokpasien_list->RowCnt++;

		// Set up key count
		$lokpasien_list->KeyCount = $lokpasien_list->RowIndex;

		// Init row class and style
		$lokpasien->resetAttributes();
		$lokpasien->CssClass = "";
		if ($lokpasien->isGridAdd()) {
		} else {
			$lokpasien_list->loadRowValues($lokpasien_list->Recordset); // Load row values
		}
		$lokpasien->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokpasien->RowAttrs = array_merge($lokpasien->RowAttrs, array('data-rowindex'=>$lokpasien_list->RowCnt, 'id'=>'r' . $lokpasien_list->RowCnt . '_lokpasien', 'data-rowtype'=>$lokpasien->RowType));

		// Render row
		$lokpasien_list->renderRow();

		// Render list options
		$lokpasien_list->renderListOptions();
?>
	<tr<?php echo $lokpasien->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokpasien_list->ListOptions->render("body", "left", $lokpasien_list->RowCnt);
?>
	<?php if ($lokpasien->No_RM->Visible) { // No_RM ?>
		<td data-name="No_RM"<?php echo $lokpasien->No_RM->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_No_RM" class="lokpasien_No_RM">
<span<?php echo $lokpasien->No_RM->viewAttributes() ?>>
<?php echo $lokpasien->No_RM->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td data-name="Nama_Pasien"<?php echo $lokpasien->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Nama_Pasien" class="lokpasien_Nama_Pasien">
<span<?php echo $lokpasien->Nama_Pasien->viewAttributes() ?>>
<?php echo $lokpasien->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->No_BPJS->Visible) { // No_BPJS ?>
		<td data-name="No_BPJS"<?php echo $lokpasien->No_BPJS->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_No_BPJS" class="lokpasien_No_BPJS">
<span<?php echo $lokpasien->No_BPJS->viewAttributes() ?>>
<?php echo $lokpasien->No_BPJS->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->No_KTP->Visible) { // No_KTP ?>
		<td data-name="No_KTP"<?php echo $lokpasien->No_KTP->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_No_KTP" class="lokpasien_No_KTP">
<span<?php echo $lokpasien->No_KTP->viewAttributes() ?>>
<?php echo $lokpasien->No_KTP->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Tempat_Lahir->Visible) { // Tempat_Lahir ?>
		<td data-name="Tempat_Lahir"<?php echo $lokpasien->Tempat_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Tempat_Lahir" class="lokpasien_Tempat_Lahir">
<span<?php echo $lokpasien->Tempat_Lahir->viewAttributes() ?>>
<?php echo $lokpasien->Tempat_Lahir->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td data-name="Tgl_Lahir"<?php echo $lokpasien->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Tgl_Lahir" class="lokpasien_Tgl_Lahir">
<span<?php echo $lokpasien->Tgl_Lahir->viewAttributes() ?>>
<?php echo $lokpasien->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td data-name="Jenis_Kelamin"<?php echo $lokpasien->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Jenis_Kelamin" class="lokpasien_Jenis_Kelamin">
<span<?php echo $lokpasien->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $lokpasien->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Alamat->Visible) { // Alamat ?>
		<td data-name="Alamat"<?php echo $lokpasien->Alamat->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Alamat" class="lokpasien_Alamat">
<span<?php echo $lokpasien->Alamat->viewAttributes() ?>>
<?php echo $lokpasien->Alamat->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Id_Kelurahan->Visible) { // Id_Kelurahan ?>
		<td data-name="Id_Kelurahan"<?php echo $lokpasien->Id_Kelurahan->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Id_Kelurahan" class="lokpasien_Id_Kelurahan">
<span<?php echo $lokpasien->Id_Kelurahan->viewAttributes() ?>>
<?php echo $lokpasien->Id_Kelurahan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpasien->Agama->Visible) { // Agama ?>
		<td data-name="Agama"<?php echo $lokpasien->Agama->cellAttributes() ?>>
<span id="el<?php echo $lokpasien_list->RowCnt ?>_lokpasien_Agama" class="lokpasien_Agama">
<span<?php echo $lokpasien->Agama->viewAttributes() ?>>
<?php echo $lokpasien->Agama->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokpasien_list->ListOptions->render("body", "right", $lokpasien_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokpasien->isGridAdd())
		$lokpasien_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokpasien->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokpasien_list->Recordset)
	$lokpasien_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokpasien_list->TotalRecs == 0 && !$lokpasien->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokpasien_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokpasien_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokpasien->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokpasien_list->terminate();
?>