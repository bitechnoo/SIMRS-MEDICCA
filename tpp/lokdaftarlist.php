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
$lokdaftar_list = new lokdaftar_list();

// Run the page
$lokdaftar_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokdaftar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokdaftar->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokdaftarlist = currentForm = new ew.Form("flokdaftarlist", "list");
flokdaftarlist.formKeyCountName = '<?php echo $lokdaftar_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokdaftarlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokdaftarlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flokdaftarlist.lists["x_Id_Rujukan"] = <?php echo $lokdaftar_list->Id_Rujukan->Lookup->toClientList() ?>;
flokdaftarlist.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($lokdaftar_list->Id_Rujukan->lookupOptions()) ?>;
flokdaftarlist.lists["x_Id_JenisPasien"] = <?php echo $lokdaftar_list->Id_JenisPasien->Lookup->toClientList() ?>;
flokdaftarlist.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($lokdaftar_list->Id_JenisPasien->lookupOptions()) ?>;

// Form object for search
var flokdaftarlistsrch = currentSearchForm = new ew.Form("flokdaftarlistsrch");

// Filters
flokdaftarlistsrch.filterList = <?php echo $lokdaftar_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokdaftar->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokdaftar_list->TotalRecs > 0 && $lokdaftar_list->ExportOptions->visible()) { ?>
<?php $lokdaftar_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokdaftar_list->ImportOptions->visible()) { ?>
<?php $lokdaftar_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokdaftar_list->SearchOptions->visible()) { ?>
<?php $lokdaftar_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokdaftar_list->FilterOptions->visible()) { ?>
<?php $lokdaftar_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokdaftar_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokdaftar->isExport() && !$lokdaftar->CurrentAction) { ?>
<form name="flokdaftarlistsrch" id="flokdaftarlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokdaftar_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokdaftarlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokdaftar">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokdaftar_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokdaftar_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokdaftar_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokdaftar_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokdaftar_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokdaftar_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokdaftar_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokdaftar_list->showPageHeader(); ?>
<?php
$lokdaftar_list->showMessage();
?>
<?php if ($lokdaftar_list->TotalRecs > 0 || $lokdaftar->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokdaftar_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokdaftar">
<?php if (!$lokdaftar->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokdaftar->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokdaftar_list->Pager)) $lokdaftar_list->Pager = new PrevNextPager($lokdaftar_list->StartRec, $lokdaftar_list->DisplayRecs, $lokdaftar_list->TotalRecs, $lokdaftar_list->AutoHidePager) ?>
<?php if ($lokdaftar_list->Pager->RecordCount > 0 && $lokdaftar_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokdaftar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokdaftar_list->pageUrl() ?>start=<?php echo $lokdaftar_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokdaftar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokdaftar_list->pageUrl() ?>start=<?php echo $lokdaftar_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokdaftar_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokdaftar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokdaftar_list->pageUrl() ?>start=<?php echo $lokdaftar_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokdaftar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokdaftar_list->pageUrl() ?>start=<?php echo $lokdaftar_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokdaftar_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokdaftar_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokdaftar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokdaftar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokdaftar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokdaftar_list->TotalRecs > 0 && (!$lokdaftar_list->AutoHidePageSizeSelector || $lokdaftar_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokdaftar">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokdaftar_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokdaftar_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokdaftar_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokdaftar_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokdaftar_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokdaftar_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokdaftar_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokdaftar->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokdaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokdaftarlist" id="flokdaftarlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokdaftar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokdaftar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokdaftar">
<div id="gmp_lokdaftar" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokdaftar_list->TotalRecs > 0 || $lokdaftar->isGridEdit()) { ?>
<table id="tbl_lokdaftarlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokdaftar_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokdaftar_list->renderListOptions();

// Render list options (header, left)
$lokdaftar_list->ListOptions->render("header", "left");
?>
<?php if ($lokdaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Tgl_Daftar) == "") { ?>
		<th data-name="Tgl_Daftar" class="<?php echo $lokdaftar->Tgl_Daftar->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_lokdaftar_Tgl_Daftar" class="lokdaftar_Tgl_Daftar"><div class="ew-table-header-caption"><?php echo $lokdaftar->Tgl_Daftar->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tgl_Daftar" class="<?php echo $lokdaftar->Tgl_Daftar->headerCellClass() ?>" style="white-space: nowrap;"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Tgl_Daftar) ?>',2);"><div id="elh_lokdaftar_Tgl_Daftar" class="lokdaftar_Tgl_Daftar">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Tgl_Daftar->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Tgl_Daftar->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Tgl_Daftar->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Waktu->Visible) { // Waktu ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Waktu) == "") { ?>
		<th data-name="Waktu" class="<?php echo $lokdaftar->Waktu->headerCellClass() ?>"><div id="elh_lokdaftar_Waktu" class="lokdaftar_Waktu"><div class="ew-table-header-caption"><?php echo $lokdaftar->Waktu->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Waktu" class="<?php echo $lokdaftar->Waktu->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Waktu) ?>',2);"><div id="elh_lokdaftar_Waktu" class="lokdaftar_Waktu">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Waktu->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Waktu->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Waktu->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Nama_Pasien) == "") { ?>
		<th data-name="Nama_Pasien" class="<?php echo $lokdaftar->Nama_Pasien->headerCellClass() ?>"><div id="elh_lokdaftar_Nama_Pasien" class="lokdaftar_Nama_Pasien"><div class="ew-table-header-caption"><?php echo $lokdaftar->Nama_Pasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Pasien" class="<?php echo $lokdaftar->Nama_Pasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Nama_Pasien) ?>',2);"><div id="elh_lokdaftar_Nama_Pasien" class="lokdaftar_Nama_Pasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Nama_Pasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Nama_Pasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Nama_Pasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->No_RM->Visible) { // No_RM ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->No_RM) == "") { ?>
		<th data-name="No_RM" class="<?php echo $lokdaftar->No_RM->headerCellClass() ?>"><div id="elh_lokdaftar_No_RM" class="lokdaftar_No_RM"><div class="ew-table-header-caption"><?php echo $lokdaftar->No_RM->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_RM" class="<?php echo $lokdaftar->No_RM->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->No_RM) ?>',2);"><div id="elh_lokdaftar_No_RM" class="lokdaftar_No_RM">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->No_RM->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->No_RM->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->No_RM->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Tgl_Lahir) == "") { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $lokdaftar->Tgl_Lahir->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_lokdaftar_Tgl_Lahir" class="lokdaftar_Tgl_Lahir"><div class="ew-table-header-caption"><?php echo $lokdaftar->Tgl_Lahir->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $lokdaftar->Tgl_Lahir->headerCellClass() ?>" style="white-space: nowrap;"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Tgl_Lahir) ?>',2);"><div id="elh_lokdaftar_Tgl_Lahir" class="lokdaftar_Tgl_Lahir">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Tgl_Lahir->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Tgl_Lahir->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Tgl_Lahir->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Jenis_Kelamin) == "") { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $lokdaftar->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_lokdaftar_Jenis_Kelamin" class="lokdaftar_Jenis_Kelamin"><div class="ew-table-header-caption"><?php echo $lokdaftar->Jenis_Kelamin->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $lokdaftar->Jenis_Kelamin->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Jenis_Kelamin) ?>',2);"><div id="elh_lokdaftar_Jenis_Kelamin" class="lokdaftar_Jenis_Kelamin">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Jenis_Kelamin->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Jenis_Kelamin->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Jenis_Kelamin->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Alamat->Visible) { // Alamat ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Alamat) == "") { ?>
		<th data-name="Alamat" class="<?php echo $lokdaftar->Alamat->headerCellClass() ?>"><div id="elh_lokdaftar_Alamat" class="lokdaftar_Alamat"><div class="ew-table-header-caption"><?php echo $lokdaftar->Alamat->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alamat" class="<?php echo $lokdaftar->Alamat->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Alamat) ?>',2);"><div id="elh_lokdaftar_Alamat" class="lokdaftar_Alamat">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Alamat->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Alamat->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Alamat->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Poliklinik->Visible) { // Poliklinik ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Poliklinik) == "") { ?>
		<th data-name="Poliklinik" class="<?php echo $lokdaftar->Poliklinik->headerCellClass() ?>"><div id="elh_lokdaftar_Poliklinik" class="lokdaftar_Poliklinik"><div class="ew-table-header-caption"><?php echo $lokdaftar->Poliklinik->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Poliklinik" class="<?php echo $lokdaftar->Poliklinik->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Poliklinik) ?>',2);"><div id="elh_lokdaftar_Poliklinik" class="lokdaftar_Poliklinik">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Poliklinik->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Poliklinik->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Poliklinik->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Rawat->Visible) { // Rawat ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Rawat) == "") { ?>
		<th data-name="Rawat" class="<?php echo $lokdaftar->Rawat->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_lokdaftar_Rawat" class="lokdaftar_Rawat"><div class="ew-table-header-caption"><?php echo $lokdaftar->Rawat->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rawat" class="<?php echo $lokdaftar->Rawat->headerCellClass() ?>" style="white-space: nowrap;"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Rawat) ?>',2);"><div id="elh_lokdaftar_Rawat" class="lokdaftar_Rawat">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Rawat->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Rawat->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Rawat->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Id_Rujukan) == "") { ?>
		<th data-name="Id_Rujukan" class="<?php echo $lokdaftar->Id_Rujukan->headerCellClass() ?>"><div id="elh_lokdaftar_Id_Rujukan" class="lokdaftar_Id_Rujukan"><div class="ew-table-header-caption"><?php echo $lokdaftar->Id_Rujukan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Rujukan" class="<?php echo $lokdaftar->Id_Rujukan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Id_Rujukan) ?>',2);"><div id="elh_lokdaftar_Id_Rujukan" class="lokdaftar_Id_Rujukan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Id_Rujukan->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Id_Rujukan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Id_Rujukan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Id_JenisPasien) == "") { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $lokdaftar->Id_JenisPasien->headerCellClass() ?>"><div id="elh_lokdaftar_Id_JenisPasien" class="lokdaftar_Id_JenisPasien"><div class="ew-table-header-caption"><?php echo $lokdaftar->Id_JenisPasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $lokdaftar->Id_JenisPasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Id_JenisPasien) ?>',2);"><div id="elh_lokdaftar_Id_JenisPasien" class="lokdaftar_Id_JenisPasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Id_JenisPasien->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Id_JenisPasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Id_JenisPasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Lama_Baru->Visible) { // Lama_Baru ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Lama_Baru) == "") { ?>
		<th data-name="Lama_Baru" class="<?php echo $lokdaftar->Lama_Baru->headerCellClass() ?>"><div id="elh_lokdaftar_Lama_Baru" class="lokdaftar_Lama_Baru"><div class="ew-table-header-caption"><?php echo $lokdaftar->Lama_Baru->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Lama_Baru" class="<?php echo $lokdaftar->Lama_Baru->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Lama_Baru) ?>',2);"><div id="elh_lokdaftar_Lama_Baru" class="lokdaftar_Lama_Baru">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Lama_Baru->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Lama_Baru->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Lama_Baru->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Total_Biaya) == "") { ?>
		<th data-name="Total_Biaya" class="<?php echo $lokdaftar->Total_Biaya->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_lokdaftar_Total_Biaya" class="lokdaftar_Total_Biaya"><div class="ew-table-header-caption"><?php echo $lokdaftar->Total_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Biaya" class="<?php echo $lokdaftar->Total_Biaya->headerCellClass() ?>" style="white-space: nowrap;"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Total_Biaya) ?>',2);"><div id="elh_lokdaftar_Total_Biaya" class="lokdaftar_Total_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Total_Biaya->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Total_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Total_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokdaftar->Petugas->Visible) { // Petugas ?>
	<?php if ($lokdaftar->sortUrl($lokdaftar->Petugas) == "") { ?>
		<th data-name="Petugas" class="<?php echo $lokdaftar->Petugas->headerCellClass() ?>"><div id="elh_lokdaftar_Petugas" class="lokdaftar_Petugas"><div class="ew-table-header-caption"><?php echo $lokdaftar->Petugas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Petugas" class="<?php echo $lokdaftar->Petugas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokdaftar->SortUrl($lokdaftar->Petugas) ?>',2);"><div id="elh_lokdaftar_Petugas" class="lokdaftar_Petugas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokdaftar->Petugas->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokdaftar->Petugas->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokdaftar->Petugas->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokdaftar_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokdaftar->ExportAll && $lokdaftar->isExport()) {
	$lokdaftar_list->StopRec = $lokdaftar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokdaftar_list->TotalRecs > $lokdaftar_list->StartRec + $lokdaftar_list->DisplayRecs - 1)
		$lokdaftar_list->StopRec = $lokdaftar_list->StartRec + $lokdaftar_list->DisplayRecs - 1;
	else
		$lokdaftar_list->StopRec = $lokdaftar_list->TotalRecs;
}
$lokdaftar_list->RecCnt = $lokdaftar_list->StartRec - 1;
if ($lokdaftar_list->Recordset && !$lokdaftar_list->Recordset->EOF) {
	$lokdaftar_list->Recordset->moveFirst();
	$selectLimit = $lokdaftar_list->UseSelectLimit;
	if (!$selectLimit && $lokdaftar_list->StartRec > 1)
		$lokdaftar_list->Recordset->move($lokdaftar_list->StartRec - 1);
} elseif (!$lokdaftar->AllowAddDeleteRow && $lokdaftar_list->StopRec == 0) {
	$lokdaftar_list->StopRec = $lokdaftar->GridAddRowCount;
}

// Initialize aggregate
$lokdaftar->RowType = ROWTYPE_AGGREGATEINIT;
$lokdaftar->resetAttributes();
$lokdaftar_list->renderRow();
while ($lokdaftar_list->RecCnt < $lokdaftar_list->StopRec) {
	$lokdaftar_list->RecCnt++;
	if ($lokdaftar_list->RecCnt >= $lokdaftar_list->StartRec) {
		$lokdaftar_list->RowCnt++;

		// Set up key count
		$lokdaftar_list->KeyCount = $lokdaftar_list->RowIndex;

		// Init row class and style
		$lokdaftar->resetAttributes();
		$lokdaftar->CssClass = "";
		if ($lokdaftar->isGridAdd()) {
		} else {
			$lokdaftar_list->loadRowValues($lokdaftar_list->Recordset); // Load row values
		}
		$lokdaftar->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokdaftar->RowAttrs = array_merge($lokdaftar->RowAttrs, array('data-rowindex'=>$lokdaftar_list->RowCnt, 'id'=>'r' . $lokdaftar_list->RowCnt . '_lokdaftar', 'data-rowtype'=>$lokdaftar->RowType));

		// Render row
		$lokdaftar_list->renderRow();

		// Render list options
		$lokdaftar_list->renderListOptions();
?>
	<tr<?php echo $lokdaftar->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokdaftar_list->ListOptions->render("body", "left", $lokdaftar_list->RowCnt);
?>
	<?php if ($lokdaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<td data-name="Tgl_Daftar"<?php echo $lokdaftar->Tgl_Daftar->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Tgl_Daftar" class="lokdaftar_Tgl_Daftar">
<span<?php echo $lokdaftar->Tgl_Daftar->viewAttributes() ?>>
<?php echo $lokdaftar->Tgl_Daftar->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Waktu->Visible) { // Waktu ?>
		<td data-name="Waktu"<?php echo $lokdaftar->Waktu->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Waktu" class="lokdaftar_Waktu">
<span<?php echo $lokdaftar->Waktu->viewAttributes() ?>>
<?php echo $lokdaftar->Waktu->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td data-name="Nama_Pasien"<?php echo $lokdaftar->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Nama_Pasien" class="lokdaftar_Nama_Pasien">
<span<?php echo $lokdaftar->Nama_Pasien->viewAttributes() ?>>
<?php echo $lokdaftar->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->No_RM->Visible) { // No_RM ?>
		<td data-name="No_RM"<?php echo $lokdaftar->No_RM->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_No_RM" class="lokdaftar_No_RM">
<span<?php echo $lokdaftar->No_RM->viewAttributes() ?>>
<?php echo $lokdaftar->No_RM->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td data-name="Tgl_Lahir"<?php echo $lokdaftar->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Tgl_Lahir" class="lokdaftar_Tgl_Lahir">
<span<?php echo $lokdaftar->Tgl_Lahir->viewAttributes() ?>>
<?php echo $lokdaftar->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td data-name="Jenis_Kelamin"<?php echo $lokdaftar->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Jenis_Kelamin" class="lokdaftar_Jenis_Kelamin">
<span<?php echo $lokdaftar->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $lokdaftar->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Alamat->Visible) { // Alamat ?>
		<td data-name="Alamat"<?php echo $lokdaftar->Alamat->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Alamat" class="lokdaftar_Alamat">
<span<?php echo $lokdaftar->Alamat->viewAttributes() ?>>
<?php echo $lokdaftar->Alamat->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Poliklinik->Visible) { // Poliklinik ?>
		<td data-name="Poliklinik"<?php echo $lokdaftar->Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Poliklinik" class="lokdaftar_Poliklinik">
<span<?php echo $lokdaftar->Poliklinik->viewAttributes() ?>>
<?php echo $lokdaftar->Poliklinik->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Rawat->Visible) { // Rawat ?>
		<td data-name="Rawat"<?php echo $lokdaftar->Rawat->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Rawat" class="lokdaftar_Rawat">
<span<?php echo $lokdaftar->Rawat->viewAttributes() ?>>
<?php echo $lokdaftar->Rawat->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td data-name="Id_Rujukan"<?php echo $lokdaftar->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Id_Rujukan" class="lokdaftar_Id_Rujukan">
<span<?php echo $lokdaftar->Id_Rujukan->viewAttributes() ?>>
<?php echo $lokdaftar->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td data-name="Id_JenisPasien"<?php echo $lokdaftar->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Id_JenisPasien" class="lokdaftar_Id_JenisPasien">
<span<?php echo $lokdaftar->Id_JenisPasien->viewAttributes() ?>>
<?php echo $lokdaftar->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<td data-name="Lama_Baru"<?php echo $lokdaftar->Lama_Baru->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Lama_Baru" class="lokdaftar_Lama_Baru">
<span<?php echo $lokdaftar->Lama_Baru->viewAttributes() ?>>
<?php echo $lokdaftar->Lama_Baru->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td data-name="Total_Biaya"<?php echo $lokdaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Total_Biaya" class="lokdaftar_Total_Biaya">
<span<?php echo $lokdaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $lokdaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokdaftar->Petugas->Visible) { // Petugas ?>
		<td data-name="Petugas"<?php echo $lokdaftar->Petugas->cellAttributes() ?>>
<span id="el<?php echo $lokdaftar_list->RowCnt ?>_lokdaftar_Petugas" class="lokdaftar_Petugas">
<span<?php echo $lokdaftar->Petugas->viewAttributes() ?>>
<?php echo $lokdaftar->Petugas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokdaftar_list->ListOptions->render("body", "right", $lokdaftar_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokdaftar->isGridAdd())
		$lokdaftar_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokdaftar->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokdaftar_list->Recordset)
	$lokdaftar_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokdaftar_list->TotalRecs == 0 && !$lokdaftar->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokdaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokdaftar_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokdaftar->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokdaftar_list->terminate();
?>