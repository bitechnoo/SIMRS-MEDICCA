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
$lokasalrujukan_list = new lokasalrujukan_list();

// Run the page
$lokasalrujukan_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokasalrujukan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokasalrujukan->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokasalrujukanlist = currentForm = new ew.Form("flokasalrujukanlist", "list");
flokasalrujukanlist.formKeyCountName = '<?php echo $lokasalrujukan_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokasalrujukanlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokasalrujukanlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flokasalrujukanlistsrch = currentSearchForm = new ew.Form("flokasalrujukanlistsrch");

// Filters
flokasalrujukanlistsrch.filterList = <?php echo $lokasalrujukan_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokasalrujukan->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokasalrujukan_list->TotalRecs > 0 && $lokasalrujukan_list->ExportOptions->visible()) { ?>
<?php $lokasalrujukan_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokasalrujukan_list->ImportOptions->visible()) { ?>
<?php $lokasalrujukan_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokasalrujukan_list->SearchOptions->visible()) { ?>
<?php $lokasalrujukan_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokasalrujukan_list->FilterOptions->visible()) { ?>
<?php $lokasalrujukan_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokasalrujukan_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokasalrujukan->isExport() && !$lokasalrujukan->CurrentAction) { ?>
<form name="flokasalrujukanlistsrch" id="flokasalrujukanlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokasalrujukan_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokasalrujukanlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokasalrujukan">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokasalrujukan_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokasalrujukan_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokasalrujukan_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokasalrujukan_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokasalrujukan_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokasalrujukan_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokasalrujukan_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokasalrujukan_list->showPageHeader(); ?>
<?php
$lokasalrujukan_list->showMessage();
?>
<?php if ($lokasalrujukan_list->TotalRecs > 0 || $lokasalrujukan->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokasalrujukan_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokasalrujukan">
<?php if (!$lokasalrujukan->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokasalrujukan->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokasalrujukan_list->Pager)) $lokasalrujukan_list->Pager = new PrevNextPager($lokasalrujukan_list->StartRec, $lokasalrujukan_list->DisplayRecs, $lokasalrujukan_list->TotalRecs, $lokasalrujukan_list->AutoHidePager) ?>
<?php if ($lokasalrujukan_list->Pager->RecordCount > 0 && $lokasalrujukan_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokasalrujukan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokasalrujukan_list->pageUrl() ?>start=<?php echo $lokasalrujukan_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokasalrujukan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokasalrujukan_list->pageUrl() ?>start=<?php echo $lokasalrujukan_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokasalrujukan_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokasalrujukan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokasalrujukan_list->pageUrl() ?>start=<?php echo $lokasalrujukan_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokasalrujukan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokasalrujukan_list->pageUrl() ?>start=<?php echo $lokasalrujukan_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokasalrujukan_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokasalrujukan_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokasalrujukan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokasalrujukan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokasalrujukan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokasalrujukan_list->TotalRecs > 0 && (!$lokasalrujukan_list->AutoHidePageSizeSelector || $lokasalrujukan_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokasalrujukan">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokasalrujukan_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokasalrujukan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokasalrujukan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokasalrujukan_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokasalrujukan_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokasalrujukan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokasalrujukan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokasalrujukan->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokasalrujukan_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokasalrujukanlist" id="flokasalrujukanlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokasalrujukan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokasalrujukan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokasalrujukan">
<div id="gmp_lokasalrujukan" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokasalrujukan_list->TotalRecs > 0 || $lokasalrujukan->isGridEdit()) { ?>
<table id="tbl_lokasalrujukanlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokasalrujukan_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokasalrujukan_list->renderListOptions();

// Render list options (header, left)
$lokasalrujukan_list->ListOptions->render("header", "left");
?>
<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
	<?php if ($lokasalrujukan->sortUrl($lokasalrujukan->Id_Rujukan) == "") { ?>
		<th data-name="Id_Rujukan" class="<?php echo $lokasalrujukan->Id_Rujukan->headerCellClass() ?>"><div id="elh_lokasalrujukan_Id_Rujukan" class="lokasalrujukan_Id_Rujukan"><div class="ew-table-header-caption"><?php echo $lokasalrujukan->Id_Rujukan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Rujukan" class="<?php echo $lokasalrujukan->Id_Rujukan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokasalrujukan->SortUrl($lokasalrujukan->Id_Rujukan) ?>',2);"><div id="elh_lokasalrujukan_Id_Rujukan" class="lokasalrujukan_Id_Rujukan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokasalrujukan->Id_Rujukan->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokasalrujukan->Id_Rujukan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokasalrujukan->Id_Rujukan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
	<?php if ($lokasalrujukan->sortUrl($lokasalrujukan->Rujukan) == "") { ?>
		<th data-name="Rujukan" class="<?php echo $lokasalrujukan->Rujukan->headerCellClass() ?>"><div id="elh_lokasalrujukan_Rujukan" class="lokasalrujukan_Rujukan"><div class="ew-table-header-caption"><?php echo $lokasalrujukan->Rujukan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rujukan" class="<?php echo $lokasalrujukan->Rujukan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokasalrujukan->SortUrl($lokasalrujukan->Rujukan) ?>',2);"><div id="elh_lokasalrujukan_Rujukan" class="lokasalrujukan_Rujukan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokasalrujukan->Rujukan->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokasalrujukan->Rujukan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokasalrujukan->Rujukan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokasalrujukan_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokasalrujukan->ExportAll && $lokasalrujukan->isExport()) {
	$lokasalrujukan_list->StopRec = $lokasalrujukan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokasalrujukan_list->TotalRecs > $lokasalrujukan_list->StartRec + $lokasalrujukan_list->DisplayRecs - 1)
		$lokasalrujukan_list->StopRec = $lokasalrujukan_list->StartRec + $lokasalrujukan_list->DisplayRecs - 1;
	else
		$lokasalrujukan_list->StopRec = $lokasalrujukan_list->TotalRecs;
}
$lokasalrujukan_list->RecCnt = $lokasalrujukan_list->StartRec - 1;
if ($lokasalrujukan_list->Recordset && !$lokasalrujukan_list->Recordset->EOF) {
	$lokasalrujukan_list->Recordset->moveFirst();
	$selectLimit = $lokasalrujukan_list->UseSelectLimit;
	if (!$selectLimit && $lokasalrujukan_list->StartRec > 1)
		$lokasalrujukan_list->Recordset->move($lokasalrujukan_list->StartRec - 1);
} elseif (!$lokasalrujukan->AllowAddDeleteRow && $lokasalrujukan_list->StopRec == 0) {
	$lokasalrujukan_list->StopRec = $lokasalrujukan->GridAddRowCount;
}

// Initialize aggregate
$lokasalrujukan->RowType = ROWTYPE_AGGREGATEINIT;
$lokasalrujukan->resetAttributes();
$lokasalrujukan_list->renderRow();
while ($lokasalrujukan_list->RecCnt < $lokasalrujukan_list->StopRec) {
	$lokasalrujukan_list->RecCnt++;
	if ($lokasalrujukan_list->RecCnt >= $lokasalrujukan_list->StartRec) {
		$lokasalrujukan_list->RowCnt++;

		// Set up key count
		$lokasalrujukan_list->KeyCount = $lokasalrujukan_list->RowIndex;

		// Init row class and style
		$lokasalrujukan->resetAttributes();
		$lokasalrujukan->CssClass = "";
		if ($lokasalrujukan->isGridAdd()) {
		} else {
			$lokasalrujukan_list->loadRowValues($lokasalrujukan_list->Recordset); // Load row values
		}
		$lokasalrujukan->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokasalrujukan->RowAttrs = array_merge($lokasalrujukan->RowAttrs, array('data-rowindex'=>$lokasalrujukan_list->RowCnt, 'id'=>'r' . $lokasalrujukan_list->RowCnt . '_lokasalrujukan', 'data-rowtype'=>$lokasalrujukan->RowType));

		// Render row
		$lokasalrujukan_list->renderRow();

		// Render list options
		$lokasalrujukan_list->renderListOptions();
?>
	<tr<?php echo $lokasalrujukan->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokasalrujukan_list->ListOptions->render("body", "left", $lokasalrujukan_list->RowCnt);
?>
	<?php if ($lokasalrujukan->Id_Rujukan->Visible) { // Id_Rujukan ?>
		<td data-name="Id_Rujukan"<?php echo $lokasalrujukan->Id_Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokasalrujukan_list->RowCnt ?>_lokasalrujukan_Id_Rujukan" class="lokasalrujukan_Id_Rujukan">
<span<?php echo $lokasalrujukan->Id_Rujukan->viewAttributes() ?>>
<?php echo $lokasalrujukan->Id_Rujukan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokasalrujukan->Rujukan->Visible) { // Rujukan ?>
		<td data-name="Rujukan"<?php echo $lokasalrujukan->Rujukan->cellAttributes() ?>>
<span id="el<?php echo $lokasalrujukan_list->RowCnt ?>_lokasalrujukan_Rujukan" class="lokasalrujukan_Rujukan">
<span<?php echo $lokasalrujukan->Rujukan->viewAttributes() ?>>
<?php echo $lokasalrujukan->Rujukan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokasalrujukan_list->ListOptions->render("body", "right", $lokasalrujukan_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokasalrujukan->isGridAdd())
		$lokasalrujukan_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokasalrujukan->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokasalrujukan_list->Recordset)
	$lokasalrujukan_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokasalrujukan_list->TotalRecs == 0 && !$lokasalrujukan->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokasalrujukan_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokasalrujukan_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokasalrujukan->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokasalrujukan_list->terminate();
?>