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
$lokpoliklinik_list = new lokpoliklinik_list();

// Run the page
$lokpoliklinik_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokpoliklinik_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokpoliklinik->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokpolikliniklist = currentForm = new ew.Form("flokpolikliniklist", "list");
flokpolikliniklist.formKeyCountName = '<?php echo $lokpoliklinik_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokpolikliniklist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokpolikliniklist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flokpolikliniklistsrch = currentSearchForm = new ew.Form("flokpolikliniklistsrch");

// Filters
flokpolikliniklistsrch.filterList = <?php echo $lokpoliklinik_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokpoliklinik->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokpoliklinik_list->TotalRecs > 0 && $lokpoliklinik_list->ExportOptions->visible()) { ?>
<?php $lokpoliklinik_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpoliklinik_list->ImportOptions->visible()) { ?>
<?php $lokpoliklinik_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokpoliklinik_list->SearchOptions->visible()) { ?>
<?php $lokpoliklinik_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokpoliklinik_list->FilterOptions->visible()) { ?>
<?php $lokpoliklinik_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokpoliklinik_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokpoliklinik->isExport() && !$lokpoliklinik->CurrentAction) { ?>
<form name="flokpolikliniklistsrch" id="flokpolikliniklistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokpoliklinik_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokpolikliniklistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokpoliklinik">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokpoliklinik_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokpoliklinik_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokpoliklinik_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokpoliklinik_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokpoliklinik_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokpoliklinik_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokpoliklinik_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokpoliklinik_list->showPageHeader(); ?>
<?php
$lokpoliklinik_list->showMessage();
?>
<?php if ($lokpoliklinik_list->TotalRecs > 0 || $lokpoliklinik->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokpoliklinik_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokpoliklinik">
<?php if (!$lokpoliklinik->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokpoliklinik->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokpoliklinik_list->Pager)) $lokpoliklinik_list->Pager = new PrevNextPager($lokpoliklinik_list->StartRec, $lokpoliklinik_list->DisplayRecs, $lokpoliklinik_list->TotalRecs, $lokpoliklinik_list->AutoHidePager) ?>
<?php if ($lokpoliklinik_list->Pager->RecordCount > 0 && $lokpoliklinik_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokpoliklinik_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokpoliklinik_list->pageUrl() ?>start=<?php echo $lokpoliklinik_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokpoliklinik_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokpoliklinik_list->pageUrl() ?>start=<?php echo $lokpoliklinik_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokpoliklinik_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokpoliklinik_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokpoliklinik_list->pageUrl() ?>start=<?php echo $lokpoliklinik_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokpoliklinik_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokpoliklinik_list->pageUrl() ?>start=<?php echo $lokpoliklinik_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokpoliklinik_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokpoliklinik_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokpoliklinik_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokpoliklinik_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokpoliklinik_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokpoliklinik_list->TotalRecs > 0 && (!$lokpoliklinik_list->AutoHidePageSizeSelector || $lokpoliklinik_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokpoliklinik">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokpoliklinik_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokpoliklinik_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokpoliklinik_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokpoliklinik_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokpoliklinik_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokpoliklinik_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokpoliklinik_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokpoliklinik->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokpoliklinik_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokpolikliniklist" id="flokpolikliniklist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokpoliklinik_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokpoliklinik_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokpoliklinik">
<div id="gmp_lokpoliklinik" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokpoliklinik_list->TotalRecs > 0 || $lokpoliklinik->isGridEdit()) { ?>
<table id="tbl_lokpolikliniklist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokpoliklinik_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokpoliklinik_list->renderListOptions();

// Render list options (header, left)
$lokpoliklinik_list->ListOptions->render("header", "left");
?>
<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
	<?php if ($lokpoliklinik->sortUrl($lokpoliklinik->Nama_Poliklinik) == "") { ?>
		<th data-name="Nama_Poliklinik" class="<?php echo $lokpoliklinik->Nama_Poliklinik->headerCellClass() ?>"><div id="elh_lokpoliklinik_Nama_Poliklinik" class="lokpoliklinik_Nama_Poliklinik"><div class="ew-table-header-caption"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama_Poliklinik" class="<?php echo $lokpoliklinik->Nama_Poliklinik->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokpoliklinik->SortUrl($lokpoliklinik->Nama_Poliklinik) ?>',2);"><div id="elh_lokpoliklinik_Nama_Poliklinik" class="lokpoliklinik_Nama_Poliklinik">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokpoliklinik->Nama_Poliklinik->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokpoliklinik->Nama_Poliklinik->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokpoliklinik->Nama_Poliklinik->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokpoliklinik_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokpoliklinik->ExportAll && $lokpoliklinik->isExport()) {
	$lokpoliklinik_list->StopRec = $lokpoliklinik_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokpoliklinik_list->TotalRecs > $lokpoliklinik_list->StartRec + $lokpoliklinik_list->DisplayRecs - 1)
		$lokpoliklinik_list->StopRec = $lokpoliklinik_list->StartRec + $lokpoliklinik_list->DisplayRecs - 1;
	else
		$lokpoliklinik_list->StopRec = $lokpoliklinik_list->TotalRecs;
}
$lokpoliklinik_list->RecCnt = $lokpoliklinik_list->StartRec - 1;
if ($lokpoliklinik_list->Recordset && !$lokpoliklinik_list->Recordset->EOF) {
	$lokpoliklinik_list->Recordset->moveFirst();
	$selectLimit = $lokpoliklinik_list->UseSelectLimit;
	if (!$selectLimit && $lokpoliklinik_list->StartRec > 1)
		$lokpoliklinik_list->Recordset->move($lokpoliklinik_list->StartRec - 1);
} elseif (!$lokpoliklinik->AllowAddDeleteRow && $lokpoliklinik_list->StopRec == 0) {
	$lokpoliklinik_list->StopRec = $lokpoliklinik->GridAddRowCount;
}

// Initialize aggregate
$lokpoliklinik->RowType = ROWTYPE_AGGREGATEINIT;
$lokpoliklinik->resetAttributes();
$lokpoliklinik_list->renderRow();
while ($lokpoliklinik_list->RecCnt < $lokpoliklinik_list->StopRec) {
	$lokpoliklinik_list->RecCnt++;
	if ($lokpoliklinik_list->RecCnt >= $lokpoliklinik_list->StartRec) {
		$lokpoliklinik_list->RowCnt++;

		// Set up key count
		$lokpoliklinik_list->KeyCount = $lokpoliklinik_list->RowIndex;

		// Init row class and style
		$lokpoliklinik->resetAttributes();
		$lokpoliklinik->CssClass = "";
		if ($lokpoliklinik->isGridAdd()) {
		} else {
			$lokpoliklinik_list->loadRowValues($lokpoliklinik_list->Recordset); // Load row values
		}
		$lokpoliklinik->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokpoliklinik->RowAttrs = array_merge($lokpoliklinik->RowAttrs, array('data-rowindex'=>$lokpoliklinik_list->RowCnt, 'id'=>'r' . $lokpoliklinik_list->RowCnt . '_lokpoliklinik', 'data-rowtype'=>$lokpoliklinik->RowType));

		// Render row
		$lokpoliklinik_list->renderRow();

		// Render list options
		$lokpoliklinik_list->renderListOptions();
?>
	<tr<?php echo $lokpoliklinik->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokpoliklinik_list->ListOptions->render("body", "left", $lokpoliklinik_list->RowCnt);
?>
	<?php if ($lokpoliklinik->Nama_Poliklinik->Visible) { // Nama_Poliklinik ?>
		<td data-name="Nama_Poliklinik"<?php echo $lokpoliklinik->Nama_Poliklinik->cellAttributes() ?>>
<span id="el<?php echo $lokpoliklinik_list->RowCnt ?>_lokpoliklinik_Nama_Poliklinik" class="lokpoliklinik_Nama_Poliklinik">
<span<?php echo $lokpoliklinik->Nama_Poliklinik->viewAttributes() ?>>
<?php echo $lokpoliklinik->Nama_Poliklinik->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokpoliklinik_list->ListOptions->render("body", "right", $lokpoliklinik_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokpoliklinik->isGridAdd())
		$lokpoliklinik_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokpoliklinik->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokpoliklinik_list->Recordset)
	$lokpoliklinik_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokpoliklinik_list->TotalRecs == 0 && !$lokpoliklinik->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokpoliklinik_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokpoliklinik_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokpoliklinik->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokpoliklinik_list->terminate();
?>