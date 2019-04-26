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
$vlokpetugas_list = new vlokpetugas_list();

// Run the page
$vlokpetugas_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vlokpetugas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$vlokpetugas->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fvlokpetugaslist = currentForm = new ew.Form("fvlokpetugaslist", "list");
fvlokpetugaslist.formKeyCountName = '<?php echo $vlokpetugas_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvlokpetugaslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fvlokpetugaslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fvlokpetugaslist.lists["x_Userlevel"] = <?php echo $vlokpetugas_list->Userlevel->Lookup->toClientList() ?>;
fvlokpetugaslist.lists["x_Userlevel"].options = <?php echo JsonEncode($vlokpetugas_list->Userlevel->lookupOptions()) ?>;

// Form object for search
var fvlokpetugaslistsrch = currentSearchForm = new ew.Form("fvlokpetugaslistsrch");

// Filters
fvlokpetugaslistsrch.filterList = <?php echo $vlokpetugas_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$vlokpetugas->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($vlokpetugas_list->TotalRecs > 0 && $vlokpetugas_list->ExportOptions->visible()) { ?>
<?php $vlokpetugas_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($vlokpetugas_list->ImportOptions->visible()) { ?>
<?php $vlokpetugas_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($vlokpetugas_list->SearchOptions->visible()) { ?>
<?php $vlokpetugas_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($vlokpetugas_list->FilterOptions->visible()) { ?>
<?php $vlokpetugas_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$vlokpetugas_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$vlokpetugas->isExport() && !$vlokpetugas->CurrentAction) { ?>
<form name="fvlokpetugaslistsrch" id="fvlokpetugaslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($vlokpetugas_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fvlokpetugaslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vlokpetugas">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($vlokpetugas_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($vlokpetugas_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $vlokpetugas_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($vlokpetugas_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($vlokpetugas_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($vlokpetugas_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($vlokpetugas_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $vlokpetugas_list->showPageHeader(); ?>
<?php
$vlokpetugas_list->showMessage();
?>
<?php if ($vlokpetugas_list->TotalRecs > 0 || $vlokpetugas->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($vlokpetugas_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> vlokpetugas">
<?php if (!$vlokpetugas->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$vlokpetugas->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($vlokpetugas_list->Pager)) $vlokpetugas_list->Pager = new PrevNextPager($vlokpetugas_list->StartRec, $vlokpetugas_list->DisplayRecs, $vlokpetugas_list->TotalRecs, $vlokpetugas_list->AutoHidePager) ?>
<?php if ($vlokpetugas_list->Pager->RecordCount > 0 && $vlokpetugas_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($vlokpetugas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $vlokpetugas_list->pageUrl() ?>start=<?php echo $vlokpetugas_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($vlokpetugas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $vlokpetugas_list->pageUrl() ?>start=<?php echo $vlokpetugas_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $vlokpetugas_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($vlokpetugas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $vlokpetugas_list->pageUrl() ?>start=<?php echo $vlokpetugas_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($vlokpetugas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $vlokpetugas_list->pageUrl() ?>start=<?php echo $vlokpetugas_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vlokpetugas_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($vlokpetugas_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vlokpetugas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vlokpetugas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vlokpetugas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vlokpetugas_list->TotalRecs > 0 && (!$vlokpetugas_list->AutoHidePageSizeSelector || $vlokpetugas_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="vlokpetugas">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vlokpetugas_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vlokpetugas_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vlokpetugas_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($vlokpetugas_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($vlokpetugas_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($vlokpetugas_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vlokpetugas_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($vlokpetugas->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $vlokpetugas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fvlokpetugaslist" id="fvlokpetugaslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($vlokpetugas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $vlokpetugas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vlokpetugas">
<div id="gmp_vlokpetugas" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($vlokpetugas_list->TotalRecs > 0 || $vlokpetugas->isGridEdit()) { ?>
<table id="tbl_vlokpetugaslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$vlokpetugas_list->RowType = ROWTYPE_HEADER;

// Render list options
$vlokpetugas_list->renderListOptions();

// Render list options (header, left)
$vlokpetugas_list->ListOptions->render("header", "left");
?>
<?php if ($vlokpetugas->Nama_Petugas->Visible) { // Nama_Petugas ?>
	<?php if ($vlokpetugas->sortUrl($vlokpetugas->Nama_Petugas) == "") { ?>
		<th data-name="Nama_Petugas" class="<?php echo $vlokpetugas->Nama_Petugas->headerCellClass() ?>"><div id="elh_vlokpetugas_Nama_Petugas" class="vlokpetugas_Nama_Petugas"><div class="ew-table-header-caption"><?php echo $vlokpetugas->Nama_Petugas->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Petugas" class="<?php echo $vlokpetugas->Nama_Petugas->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $vlokpetugas->SortUrl($vlokpetugas->Nama_Petugas) ?>',2);"><div id="elh_vlokpetugas_Nama_Petugas" class="vlokpetugas_Nama_Petugas">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $vlokpetugas->Nama_Petugas->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($vlokpetugas->Nama_Petugas->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($vlokpetugas->Nama_Petugas->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->NIK->Visible) { // NIK ?>
	<?php if ($vlokpetugas->sortUrl($vlokpetugas->NIK) == "") { ?>
		<th data-name="NIK" class="<?php echo $vlokpetugas->NIK->headerCellClass() ?>"><div id="elh_vlokpetugas_NIK" class="vlokpetugas_NIK"><div class="ew-table-header-caption"><?php echo $vlokpetugas->NIK->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIK" class="<?php echo $vlokpetugas->NIK->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $vlokpetugas->SortUrl($vlokpetugas->NIK) ?>',2);"><div id="elh_vlokpetugas_NIK" class="vlokpetugas_NIK">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $vlokpetugas->NIK->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($vlokpetugas->NIK->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($vlokpetugas->NIK->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->Unit->Visible) { // Unit ?>
	<?php if ($vlokpetugas->sortUrl($vlokpetugas->Unit) == "") { ?>
		<th data-name="Unit" class="<?php echo $vlokpetugas->Unit->headerCellClass() ?>"><div id="elh_vlokpetugas_Unit" class="vlokpetugas_Unit"><div class="ew-table-header-caption"><?php echo $vlokpetugas->Unit->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Unit" class="<?php echo $vlokpetugas->Unit->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $vlokpetugas->SortUrl($vlokpetugas->Unit) ?>',2);"><div id="elh_vlokpetugas_Unit" class="vlokpetugas_Unit">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $vlokpetugas->Unit->caption() ?></span><span class="ew-table-header-sort"><?php if ($vlokpetugas->Unit->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($vlokpetugas->Unit->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->Username->Visible) { // Username ?>
	<?php if ($vlokpetugas->sortUrl($vlokpetugas->Username) == "") { ?>
		<th data-name="Username" class="<?php echo $vlokpetugas->Username->headerCellClass() ?>"><div id="elh_vlokpetugas_Username" class="vlokpetugas_Username"><div class="ew-table-header-caption"><?php echo $vlokpetugas->Username->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Username" class="<?php echo $vlokpetugas->Username->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $vlokpetugas->SortUrl($vlokpetugas->Username) ?>',2);"><div id="elh_vlokpetugas_Username" class="vlokpetugas_Username">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $vlokpetugas->Username->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($vlokpetugas->Username->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($vlokpetugas->Username->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($vlokpetugas->Userlevel->Visible) { // Userlevel ?>
	<?php if ($vlokpetugas->sortUrl($vlokpetugas->Userlevel) == "") { ?>
		<th data-name="Userlevel" class="<?php echo $vlokpetugas->Userlevel->headerCellClass() ?>"><div id="elh_vlokpetugas_Userlevel" class="vlokpetugas_Userlevel"><div class="ew-table-header-caption"><?php echo $vlokpetugas->Userlevel->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Userlevel" class="<?php echo $vlokpetugas->Userlevel->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $vlokpetugas->SortUrl($vlokpetugas->Userlevel) ?>',2);"><div id="elh_vlokpetugas_Userlevel" class="vlokpetugas_Userlevel">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $vlokpetugas->Userlevel->caption() ?></span><span class="ew-table-header-sort"><?php if ($vlokpetugas->Userlevel->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($vlokpetugas->Userlevel->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$vlokpetugas_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vlokpetugas->ExportAll && $vlokpetugas->isExport()) {
	$vlokpetugas_list->StopRec = $vlokpetugas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vlokpetugas_list->TotalRecs > $vlokpetugas_list->StartRec + $vlokpetugas_list->DisplayRecs - 1)
		$vlokpetugas_list->StopRec = $vlokpetugas_list->StartRec + $vlokpetugas_list->DisplayRecs - 1;
	else
		$vlokpetugas_list->StopRec = $vlokpetugas_list->TotalRecs;
}
$vlokpetugas_list->RecCnt = $vlokpetugas_list->StartRec - 1;
if ($vlokpetugas_list->Recordset && !$vlokpetugas_list->Recordset->EOF) {
	$vlokpetugas_list->Recordset->moveFirst();
	$selectLimit = $vlokpetugas_list->UseSelectLimit;
	if (!$selectLimit && $vlokpetugas_list->StartRec > 1)
		$vlokpetugas_list->Recordset->move($vlokpetugas_list->StartRec - 1);
} elseif (!$vlokpetugas->AllowAddDeleteRow && $vlokpetugas_list->StopRec == 0) {
	$vlokpetugas_list->StopRec = $vlokpetugas->GridAddRowCount;
}

// Initialize aggregate
$vlokpetugas->RowType = ROWTYPE_AGGREGATEINIT;
$vlokpetugas->resetAttributes();
$vlokpetugas_list->renderRow();
while ($vlokpetugas_list->RecCnt < $vlokpetugas_list->StopRec) {
	$vlokpetugas_list->RecCnt++;
	if ($vlokpetugas_list->RecCnt >= $vlokpetugas_list->StartRec) {
		$vlokpetugas_list->RowCnt++;

		// Set up key count
		$vlokpetugas_list->KeyCount = $vlokpetugas_list->RowIndex;

		// Init row class and style
		$vlokpetugas->resetAttributes();
		$vlokpetugas->CssClass = "";
		if ($vlokpetugas->isGridAdd()) {
		} else {
			$vlokpetugas_list->loadRowValues($vlokpetugas_list->Recordset); // Load row values
		}
		$vlokpetugas->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vlokpetugas->RowAttrs = array_merge($vlokpetugas->RowAttrs, array('data-rowindex'=>$vlokpetugas_list->RowCnt, 'id'=>'r' . $vlokpetugas_list->RowCnt . '_vlokpetugas', 'data-rowtype'=>$vlokpetugas->RowType));

		// Render row
		$vlokpetugas_list->renderRow();

		// Render list options
		$vlokpetugas_list->renderListOptions();
?>
	<tr<?php echo $vlokpetugas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$vlokpetugas_list->ListOptions->render("body", "left", $vlokpetugas_list->RowCnt);
?>
	<?php if ($vlokpetugas->Nama_Petugas->Visible) { // Nama_Petugas ?>
		<td data-name="Nama_Petugas"<?php echo $vlokpetugas->Nama_Petugas->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_list->RowCnt ?>_vlokpetugas_Nama_Petugas" class="vlokpetugas_Nama_Petugas">
<span<?php echo $vlokpetugas->Nama_Petugas->viewAttributes() ?>>
<?php echo $vlokpetugas->Nama_Petugas->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vlokpetugas->NIK->Visible) { // NIK ?>
		<td data-name="NIK"<?php echo $vlokpetugas->NIK->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_list->RowCnt ?>_vlokpetugas_NIK" class="vlokpetugas_NIK">
<span<?php echo $vlokpetugas->NIK->viewAttributes() ?>>
<?php echo $vlokpetugas->NIK->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vlokpetugas->Unit->Visible) { // Unit ?>
		<td data-name="Unit"<?php echo $vlokpetugas->Unit->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_list->RowCnt ?>_vlokpetugas_Unit" class="vlokpetugas_Unit">
<span<?php echo $vlokpetugas->Unit->viewAttributes() ?>>
<?php echo $vlokpetugas->Unit->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vlokpetugas->Username->Visible) { // Username ?>
		<td data-name="Username"<?php echo $vlokpetugas->Username->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_list->RowCnt ?>_vlokpetugas_Username" class="vlokpetugas_Username">
<span<?php echo $vlokpetugas->Username->viewAttributes() ?>>
<?php echo $vlokpetugas->Username->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vlokpetugas->Userlevel->Visible) { // Userlevel ?>
		<td data-name="Userlevel"<?php echo $vlokpetugas->Userlevel->cellAttributes() ?>>
<span id="el<?php echo $vlokpetugas_list->RowCnt ?>_vlokpetugas_Userlevel" class="vlokpetugas_Userlevel">
<span<?php echo $vlokpetugas->Userlevel->viewAttributes() ?>>
<?php echo $vlokpetugas->Userlevel->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vlokpetugas_list->ListOptions->render("body", "right", $vlokpetugas_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$vlokpetugas->isGridAdd())
		$vlokpetugas_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$vlokpetugas->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($vlokpetugas_list->Recordset)
	$vlokpetugas_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($vlokpetugas_list->TotalRecs == 0 && !$vlokpetugas->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $vlokpetugas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$vlokpetugas_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$vlokpetugas->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$vlokpetugas_list->terminate();
?>