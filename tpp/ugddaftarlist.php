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
$ugddaftar_list = new ugddaftar_list();

// Run the page
$ugddaftar_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugddaftar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$ugddaftar->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fugddaftarlist = currentForm = new ew.Form("fugddaftarlist", "list");
fugddaftarlist.formKeyCountName = '<?php echo $ugddaftar_list->FormKeyCountName ?>';

// Form_CustomValidate event
fugddaftarlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugddaftarlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fugddaftarlist.lists["x_Id_Rujukan"] = <?php echo $ugddaftar_list->Id_Rujukan->Lookup->toClientList() ?>;
fugddaftarlist.lists["x_Id_Rujukan"].options = <?php echo JsonEncode($ugddaftar_list->Id_Rujukan->lookupOptions()) ?>;
fugddaftarlist.lists["x_Id_JenisPasien"] = <?php echo $ugddaftar_list->Id_JenisPasien->Lookup->toClientList() ?>;
fugddaftarlist.lists["x_Id_JenisPasien"].options = <?php echo JsonEncode($ugddaftar_list->Id_JenisPasien->lookupOptions()) ?>;
fugddaftarlist.lists["x_Id_BiayaDaftar"] = <?php echo $ugddaftar_list->Id_BiayaDaftar->Lookup->toClientList() ?>;
fugddaftarlist.lists["x_Id_BiayaDaftar"].options = <?php echo JsonEncode($ugddaftar_list->Id_BiayaDaftar->lookupOptions()) ?>;
fugddaftarlist.lists["x_Rawat"] = <?php echo $ugddaftar_list->Rawat->Lookup->toClientList() ?>;
fugddaftarlist.lists["x_Rawat"].options = <?php echo JsonEncode($ugddaftar_list->Rawat->options(FALSE, TRUE)) ?>;

// Form object for search
var fugddaftarlistsrch = currentSearchForm = new ew.Form("fugddaftarlistsrch");

// Filters
fugddaftarlistsrch.filterList = <?php echo $ugddaftar_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$ugddaftar->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($ugddaftar_list->TotalRecs > 0 && $ugddaftar_list->ExportOptions->visible()) { ?>
<?php $ugddaftar_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($ugddaftar_list->ImportOptions->visible()) { ?>
<?php $ugddaftar_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($ugddaftar_list->SearchOptions->visible()) { ?>
<?php $ugddaftar_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($ugddaftar_list->FilterOptions->visible()) { ?>
<?php $ugddaftar_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$ugddaftar_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$ugddaftar->isExport() && !$ugddaftar->CurrentAction) { ?>
<form name="fugddaftarlistsrch" id="fugddaftarlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($ugddaftar_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fugddaftarlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ugddaftar">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($ugddaftar_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($ugddaftar_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $ugddaftar_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($ugddaftar_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($ugddaftar_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($ugddaftar_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($ugddaftar_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ugddaftar_list->showPageHeader(); ?>
<?php
$ugddaftar_list->showMessage();
?>
<?php if ($ugddaftar_list->TotalRecs > 0 || $ugddaftar->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($ugddaftar_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ugddaftar">
<?php if (!$ugddaftar->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$ugddaftar->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($ugddaftar_list->Pager)) $ugddaftar_list->Pager = new PrevNextPager($ugddaftar_list->StartRec, $ugddaftar_list->DisplayRecs, $ugddaftar_list->TotalRecs, $ugddaftar_list->AutoHidePager) ?>
<?php if ($ugddaftar_list->Pager->RecordCount > 0 && $ugddaftar_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($ugddaftar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $ugddaftar_list->pageUrl() ?>start=<?php echo $ugddaftar_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($ugddaftar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $ugddaftar_list->pageUrl() ?>start=<?php echo $ugddaftar_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $ugddaftar_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($ugddaftar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $ugddaftar_list->pageUrl() ?>start=<?php echo $ugddaftar_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($ugddaftar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $ugddaftar_list->pageUrl() ?>start=<?php echo $ugddaftar_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ugddaftar_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($ugddaftar_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ugddaftar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ugddaftar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ugddaftar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($ugddaftar_list->TotalRecs > 0 && (!$ugddaftar_list->AutoHidePageSizeSelector || $ugddaftar_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="ugddaftar">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($ugddaftar_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($ugddaftar_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($ugddaftar_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($ugddaftar_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($ugddaftar_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($ugddaftar_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($ugddaftar_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($ugddaftar->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $ugddaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fugddaftarlist" id="fugddaftarlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugddaftar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugddaftar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugddaftar">
<div id="gmp_ugddaftar" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($ugddaftar_list->TotalRecs > 0 || $ugddaftar->isGridEdit()) { ?>
<table id="tbl_ugddaftarlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$ugddaftar_list->RowType = ROWTYPE_HEADER;

// Render list options
$ugddaftar_list->renderListOptions();

// Render list options (header, left)
$ugddaftar_list->ListOptions->render("header", "left");
?>
<?php if ($ugddaftar->Id_Daftar->Visible) { // Id_Daftar ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_Daftar) == "") { ?>
		<th data-name="Id_Daftar" class="<?php echo $ugddaftar->Id_Daftar->headerCellClass() ?>"><div id="elh_ugddaftar_Id_Daftar" class="ugddaftar_Id_Daftar"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_Daftar->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Daftar" class="<?php echo $ugddaftar->Id_Daftar->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_Daftar) ?>',2);"><div id="elh_ugddaftar_Id_Daftar" class="ugddaftar_Id_Daftar">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_Daftar->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_Daftar->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_Daftar->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Tgl_Daftar) == "") { ?>
		<th data-name="Tgl_Daftar" class="<?php echo $ugddaftar->Tgl_Daftar->headerCellClass() ?>"><div id="elh_ugddaftar_Tgl_Daftar" class="ugddaftar_Tgl_Daftar"><div class="ew-table-header-caption"><?php echo $ugddaftar->Tgl_Daftar->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tgl_Daftar" class="<?php echo $ugddaftar->Tgl_Daftar->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Tgl_Daftar) ?>',2);"><div id="elh_ugddaftar_Tgl_Daftar" class="ugddaftar_Tgl_Daftar">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Tgl_Daftar->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Tgl_Daftar->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Tgl_Daftar->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Waktu->Visible) { // Waktu ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Waktu) == "") { ?>
		<th data-name="Waktu" class="<?php echo $ugddaftar->Waktu->headerCellClass() ?>"><div id="elh_ugddaftar_Waktu" class="ugddaftar_Waktu"><div class="ew-table-header-caption"><?php echo $ugddaftar->Waktu->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Waktu" class="<?php echo $ugddaftar->Waktu->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Waktu) ?>',2);"><div id="elh_ugddaftar_Waktu" class="ugddaftar_Waktu">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Waktu->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Waktu->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Waktu->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_Pasien->Visible) { // Id_Pasien ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_Pasien) == "") { ?>
		<th data-name="Id_Pasien" class="<?php echo $ugddaftar->Id_Pasien->headerCellClass() ?>"><div id="elh_ugddaftar_Id_Pasien" class="ugddaftar_Id_Pasien"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_Pasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Pasien" class="<?php echo $ugddaftar->Id_Pasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_Pasien) ?>',2);"><div id="elh_ugddaftar_Id_Pasien" class="ugddaftar_Id_Pasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_Pasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_Pasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_Pasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_Poliklinik) == "") { ?>
		<th data-name="Id_Poliklinik" class="<?php echo $ugddaftar->Id_Poliklinik->headerCellClass() ?>"><div id="elh_ugddaftar_Id_Poliklinik" class="ugddaftar_Id_Poliklinik"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_Poliklinik->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Poliklinik" class="<?php echo $ugddaftar->Id_Poliklinik->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_Poliklinik) ?>',2);"><div id="elh_ugddaftar_Id_Poliklinik" class="ugddaftar_Id_Poliklinik">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_Poliklinik->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_Poliklinik->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_Poliklinik->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_Rujukan) == "") { ?>
		<th data-name="Id_Rujukan" class="<?php echo $ugddaftar->Id_Rujukan->headerCellClass() ?>"><div id="elh_ugddaftar_Id_Rujukan" class="ugddaftar_Id_Rujukan"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_Rujukan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Rujukan" class="<?php echo $ugddaftar->Id_Rujukan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_Rujukan) ?>',2);"><div id="elh_ugddaftar_Id_Rujukan" class="ugddaftar_Id_Rujukan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_Rujukan->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_Rujukan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_Rujukan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_JenisPasien) == "") { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $ugddaftar->Id_JenisPasien->headerCellClass() ?>"><div id="elh_ugddaftar_Id_JenisPasien" class="ugddaftar_Id_JenisPasien"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_JenisPasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $ugddaftar->Id_JenisPasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_JenisPasien) ?>',2);"><div id="elh_ugddaftar_Id_JenisPasien" class="ugddaftar_Id_JenisPasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_JenisPasien->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_JenisPasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_JenisPasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Lama_Baru->Visible) { // Lama_Baru ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Lama_Baru) == "") { ?>
		<th data-name="Lama_Baru" class="<?php echo $ugddaftar->Lama_Baru->headerCellClass() ?>"><div id="elh_ugddaftar_Lama_Baru" class="ugddaftar_Lama_Baru"><div class="ew-table-header-caption"><?php echo $ugddaftar->Lama_Baru->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Lama_Baru" class="<?php echo $ugddaftar->Lama_Baru->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Lama_Baru) ?>',2);"><div id="elh_ugddaftar_Lama_Baru" class="ugddaftar_Lama_Baru">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Lama_Baru->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Lama_Baru->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Lama_Baru->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Id_BiayaDaftar) == "") { ?>
		<th data-name="Id_BiayaDaftar" class="<?php echo $ugddaftar->Id_BiayaDaftar->headerCellClass() ?>"><div id="elh_ugddaftar_Id_BiayaDaftar" class="ugddaftar_Id_BiayaDaftar"><div class="ew-table-header-caption"><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_BiayaDaftar" class="<?php echo $ugddaftar->Id_BiayaDaftar->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Id_BiayaDaftar) ?>',2);"><div id="elh_ugddaftar_Id_BiayaDaftar" class="ugddaftar_Id_BiayaDaftar">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Id_BiayaDaftar->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Id_BiayaDaftar->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Id_BiayaDaftar->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Total_Biaya) == "") { ?>
		<th data-name="Total_Biaya" class="<?php echo $ugddaftar->Total_Biaya->headerCellClass() ?>"><div id="elh_ugddaftar_Total_Biaya" class="ugddaftar_Total_Biaya"><div class="ew-table-header-caption"><?php echo $ugddaftar->Total_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Biaya" class="<?php echo $ugddaftar->Total_Biaya->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Total_Biaya) ?>',2);"><div id="elh_ugddaftar_Total_Biaya" class="ugddaftar_Total_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Total_Biaya->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Total_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Total_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Rawat->Visible) { // Rawat ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Rawat) == "") { ?>
		<th data-name="Rawat" class="<?php echo $ugddaftar->Rawat->headerCellClass() ?>"><div id="elh_ugddaftar_Rawat" class="ugddaftar_Rawat"><div class="ew-table-header-caption"><?php echo $ugddaftar->Rawat->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rawat" class="<?php echo $ugddaftar->Rawat->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Rawat) ?>',2);"><div id="elh_ugddaftar_Rawat" class="ugddaftar_Rawat">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Rawat->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Rawat->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Rawat->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Status->Visible) { // Status ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Status) == "") { ?>
		<th data-name="Status" class="<?php echo $ugddaftar->Status->headerCellClass() ?>"><div id="elh_ugddaftar_Status" class="ugddaftar_Status"><div class="ew-table-header-caption"><?php echo $ugddaftar->Status->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Status" class="<?php echo $ugddaftar->Status->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Status) ?>',2);"><div id="elh_ugddaftar_Status" class="ugddaftar_Status">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Status->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Status->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Status->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Petugas->Visible) { // Petugas ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Petugas) == "") { ?>
		<th data-name="Petugas" class="<?php echo $ugddaftar->Petugas->headerCellClass() ?>"><div id="elh_ugddaftar_Petugas" class="ugddaftar_Petugas"><div class="ew-table-header-caption"><?php echo $ugddaftar->Petugas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Petugas" class="<?php echo $ugddaftar->Petugas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Petugas) ?>',2);"><div id="elh_ugddaftar_Petugas" class="ugddaftar_Petugas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Petugas->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Petugas->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Petugas->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->No_RM->Visible) { // No_RM ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->No_RM) == "") { ?>
		<th data-name="No_RM" class="<?php echo $ugddaftar->No_RM->headerCellClass() ?>"><div id="elh_ugddaftar_No_RM" class="ugddaftar_No_RM"><div class="ew-table-header-caption"><?php echo $ugddaftar->No_RM->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_RM" class="<?php echo $ugddaftar->No_RM->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->No_RM) ?>',2);"><div id="elh_ugddaftar_No_RM" class="ugddaftar_No_RM">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->No_RM->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->No_RM->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->No_RM->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Nama_Pasien) == "") { ?>
		<th data-name="Nama_Pasien" class="<?php echo $ugddaftar->Nama_Pasien->headerCellClass() ?>"><div id="elh_ugddaftar_Nama_Pasien" class="ugddaftar_Nama_Pasien"><div class="ew-table-header-caption"><?php echo $ugddaftar->Nama_Pasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Pasien" class="<?php echo $ugddaftar->Nama_Pasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Nama_Pasien) ?>',2);"><div id="elh_ugddaftar_Nama_Pasien" class="ugddaftar_Nama_Pasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Nama_Pasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Nama_Pasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Nama_Pasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Tgl_Lahir) == "") { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $ugddaftar->Tgl_Lahir->headerCellClass() ?>"><div id="elh_ugddaftar_Tgl_Lahir" class="ugddaftar_Tgl_Lahir"><div class="ew-table-header-caption"><?php echo $ugddaftar->Tgl_Lahir->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tgl_Lahir" class="<?php echo $ugddaftar->Tgl_Lahir->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Tgl_Lahir) ?>',2);"><div id="elh_ugddaftar_Tgl_Lahir" class="ugddaftar_Tgl_Lahir">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Tgl_Lahir->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Tgl_Lahir->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Tgl_Lahir->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Jenis_Kelamin) == "") { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $ugddaftar->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_ugddaftar_Jenis_Kelamin" class="ugddaftar_Jenis_Kelamin"><div class="ew-table-header-caption"><?php echo $ugddaftar->Jenis_Kelamin->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis_Kelamin" class="<?php echo $ugddaftar->Jenis_Kelamin->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Jenis_Kelamin) ?>',2);"><div id="elh_ugddaftar_Jenis_Kelamin" class="ugddaftar_Jenis_Kelamin">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Jenis_Kelamin->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Jenis_Kelamin->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Jenis_Kelamin->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugddaftar->Alamat->Visible) { // Alamat ?>
	<?php if ($ugddaftar->sortUrl($ugddaftar->Alamat) == "") { ?>
		<th data-name="Alamat" class="<?php echo $ugddaftar->Alamat->headerCellClass() ?>"><div id="elh_ugddaftar_Alamat" class="ugddaftar_Alamat"><div class="ew-table-header-caption"><?php echo $ugddaftar->Alamat->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alamat" class="<?php echo $ugddaftar->Alamat->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugddaftar->SortUrl($ugddaftar->Alamat) ?>',2);"><div id="elh_ugddaftar_Alamat" class="ugddaftar_Alamat">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugddaftar->Alamat->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugddaftar->Alamat->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugddaftar->Alamat->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$ugddaftar_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ugddaftar->ExportAll && $ugddaftar->isExport()) {
	$ugddaftar_list->StopRec = $ugddaftar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ugddaftar_list->TotalRecs > $ugddaftar_list->StartRec + $ugddaftar_list->DisplayRecs - 1)
		$ugddaftar_list->StopRec = $ugddaftar_list->StartRec + $ugddaftar_list->DisplayRecs - 1;
	else
		$ugddaftar_list->StopRec = $ugddaftar_list->TotalRecs;
}
$ugddaftar_list->RecCnt = $ugddaftar_list->StartRec - 1;
if ($ugddaftar_list->Recordset && !$ugddaftar_list->Recordset->EOF) {
	$ugddaftar_list->Recordset->moveFirst();
	$selectLimit = $ugddaftar_list->UseSelectLimit;
	if (!$selectLimit && $ugddaftar_list->StartRec > 1)
		$ugddaftar_list->Recordset->move($ugddaftar_list->StartRec - 1);
} elseif (!$ugddaftar->AllowAddDeleteRow && $ugddaftar_list->StopRec == 0) {
	$ugddaftar_list->StopRec = $ugddaftar->GridAddRowCount;
}

// Initialize aggregate
$ugddaftar->RowType = ROWTYPE_AGGREGATEINIT;
$ugddaftar->resetAttributes();
$ugddaftar_list->renderRow();
while ($ugddaftar_list->RecCnt < $ugddaftar_list->StopRec) {
	$ugddaftar_list->RecCnt++;
	if ($ugddaftar_list->RecCnt >= $ugddaftar_list->StartRec) {
		$ugddaftar_list->RowCnt++;

		// Set up key count
		$ugddaftar_list->KeyCount = $ugddaftar_list->RowIndex;

		// Init row class and style
		$ugddaftar->resetAttributes();
		$ugddaftar->CssClass = "";
		if ($ugddaftar->isGridAdd()) {
		} else {
			$ugddaftar_list->loadRowValues($ugddaftar_list->Recordset); // Load row values
		}
		$ugddaftar->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ugddaftar->RowAttrs = array_merge($ugddaftar->RowAttrs, array('data-rowindex'=>$ugddaftar_list->RowCnt, 'id'=>'r' . $ugddaftar_list->RowCnt . '_ugddaftar', 'data-rowtype'=>$ugddaftar->RowType));

		// Render row
		$ugddaftar_list->renderRow();

		// Render list options
		$ugddaftar_list->renderListOptions();
?>
	<tr<?php echo $ugddaftar->rowAttributes() ?>>
<?php

// Render list options (body, left)
$ugddaftar_list->ListOptions->render("body", "left", $ugddaftar_list->RowCnt);
?>
	<?php if ($ugddaftar->Id_Daftar->Visible) { // Id_Daftar ?>
		<td data-name="Id_Daftar"<?php echo $ugddaftar->Id_Daftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_Daftar" class="ugddaftar_Id_Daftar">
<span<?php echo $ugddaftar->Id_Daftar->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Daftar->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Tgl_Daftar->Visible) { // Tgl_Daftar ?>
		<td data-name="Tgl_Daftar"<?php echo $ugddaftar->Tgl_Daftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Tgl_Daftar" class="ugddaftar_Tgl_Daftar">
<span<?php echo $ugddaftar->Tgl_Daftar->viewAttributes() ?>>
<?php echo $ugddaftar->Tgl_Daftar->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Waktu->Visible) { // Waktu ?>
		<td data-name="Waktu"<?php echo $ugddaftar->Waktu->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Waktu" class="ugddaftar_Waktu">
<span<?php echo $ugddaftar->Waktu->viewAttributes() ?>>
<?php echo $ugddaftar->Waktu->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Id_Pasien->Visible) { // Id_Pasien ?>
		<td data-name="Id_Pasien"<?php echo $ugddaftar->Id_Pasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_Pasien" class="ugddaftar_Id_Pasien">
<span<?php echo $ugddaftar->Id_Pasien->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Pasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Id_Poliklinik->Visible) { // Id_Poliklinik ?>
		<td data-name="Id_Poliklinik"<?php echo $ugddaftar->Id_Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_Poliklinik" class="ugddaftar_Id_Poliklinik">
<span<?php echo $ugddaftar->Id_Poliklinik->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Poliklinik->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td data-name="Id_Rujukan"<?php echo $ugddaftar->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_Rujukan" class="ugddaftar_Id_Rujukan">
<span<?php echo $ugddaftar->Id_Rujukan->viewAttributes() ?>>
<?php echo $ugddaftar->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td data-name="Id_JenisPasien"<?php echo $ugddaftar->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_JenisPasien" class="ugddaftar_Id_JenisPasien">
<span<?php echo $ugddaftar->Id_JenisPasien->viewAttributes() ?>>
<?php echo $ugddaftar->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Lama_Baru->Visible) { // Lama_Baru ?>
		<td data-name="Lama_Baru"<?php echo $ugddaftar->Lama_Baru->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Lama_Baru" class="ugddaftar_Lama_Baru">
<span<?php echo $ugddaftar->Lama_Baru->viewAttributes() ?>>
<?php echo $ugddaftar->Lama_Baru->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Id_BiayaDaftar->Visible) { // Id_BiayaDaftar ?>
		<td data-name="Id_BiayaDaftar"<?php echo $ugddaftar->Id_BiayaDaftar->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Id_BiayaDaftar" class="ugddaftar_Id_BiayaDaftar">
<span<?php echo $ugddaftar->Id_BiayaDaftar->viewAttributes() ?>>
<?php echo $ugddaftar->Id_BiayaDaftar->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td data-name="Total_Biaya"<?php echo $ugddaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Total_Biaya" class="ugddaftar_Total_Biaya">
<span<?php echo $ugddaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $ugddaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Rawat->Visible) { // Rawat ?>
		<td data-name="Rawat"<?php echo $ugddaftar->Rawat->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Rawat" class="ugddaftar_Rawat">
<span<?php echo $ugddaftar->Rawat->viewAttributes() ?>>
<?php echo $ugddaftar->Rawat->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Status->Visible) { // Status ?>
		<td data-name="Status"<?php echo $ugddaftar->Status->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Status" class="ugddaftar_Status">
<span<?php echo $ugddaftar->Status->viewAttributes() ?>>
<?php echo $ugddaftar->Status->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Petugas->Visible) { // Petugas ?>
		<td data-name="Petugas"<?php echo $ugddaftar->Petugas->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Petugas" class="ugddaftar_Petugas">
<span<?php echo $ugddaftar->Petugas->viewAttributes() ?>>
<?php echo $ugddaftar->Petugas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->No_RM->Visible) { // No_RM ?>
		<td data-name="No_RM"<?php echo $ugddaftar->No_RM->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_No_RM" class="ugddaftar_No_RM">
<span<?php echo $ugddaftar->No_RM->viewAttributes() ?>>
<?php echo $ugddaftar->No_RM->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Nama_Pasien->Visible) { // Nama_Pasien ?>
		<td data-name="Nama_Pasien"<?php echo $ugddaftar->Nama_Pasien->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Nama_Pasien" class="ugddaftar_Nama_Pasien">
<span<?php echo $ugddaftar->Nama_Pasien->viewAttributes() ?>>
<?php echo $ugddaftar->Nama_Pasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Tgl_Lahir->Visible) { // Tgl_Lahir ?>
		<td data-name="Tgl_Lahir"<?php echo $ugddaftar->Tgl_Lahir->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Tgl_Lahir" class="ugddaftar_Tgl_Lahir">
<span<?php echo $ugddaftar->Tgl_Lahir->viewAttributes() ?>>
<?php echo $ugddaftar->Tgl_Lahir->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
		<td data-name="Jenis_Kelamin"<?php echo $ugddaftar->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Jenis_Kelamin" class="ugddaftar_Jenis_Kelamin">
<span<?php echo $ugddaftar->Jenis_Kelamin->viewAttributes() ?>>
<?php echo $ugddaftar->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugddaftar->Alamat->Visible) { // Alamat ?>
		<td data-name="Alamat"<?php echo $ugddaftar->Alamat->cellAttributes() ?>>
<span id="el<?php echo $ugddaftar_list->RowCnt ?>_ugddaftar_Alamat" class="ugddaftar_Alamat">
<span<?php echo $ugddaftar->Alamat->viewAttributes() ?>>
<?php echo $ugddaftar->Alamat->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ugddaftar_list->ListOptions->render("body", "right", $ugddaftar_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$ugddaftar->isGridAdd())
		$ugddaftar_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$ugddaftar->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($ugddaftar_list->Recordset)
	$ugddaftar_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($ugddaftar_list->TotalRecs == 0 && !$ugddaftar->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $ugddaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$ugddaftar_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$ugddaftar->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ugddaftar_list->terminate();
?>