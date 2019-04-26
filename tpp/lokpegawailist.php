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
$lokpegawai_list = new lokpegawai_list();

// Run the page
$lokpegawai_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpegawai_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokpegawai->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokpegawailist = currentForm = new ew.Form("flokpegawailist", "list");
flokpegawailist.formKeyCountName = '<?php echo $lokpegawai_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokpegawailist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpegawailist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flokpegawailistsrch = currentSearchForm = new ew.Form("flokpegawailistsrch");

// Filters
flokpegawailistsrch.filterList = <?php echo $lokpegawai_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokpegawai->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokpegawai_list->TotalRecs > 0 && $lokpegawai_list->ExportOptions->visible()) { ?>
<?php $lokpegawai_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpegawai_list->ImportOptions->visible()) { ?>
<?php $lokpegawai_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpegawai_list->SearchOptions->visible()) { ?>
<?php $lokpegawai_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokpegawai_list->FilterOptions->visible()) { ?>
<?php $lokpegawai_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokpegawai_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokpegawai->isExport() && !$lokpegawai->CurrentAction) { ?>
<form name="flokpegawailistsrch" id="flokpegawailistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokpegawai_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokpegawailistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokpegawai">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokpegawai_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokpegawai_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokpegawai_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokpegawai_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokpegawai_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokpegawai_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokpegawai_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokpegawai_list->showPageHeader(); ?>
<?php
$lokpegawai_list->showMessage();
?>
<?php if ($lokpegawai_list->TotalRecs > 0 || $lokpegawai->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokpegawai_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokpegawai">
<?php if (!$lokpegawai->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokpegawai->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokpegawai_list->Pager)) $lokpegawai_list->Pager = new PrevNextPager($lokpegawai_list->StartRec, $lokpegawai_list->DisplayRecs, $lokpegawai_list->TotalRecs, $lokpegawai_list->AutoHidePager) ?>
<?php if ($lokpegawai_list->Pager->RecordCount > 0 && $lokpegawai_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokpegawai_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokpegawai_list->pageUrl() ?>start=<?php echo $lokpegawai_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokpegawai_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokpegawai_list->pageUrl() ?>start=<?php echo $lokpegawai_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokpegawai_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokpegawai_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokpegawai_list->pageUrl() ?>start=<?php echo $lokpegawai_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokpegawai_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokpegawai_list->pageUrl() ?>start=<?php echo $lokpegawai_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokpegawai_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokpegawai_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokpegawai_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokpegawai_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokpegawai_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokpegawai_list->TotalRecs > 0 && (!$lokpegawai_list->AutoHidePageSizeSelector || $lokpegawai_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokpegawai">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokpegawai_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokpegawai_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokpegawai_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokpegawai_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokpegawai_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokpegawai_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokpegawai_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokpegawai->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokpegawai_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokpegawailist" id="flokpegawailist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpegawai_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpegawai_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpegawai">
<div id="gmp_lokpegawai" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokpegawai_list->TotalRecs > 0 || $lokpegawai->isGridEdit()) { ?>
<table id="tbl_lokpegawailist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokpegawai_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokpegawai_list->renderListOptions();

// Render list options (header, left)
$lokpegawai_list->ListOptions->render("header", "left");
?>
<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Id_Pegawai) == "") { ?>
		<th data-name="Id_Pegawai" class="<?php echo $lokpegawai->Id_Pegawai->headerCellClass() ?>"><div id="elh_lokpegawai_Id_Pegawai" class="lokpegawai_Id_Pegawai"><div class="ew-table-header-caption"><?php echo $lokpegawai->Id_Pegawai->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Pegawai" class="<?php echo $lokpegawai->Id_Pegawai->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Id_Pegawai) ?>',2);"><div id="elh_lokpegawai_Id_Pegawai" class="lokpegawai_Id_Pegawai">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Id_Pegawai->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Id_Pegawai->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Id_Pegawai->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Nama_Pegawai) == "") { ?>
		<th data-name="Nama_Pegawai" class="<?php echo $lokpegawai->Nama_Pegawai->headerCellClass() ?>"><div id="elh_lokpegawai_Nama_Pegawai" class="lokpegawai_Nama_Pegawai"><div class="ew-table-header-caption"><?php echo $lokpegawai->Nama_Pegawai->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Pegawai" class="<?php echo $lokpegawai->Nama_Pegawai->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Nama_Pegawai) ?>',2);"><div id="elh_lokpegawai_Nama_Pegawai" class="lokpegawai_Nama_Pegawai">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Nama_Pegawai->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Nama_Pegawai->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Nama_Pegawai->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->NIK) == "") { ?>
		<th data-name="NIK" class="<?php echo $lokpegawai->NIK->headerCellClass() ?>"><div id="elh_lokpegawai_NIK" class="lokpegawai_NIK"><div class="ew-table-header-caption"><?php echo $lokpegawai->NIK->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIK" class="<?php echo $lokpegawai->NIK->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->NIK) ?>',2);"><div id="elh_lokpegawai_NIK" class="lokpegawai_NIK">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->NIK->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->NIK->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->NIK->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Unit) == "") { ?>
		<th data-name="Unit" class="<?php echo $lokpegawai->Unit->headerCellClass() ?>"><div id="elh_lokpegawai_Unit" class="lokpegawai_Unit"><div class="ew-table-header-caption"><?php echo $lokpegawai->Unit->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Unit" class="<?php echo $lokpegawai->Unit->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Unit) ?>',2);"><div id="elh_lokpegawai_Unit" class="lokpegawai_Unit">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Unit->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Unit->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Unit->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Jenis_Pegawai) == "") { ?>
		<th data-name="Jenis_Pegawai" class="<?php echo $lokpegawai->Jenis_Pegawai->headerCellClass() ?>"><div id="elh_lokpegawai_Jenis_Pegawai" class="lokpegawai_Jenis_Pegawai"><div class="ew-table-header-caption"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis_Pegawai" class="<?php echo $lokpegawai->Jenis_Pegawai->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Jenis_Pegawai) ?>',2);"><div id="elh_lokpegawai_Jenis_Pegawai" class="lokpegawai_Jenis_Pegawai">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Jenis_Pegawai->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Jenis_Pegawai->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Jenis_Pegawai->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Username->Visible) { // Username ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Username) == "") { ?>
		<th data-name="Username" class="<?php echo $lokpegawai->Username->headerCellClass() ?>"><div id="elh_lokpegawai_Username" class="lokpegawai_Username"><div class="ew-table-header-caption"><?php echo $lokpegawai->Username->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Username" class="<?php echo $lokpegawai->Username->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Username) ?>',2);"><div id="elh_lokpegawai_Username" class="lokpegawai_Username">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Username->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Username->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Username->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Password->Visible) { // Password ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Password) == "") { ?>
		<th data-name="Password" class="<?php echo $lokpegawai->Password->headerCellClass() ?>"><div id="elh_lokpegawai_Password" class="lokpegawai_Password"><div class="ew-table-header-caption"><?php echo $lokpegawai->Password->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Password" class="<?php echo $lokpegawai->Password->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Password) ?>',2);"><div id="elh_lokpegawai_Password" class="lokpegawai_Password">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Password->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Password->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Password->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
	<?php if ($lokpegawai->sortUrl($lokpegawai->Userlevel) == "") { ?>
		<th data-name="Userlevel" class="<?php echo $lokpegawai->Userlevel->headerCellClass() ?>"><div id="elh_lokpegawai_Userlevel" class="lokpegawai_Userlevel"><div class="ew-table-header-caption"><?php echo $lokpegawai->Userlevel->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Userlevel" class="<?php echo $lokpegawai->Userlevel->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpegawai->SortUrl($lokpegawai->Userlevel) ?>',2);"><div id="elh_lokpegawai_Userlevel" class="lokpegawai_Userlevel">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpegawai->Userlevel->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokpegawai->Userlevel->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpegawai->Userlevel->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokpegawai_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokpegawai->ExportAll && $lokpegawai->isExport()) {
	$lokpegawai_list->StopRec = $lokpegawai_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokpegawai_list->TotalRecs > $lokpegawai_list->StartRec + $lokpegawai_list->DisplayRecs - 1)
		$lokpegawai_list->StopRec = $lokpegawai_list->StartRec + $lokpegawai_list->DisplayRecs - 1;
	else
		$lokpegawai_list->StopRec = $lokpegawai_list->TotalRecs;
}
$lokpegawai_list->RecCnt = $lokpegawai_list->StartRec - 1;
if ($lokpegawai_list->Recordset && !$lokpegawai_list->Recordset->EOF) {
	$lokpegawai_list->Recordset->moveFirst();
	$selectLimit = $lokpegawai_list->UseSelectLimit;
	if (!$selectLimit && $lokpegawai_list->StartRec > 1)
		$lokpegawai_list->Recordset->move($lokpegawai_list->StartRec - 1);
} elseif (!$lokpegawai->AllowAddDeleteRow && $lokpegawai_list->StopRec == 0) {
	$lokpegawai_list->StopRec = $lokpegawai->GridAddRowCount;
}

// Initialize aggregate
$lokpegawai->RowType = ROWTYPE_AGGREGATEINIT;
$lokpegawai->resetAttributes();
$lokpegawai_list->renderRow();
while ($lokpegawai_list->RecCnt < $lokpegawai_list->StopRec) {
	$lokpegawai_list->RecCnt++;
	if ($lokpegawai_list->RecCnt >= $lokpegawai_list->StartRec) {
		$lokpegawai_list->RowCnt++;

		// Set up key count
		$lokpegawai_list->KeyCount = $lokpegawai_list->RowIndex;

		// Init row class and style
		$lokpegawai->resetAttributes();
		$lokpegawai->CssClass = "";
		if ($lokpegawai->isGridAdd()) {
		} else {
			$lokpegawai_list->loadRowValues($lokpegawai_list->Recordset); // Load row values
		}
		$lokpegawai->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokpegawai->RowAttrs = array_merge($lokpegawai->RowAttrs, array('data-rowindex'=>$lokpegawai_list->RowCnt, 'id'=>'r' . $lokpegawai_list->RowCnt . '_lokpegawai', 'data-rowtype'=>$lokpegawai->RowType));

		// Render row
		$lokpegawai_list->renderRow();

		// Render list options
		$lokpegawai_list->renderListOptions();
?>
	<tr<?php echo $lokpegawai->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokpegawai_list->ListOptions->render("body", "left", $lokpegawai_list->RowCnt);
?>
	<?php if ($lokpegawai->Id_Pegawai->Visible) { // Id_Pegawai ?>
		<td data-name="Id_Pegawai"<?php echo $lokpegawai->Id_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Id_Pegawai" class="lokpegawai_Id_Pegawai">
<span<?php echo $lokpegawai->Id_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Id_Pegawai->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Nama_Pegawai->Visible) { // Nama_Pegawai ?>
		<td data-name="Nama_Pegawai"<?php echo $lokpegawai->Nama_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Nama_Pegawai" class="lokpegawai_Nama_Pegawai">
<span<?php echo $lokpegawai->Nama_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Nama_Pegawai->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->NIK->Visible) { // NIK ?>
		<td data-name="NIK"<?php echo $lokpegawai->NIK->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_NIK" class="lokpegawai_NIK">
<span<?php echo $lokpegawai->NIK->viewAttributes() ?>>
<?php echo $lokpegawai->NIK->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Unit->Visible) { // Unit ?>
		<td data-name="Unit"<?php echo $lokpegawai->Unit->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Unit" class="lokpegawai_Unit">
<span<?php echo $lokpegawai->Unit->viewAttributes() ?>>
<?php echo $lokpegawai->Unit->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Jenis_Pegawai->Visible) { // Jenis_Pegawai ?>
		<td data-name="Jenis_Pegawai"<?php echo $lokpegawai->Jenis_Pegawai->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Jenis_Pegawai" class="lokpegawai_Jenis_Pegawai">
<span<?php echo $lokpegawai->Jenis_Pegawai->viewAttributes() ?>>
<?php echo $lokpegawai->Jenis_Pegawai->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Username->Visible) { // Username ?>
		<td data-name="Username"<?php echo $lokpegawai->Username->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Username" class="lokpegawai_Username">
<span<?php echo $lokpegawai->Username->viewAttributes() ?>>
<?php echo $lokpegawai->Username->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Password->Visible) { // Password ?>
		<td data-name="Password"<?php echo $lokpegawai->Password->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Password" class="lokpegawai_Password">
<span<?php echo $lokpegawai->Password->viewAttributes() ?>>
<?php echo $lokpegawai->Password->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokpegawai->Userlevel->Visible) { // Userlevel ?>
		<td data-name="Userlevel"<?php echo $lokpegawai->Userlevel->cellAttributes() ?>>
<span id="el<?php echo $lokpegawai_list->RowCnt ?>_lokpegawai_Userlevel" class="lokpegawai_Userlevel">
<span<?php echo $lokpegawai->Userlevel->viewAttributes() ?>>
<?php echo $lokpegawai->Userlevel->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokpegawai_list->ListOptions->render("body", "right", $lokpegawai_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokpegawai->isGridAdd())
		$lokpegawai_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokpegawai->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokpegawai_list->Recordset)
	$lokpegawai_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokpegawai_list->TotalRecs == 0 && !$lokpegawai->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokpegawai_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokpegawai_list->showPageFooter();
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
$lokpegawai_list->terminate();
?>