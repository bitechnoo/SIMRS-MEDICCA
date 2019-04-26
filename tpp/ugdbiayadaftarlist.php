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
$ugdbiayadaftar_list = new ugdbiayadaftar_list();

// Run the page
$ugdbiayadaftar_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugdbiayadaftar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fugdbiayadaftarlist = currentForm = new ew.Form("fugdbiayadaftarlist", "list");
fugdbiayadaftarlist.formKeyCountName = '<?php echo $ugdbiayadaftar_list->FormKeyCountName ?>';

// Form_CustomValidate event
fugdbiayadaftarlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugdbiayadaftarlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fugdbiayadaftarlistsrch = currentSearchForm = new ew.Form("fugdbiayadaftarlistsrch");

// Filters
fugdbiayadaftarlistsrch.filterList = <?php echo $ugdbiayadaftar_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($ugdbiayadaftar_list->TotalRecs > 0 && $ugdbiayadaftar_list->ExportOptions->visible()) { ?>
<?php $ugdbiayadaftar_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($ugdbiayadaftar_list->ImportOptions->visible()) { ?>
<?php $ugdbiayadaftar_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($ugdbiayadaftar_list->SearchOptions->visible()) { ?>
<?php $ugdbiayadaftar_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($ugdbiayadaftar_list->FilterOptions->visible()) { ?>
<?php $ugdbiayadaftar_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$ugdbiayadaftar_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$ugdbiayadaftar->isExport() && !$ugdbiayadaftar->CurrentAction) { ?>
<form name="fugdbiayadaftarlistsrch" id="fugdbiayadaftarlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($ugdbiayadaftar_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fugdbiayadaftarlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ugdbiayadaftar">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($ugdbiayadaftar_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($ugdbiayadaftar_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $ugdbiayadaftar_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($ugdbiayadaftar_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($ugdbiayadaftar_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($ugdbiayadaftar_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($ugdbiayadaftar_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ugdbiayadaftar_list->showPageHeader(); ?>
<?php
$ugdbiayadaftar_list->showMessage();
?>
<?php if ($ugdbiayadaftar_list->TotalRecs > 0 || $ugdbiayadaftar->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($ugdbiayadaftar_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ugdbiayadaftar">
<?php if (!$ugdbiayadaftar->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$ugdbiayadaftar->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($ugdbiayadaftar_list->Pager)) $ugdbiayadaftar_list->Pager = new PrevNextPager($ugdbiayadaftar_list->StartRec, $ugdbiayadaftar_list->DisplayRecs, $ugdbiayadaftar_list->TotalRecs, $ugdbiayadaftar_list->AutoHidePager) ?>
<?php if ($ugdbiayadaftar_list->Pager->RecordCount > 0 && $ugdbiayadaftar_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($ugdbiayadaftar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $ugdbiayadaftar_list->pageUrl() ?>start=<?php echo $ugdbiayadaftar_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($ugdbiayadaftar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $ugdbiayadaftar_list->pageUrl() ?>start=<?php echo $ugdbiayadaftar_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $ugdbiayadaftar_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($ugdbiayadaftar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $ugdbiayadaftar_list->pageUrl() ?>start=<?php echo $ugdbiayadaftar_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($ugdbiayadaftar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $ugdbiayadaftar_list->pageUrl() ?>start=<?php echo $ugdbiayadaftar_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ugdbiayadaftar_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($ugdbiayadaftar_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ugdbiayadaftar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ugdbiayadaftar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ugdbiayadaftar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($ugdbiayadaftar_list->TotalRecs > 0 && (!$ugdbiayadaftar_list->AutoHidePageSizeSelector || $ugdbiayadaftar_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="ugdbiayadaftar">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($ugdbiayadaftar_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($ugdbiayadaftar_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($ugdbiayadaftar_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($ugdbiayadaftar_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($ugdbiayadaftar_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($ugdbiayadaftar_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($ugdbiayadaftar_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($ugdbiayadaftar->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $ugdbiayadaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fugdbiayadaftarlist" id="fugdbiayadaftarlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugdbiayadaftar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugdbiayadaftar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugdbiayadaftar">
<div id="gmp_ugdbiayadaftar" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($ugdbiayadaftar_list->TotalRecs > 0 || $ugdbiayadaftar->isGridEdit()) { ?>
<table id="tbl_ugdbiayadaftarlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$ugdbiayadaftar_list->RowType = ROWTYPE_HEADER;

// Render list options
$ugdbiayadaftar_list->renderListOptions();

// Render list options (header, left)
$ugdbiayadaftar_list->ListOptions->render("header", "left");
?>
<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Id_Biayadaftar) == "") { ?>
		<th data-name="Id_Biayadaftar" class="<?php echo $ugdbiayadaftar->Id_Biayadaftar->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Id_Biayadaftar" class="ugdbiayadaftar_Id_Biayadaftar"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Biayadaftar" class="<?php echo $ugdbiayadaftar->Id_Biayadaftar->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Id_Biayadaftar) ?>',2);"><div id="elh_ugdbiayadaftar_Id_Biayadaftar" class="ugdbiayadaftar_Id_Biayadaftar">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Id_Biayadaftar->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Id_Biayadaftar->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Id_Biayadaftar->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Nama_Biaya) == "") { ?>
		<th data-name="Nama_Biaya" class="<?php echo $ugdbiayadaftar->Nama_Biaya->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Nama_Biaya" class="ugdbiayadaftar_Nama_Biaya"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Biaya" class="<?php echo $ugdbiayadaftar->Nama_Biaya->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Nama_Biaya) ?>',2);"><div id="elh_ugdbiayadaftar_Nama_Biaya" class="ugdbiayadaftar_Nama_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Nama_Biaya->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Nama_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Nama_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Jasa_Dokter) == "") { ?>
		<th data-name="Jasa_Dokter" class="<?php echo $ugdbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Jasa_Dokter" class="ugdbiayadaftar_Jasa_Dokter"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Dokter" class="<?php echo $ugdbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Jasa_Dokter) ?>',2);"><div id="elh_ugdbiayadaftar_Jasa_Dokter" class="ugdbiayadaftar_Jasa_Dokter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Dokter->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Jasa_Dokter->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Jasa_Dokter->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Jasa_Layanan) == "") { ?>
		<th data-name="Jasa_Layanan" class="<?php echo $ugdbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Jasa_Layanan" class="ugdbiayadaftar_Jasa_Layanan"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Layanan" class="<?php echo $ugdbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Jasa_Layanan) ?>',2);"><div id="elh_ugdbiayadaftar_Jasa_Layanan" class="ugdbiayadaftar_Jasa_Layanan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Layanan->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Jasa_Layanan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Jasa_Layanan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Jasa_Sarana) == "") { ?>
		<th data-name="Jasa_Sarana" class="<?php echo $ugdbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Jasa_Sarana" class="ugdbiayadaftar_Jasa_Sarana"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Sarana" class="<?php echo $ugdbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Jasa_Sarana) ?>',2);"><div id="elh_ugdbiayadaftar_Jasa_Sarana" class="ugdbiayadaftar_Jasa_Sarana">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Jasa_Sarana->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Jasa_Sarana->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Jasa_Sarana->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<?php if ($ugdbiayadaftar->sortUrl($ugdbiayadaftar->Total_Biaya) == "") { ?>
		<th data-name="Total_Biaya" class="<?php echo $ugdbiayadaftar->Total_Biaya->headerCellClass() ?>"><div id="elh_ugdbiayadaftar_Total_Biaya" class="ugdbiayadaftar_Total_Biaya"><div class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Biaya" class="<?php echo $ugdbiayadaftar->Total_Biaya->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugdbiayadaftar->SortUrl($ugdbiayadaftar->Total_Biaya) ?>',2);"><div id="elh_ugdbiayadaftar_Total_Biaya" class="ugdbiayadaftar_Total_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugdbiayadaftar->Total_Biaya->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugdbiayadaftar->Total_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugdbiayadaftar->Total_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$ugdbiayadaftar_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ugdbiayadaftar->ExportAll && $ugdbiayadaftar->isExport()) {
	$ugdbiayadaftar_list->StopRec = $ugdbiayadaftar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ugdbiayadaftar_list->TotalRecs > $ugdbiayadaftar_list->StartRec + $ugdbiayadaftar_list->DisplayRecs - 1)
		$ugdbiayadaftar_list->StopRec = $ugdbiayadaftar_list->StartRec + $ugdbiayadaftar_list->DisplayRecs - 1;
	else
		$ugdbiayadaftar_list->StopRec = $ugdbiayadaftar_list->TotalRecs;
}
$ugdbiayadaftar_list->RecCnt = $ugdbiayadaftar_list->StartRec - 1;
if ($ugdbiayadaftar_list->Recordset && !$ugdbiayadaftar_list->Recordset->EOF) {
	$ugdbiayadaftar_list->Recordset->moveFirst();
	$selectLimit = $ugdbiayadaftar_list->UseSelectLimit;
	if (!$selectLimit && $ugdbiayadaftar_list->StartRec > 1)
		$ugdbiayadaftar_list->Recordset->move($ugdbiayadaftar_list->StartRec - 1);
} elseif (!$ugdbiayadaftar->AllowAddDeleteRow && $ugdbiayadaftar_list->StopRec == 0) {
	$ugdbiayadaftar_list->StopRec = $ugdbiayadaftar->GridAddRowCount;
}

// Initialize aggregate
$ugdbiayadaftar->RowType = ROWTYPE_AGGREGATEINIT;
$ugdbiayadaftar->resetAttributes();
$ugdbiayadaftar_list->renderRow();
while ($ugdbiayadaftar_list->RecCnt < $ugdbiayadaftar_list->StopRec) {
	$ugdbiayadaftar_list->RecCnt++;
	if ($ugdbiayadaftar_list->RecCnt >= $ugdbiayadaftar_list->StartRec) {
		$ugdbiayadaftar_list->RowCnt++;

		// Set up key count
		$ugdbiayadaftar_list->KeyCount = $ugdbiayadaftar_list->RowIndex;

		// Init row class and style
		$ugdbiayadaftar->resetAttributes();
		$ugdbiayadaftar->CssClass = "";
		if ($ugdbiayadaftar->isGridAdd()) {
		} else {
			$ugdbiayadaftar_list->loadRowValues($ugdbiayadaftar_list->Recordset); // Load row values
		}
		$ugdbiayadaftar->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ugdbiayadaftar->RowAttrs = array_merge($ugdbiayadaftar->RowAttrs, array('data-rowindex'=>$ugdbiayadaftar_list->RowCnt, 'id'=>'r' . $ugdbiayadaftar_list->RowCnt . '_ugdbiayadaftar', 'data-rowtype'=>$ugdbiayadaftar->RowType));

		// Render row
		$ugdbiayadaftar_list->renderRow();

		// Render list options
		$ugdbiayadaftar_list->renderListOptions();
?>
	<tr<?php echo $ugdbiayadaftar->rowAttributes() ?>>
<?php

// Render list options (body, left)
$ugdbiayadaftar_list->ListOptions->render("body", "left", $ugdbiayadaftar_list->RowCnt);
?>
	<?php if ($ugdbiayadaftar->Id_Biayadaftar->Visible) { // Id_Biayadaftar ?>
		<td data-name="Id_Biayadaftar"<?php echo $ugdbiayadaftar->Id_Biayadaftar->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Id_Biayadaftar" class="ugdbiayadaftar_Id_Biayadaftar">
<span<?php echo $ugdbiayadaftar->Id_Biayadaftar->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Id_Biayadaftar->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugdbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<td data-name="Nama_Biaya"<?php echo $ugdbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Nama_Biaya" class="ugdbiayadaftar_Nama_Biaya">
<span<?php echo $ugdbiayadaftar->Nama_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Nama_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugdbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<td data-name="Jasa_Dokter"<?php echo $ugdbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Jasa_Dokter" class="ugdbiayadaftar_Jasa_Dokter">
<span<?php echo $ugdbiayadaftar->Jasa_Dokter->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Dokter->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugdbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<td data-name="Jasa_Layanan"<?php echo $ugdbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Jasa_Layanan" class="ugdbiayadaftar_Jasa_Layanan">
<span<?php echo $ugdbiayadaftar->Jasa_Layanan->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Layanan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugdbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<td data-name="Jasa_Sarana"<?php echo $ugdbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Jasa_Sarana" class="ugdbiayadaftar_Jasa_Sarana">
<span<?php echo $ugdbiayadaftar->Jasa_Sarana->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Jasa_Sarana->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugdbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td data-name="Total_Biaya"<?php echo $ugdbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $ugdbiayadaftar_list->RowCnt ?>_ugdbiayadaftar_Total_Biaya" class="ugdbiayadaftar_Total_Biaya">
<span<?php echo $ugdbiayadaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $ugdbiayadaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ugdbiayadaftar_list->ListOptions->render("body", "right", $ugdbiayadaftar_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$ugdbiayadaftar->isGridAdd())
		$ugdbiayadaftar_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$ugdbiayadaftar->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($ugdbiayadaftar_list->Recordset)
	$ugdbiayadaftar_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($ugdbiayadaftar_list->TotalRecs == 0 && !$ugdbiayadaftar->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $ugdbiayadaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$ugdbiayadaftar_list->showPageFooter();
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
$ugdbiayadaftar_list->terminate();
?>