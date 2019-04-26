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
$lokbiayadaftar_list = new lokbiayadaftar_list();

// Run the page
$lokbiayadaftar_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokbiayadaftar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokbiayadaftar->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokbiayadaftarlist = currentForm = new ew.Form("flokbiayadaftarlist", "list");
flokbiayadaftarlist.formKeyCountName = '<?php echo $lokbiayadaftar_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokbiayadaftarlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokbiayadaftarlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flokbiayadaftarlistsrch = currentSearchForm = new ew.Form("flokbiayadaftarlistsrch");

// Filters
flokbiayadaftarlistsrch.filterList = <?php echo $lokbiayadaftar_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokbiayadaftar->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokbiayadaftar_list->TotalRecs > 0 && $lokbiayadaftar_list->ExportOptions->visible()) { ?>
<?php $lokbiayadaftar_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokbiayadaftar_list->ImportOptions->visible()) { ?>
<?php $lokbiayadaftar_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokbiayadaftar_list->SearchOptions->visible()) { ?>
<?php $lokbiayadaftar_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokbiayadaftar_list->FilterOptions->visible()) { ?>
<?php $lokbiayadaftar_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokbiayadaftar_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokbiayadaftar->isExport() && !$lokbiayadaftar->CurrentAction) { ?>
<form name="flokbiayadaftarlistsrch" id="flokbiayadaftarlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokbiayadaftar_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokbiayadaftarlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokbiayadaftar">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokbiayadaftar_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokbiayadaftar_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokbiayadaftar_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokbiayadaftar_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokbiayadaftar_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokbiayadaftar_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokbiayadaftar_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokbiayadaftar_list->showPageHeader(); ?>
<?php
$lokbiayadaftar_list->showMessage();
?>
<?php if ($lokbiayadaftar_list->TotalRecs > 0 || $lokbiayadaftar->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokbiayadaftar_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokbiayadaftar">
<?php if (!$lokbiayadaftar->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokbiayadaftar->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokbiayadaftar_list->Pager)) $lokbiayadaftar_list->Pager = new PrevNextPager($lokbiayadaftar_list->StartRec, $lokbiayadaftar_list->DisplayRecs, $lokbiayadaftar_list->TotalRecs, $lokbiayadaftar_list->AutoHidePager) ?>
<?php if ($lokbiayadaftar_list->Pager->RecordCount > 0 && $lokbiayadaftar_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokbiayadaftar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokbiayadaftar_list->pageUrl() ?>start=<?php echo $lokbiayadaftar_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokbiayadaftar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokbiayadaftar_list->pageUrl() ?>start=<?php echo $lokbiayadaftar_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokbiayadaftar_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokbiayadaftar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokbiayadaftar_list->pageUrl() ?>start=<?php echo $lokbiayadaftar_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokbiayadaftar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokbiayadaftar_list->pageUrl() ?>start=<?php echo $lokbiayadaftar_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokbiayadaftar_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokbiayadaftar_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokbiayadaftar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokbiayadaftar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokbiayadaftar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokbiayadaftar_list->TotalRecs > 0 && (!$lokbiayadaftar_list->AutoHidePageSizeSelector || $lokbiayadaftar_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokbiayadaftar">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokbiayadaftar_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokbiayadaftar_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokbiayadaftar_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokbiayadaftar_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokbiayadaftar_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokbiayadaftar_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokbiayadaftar_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokbiayadaftar->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokbiayadaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokbiayadaftarlist" id="flokbiayadaftarlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokbiayadaftar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokbiayadaftar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokbiayadaftar">
<div id="gmp_lokbiayadaftar" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokbiayadaftar_list->TotalRecs > 0 || $lokbiayadaftar->isGridEdit()) { ?>
<table id="tbl_lokbiayadaftarlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokbiayadaftar_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokbiayadaftar_list->renderListOptions();

// Render list options (header, left)
$lokbiayadaftar_list->ListOptions->render("header", "left");
?>
<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
	<?php if ($lokbiayadaftar->sortUrl($lokbiayadaftar->Nama_Biaya) == "") { ?>
		<th data-name="Nama_Biaya" class="<?php echo $lokbiayadaftar->Nama_Biaya->headerCellClass() ?>"><div id="elh_lokbiayadaftar_Nama_Biaya" class="lokbiayadaftar_Nama_Biaya"><div class="ew-table-header-caption"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Biaya" class="<?php echo $lokbiayadaftar->Nama_Biaya->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokbiayadaftar->SortUrl($lokbiayadaftar->Nama_Biaya) ?>',2);"><div id="elh_lokbiayadaftar_Nama_Biaya" class="lokbiayadaftar_Nama_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokbiayadaftar->Nama_Biaya->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokbiayadaftar->Nama_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokbiayadaftar->Nama_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
	<?php if ($lokbiayadaftar->sortUrl($lokbiayadaftar->Jasa_Dokter) == "") { ?>
		<th data-name="Jasa_Dokter" class="<?php echo $lokbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><div id="elh_lokbiayadaftar_Jasa_Dokter" class="lokbiayadaftar_Jasa_Dokter"><div class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Dokter" class="<?php echo $lokbiayadaftar->Jasa_Dokter->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokbiayadaftar->SortUrl($lokbiayadaftar->Jasa_Dokter) ?>',2);"><div id="elh_lokbiayadaftar_Jasa_Dokter" class="lokbiayadaftar_Jasa_Dokter">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Dokter->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokbiayadaftar->Jasa_Dokter->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokbiayadaftar->Jasa_Dokter->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
	<?php if ($lokbiayadaftar->sortUrl($lokbiayadaftar->Jasa_Layanan) == "") { ?>
		<th data-name="Jasa_Layanan" class="<?php echo $lokbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><div id="elh_lokbiayadaftar_Jasa_Layanan" class="lokbiayadaftar_Jasa_Layanan"><div class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Layanan" class="<?php echo $lokbiayadaftar->Jasa_Layanan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokbiayadaftar->SortUrl($lokbiayadaftar->Jasa_Layanan) ?>',2);"><div id="elh_lokbiayadaftar_Jasa_Layanan" class="lokbiayadaftar_Jasa_Layanan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Layanan->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokbiayadaftar->Jasa_Layanan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokbiayadaftar->Jasa_Layanan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
	<?php if ($lokbiayadaftar->sortUrl($lokbiayadaftar->Jasa_Sarana) == "") { ?>
		<th data-name="Jasa_Sarana" class="<?php echo $lokbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><div id="elh_lokbiayadaftar_Jasa_Sarana" class="lokbiayadaftar_Jasa_Sarana"><div class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jasa_Sarana" class="<?php echo $lokbiayadaftar->Jasa_Sarana->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokbiayadaftar->SortUrl($lokbiayadaftar->Jasa_Sarana) ?>',2);"><div id="elh_lokbiayadaftar_Jasa_Sarana" class="lokbiayadaftar_Jasa_Sarana">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokbiayadaftar->Jasa_Sarana->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokbiayadaftar->Jasa_Sarana->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokbiayadaftar->Jasa_Sarana->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
	<?php if ($lokbiayadaftar->sortUrl($lokbiayadaftar->Total_Biaya) == "") { ?>
		<th data-name="Total_Biaya" class="<?php echo $lokbiayadaftar->Total_Biaya->headerCellClass() ?>"><div id="elh_lokbiayadaftar_Total_Biaya" class="lokbiayadaftar_Total_Biaya"><div class="ew-table-header-caption"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Total_Biaya" class="<?php echo $lokbiayadaftar->Total_Biaya->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokbiayadaftar->SortUrl($lokbiayadaftar->Total_Biaya) ?>',2);"><div id="elh_lokbiayadaftar_Total_Biaya" class="lokbiayadaftar_Total_Biaya">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokbiayadaftar->Total_Biaya->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokbiayadaftar->Total_Biaya->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokbiayadaftar->Total_Biaya->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokbiayadaftar_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokbiayadaftar->ExportAll && $lokbiayadaftar->isExport()) {
	$lokbiayadaftar_list->StopRec = $lokbiayadaftar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokbiayadaftar_list->TotalRecs > $lokbiayadaftar_list->StartRec + $lokbiayadaftar_list->DisplayRecs - 1)
		$lokbiayadaftar_list->StopRec = $lokbiayadaftar_list->StartRec + $lokbiayadaftar_list->DisplayRecs - 1;
	else
		$lokbiayadaftar_list->StopRec = $lokbiayadaftar_list->TotalRecs;
}
$lokbiayadaftar_list->RecCnt = $lokbiayadaftar_list->StartRec - 1;
if ($lokbiayadaftar_list->Recordset && !$lokbiayadaftar_list->Recordset->EOF) {
	$lokbiayadaftar_list->Recordset->moveFirst();
	$selectLimit = $lokbiayadaftar_list->UseSelectLimit;
	if (!$selectLimit && $lokbiayadaftar_list->StartRec > 1)
		$lokbiayadaftar_list->Recordset->move($lokbiayadaftar_list->StartRec - 1);
} elseif (!$lokbiayadaftar->AllowAddDeleteRow && $lokbiayadaftar_list->StopRec == 0) {
	$lokbiayadaftar_list->StopRec = $lokbiayadaftar->GridAddRowCount;
}

// Initialize aggregate
$lokbiayadaftar->RowType = ROWTYPE_AGGREGATEINIT;
$lokbiayadaftar->resetAttributes();
$lokbiayadaftar_list->renderRow();
while ($lokbiayadaftar_list->RecCnt < $lokbiayadaftar_list->StopRec) {
	$lokbiayadaftar_list->RecCnt++;
	if ($lokbiayadaftar_list->RecCnt >= $lokbiayadaftar_list->StartRec) {
		$lokbiayadaftar_list->RowCnt++;

		// Set up key count
		$lokbiayadaftar_list->KeyCount = $lokbiayadaftar_list->RowIndex;

		// Init row class and style
		$lokbiayadaftar->resetAttributes();
		$lokbiayadaftar->CssClass = "";
		if ($lokbiayadaftar->isGridAdd()) {
		} else {
			$lokbiayadaftar_list->loadRowValues($lokbiayadaftar_list->Recordset); // Load row values
		}
		$lokbiayadaftar->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokbiayadaftar->RowAttrs = array_merge($lokbiayadaftar->RowAttrs, array('data-rowindex'=>$lokbiayadaftar_list->RowCnt, 'id'=>'r' . $lokbiayadaftar_list->RowCnt . '_lokbiayadaftar', 'data-rowtype'=>$lokbiayadaftar->RowType));

		// Render row
		$lokbiayadaftar_list->renderRow();

		// Render list options
		$lokbiayadaftar_list->renderListOptions();
?>
	<tr<?php echo $lokbiayadaftar->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokbiayadaftar_list->ListOptions->render("body", "left", $lokbiayadaftar_list->RowCnt);
?>
	<?php if ($lokbiayadaftar->Nama_Biaya->Visible) { // Nama_Biaya ?>
		<td data-name="Nama_Biaya"<?php echo $lokbiayadaftar->Nama_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_list->RowCnt ?>_lokbiayadaftar_Nama_Biaya" class="lokbiayadaftar_Nama_Biaya">
<span<?php echo $lokbiayadaftar->Nama_Biaya->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Nama_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokbiayadaftar->Jasa_Dokter->Visible) { // Jasa_Dokter ?>
		<td data-name="Jasa_Dokter"<?php echo $lokbiayadaftar->Jasa_Dokter->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_list->RowCnt ?>_lokbiayadaftar_Jasa_Dokter" class="lokbiayadaftar_Jasa_Dokter">
<span<?php echo $lokbiayadaftar->Jasa_Dokter->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Dokter->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokbiayadaftar->Jasa_Layanan->Visible) { // Jasa_Layanan ?>
		<td data-name="Jasa_Layanan"<?php echo $lokbiayadaftar->Jasa_Layanan->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_list->RowCnt ?>_lokbiayadaftar_Jasa_Layanan" class="lokbiayadaftar_Jasa_Layanan">
<span<?php echo $lokbiayadaftar->Jasa_Layanan->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Layanan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokbiayadaftar->Jasa_Sarana->Visible) { // Jasa_Sarana ?>
		<td data-name="Jasa_Sarana"<?php echo $lokbiayadaftar->Jasa_Sarana->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_list->RowCnt ?>_lokbiayadaftar_Jasa_Sarana" class="lokbiayadaftar_Jasa_Sarana">
<span<?php echo $lokbiayadaftar->Jasa_Sarana->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Jasa_Sarana->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokbiayadaftar->Total_Biaya->Visible) { // Total_Biaya ?>
		<td data-name="Total_Biaya"<?php echo $lokbiayadaftar->Total_Biaya->cellAttributes() ?>>
<span id="el<?php echo $lokbiayadaftar_list->RowCnt ?>_lokbiayadaftar_Total_Biaya" class="lokbiayadaftar_Total_Biaya">
<span<?php echo $lokbiayadaftar->Total_Biaya->viewAttributes() ?>>
<?php echo $lokbiayadaftar->Total_Biaya->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokbiayadaftar_list->ListOptions->render("body", "right", $lokbiayadaftar_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokbiayadaftar->isGridAdd())
		$lokbiayadaftar_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokbiayadaftar->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokbiayadaftar_list->Recordset)
	$lokbiayadaftar_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokbiayadaftar_list->TotalRecs == 0 && !$lokbiayadaftar->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokbiayadaftar_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokbiayadaftar_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokbiayadaftar->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokbiayadaftar_list->terminate();
?>