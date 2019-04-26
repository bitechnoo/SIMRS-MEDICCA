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
$lokjenispasien_list = new lokjenispasien_list();

// Run the page
$lokjenispasien_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokjenispasien_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokjenispasien->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokjenispasienlist = currentForm = new ew.Form("flokjenispasienlist", "list");
flokjenispasienlist.formKeyCountName = '<?php echo $lokjenispasien_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokjenispasienlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokjenispasienlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var flokjenispasienlistsrch = currentSearchForm = new ew.Form("flokjenispasienlistsrch");

// Filters
flokjenispasienlistsrch.filterList = <?php echo $lokjenispasien_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokjenispasien->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokjenispasien_list->TotalRecs > 0 && $lokjenispasien_list->ExportOptions->visible()) { ?>
<?php $lokjenispasien_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokjenispasien_list->ImportOptions->visible()) { ?>
<?php $lokjenispasien_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($lokjenispasien_list->SearchOptions->visible()) { ?>
<?php $lokjenispasien_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($lokjenispasien_list->FilterOptions->visible()) { ?>
<?php $lokjenispasien_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokjenispasien_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$lokjenispasien->isExport() && !$lokjenispasien->CurrentAction) { ?>
<form name="flokjenispasienlistsrch" id="flokjenispasienlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($lokjenispasien_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flokjenispasienlistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="lokjenispasien">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($lokjenispasien_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($lokjenispasien_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $lokjenispasien_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($lokjenispasien_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($lokjenispasien_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($lokjenispasien_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($lokjenispasien_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $lokjenispasien_list->showPageHeader(); ?>
<?php
$lokjenispasien_list->showMessage();
?>
<?php if ($lokjenispasien_list->TotalRecs > 0 || $lokjenispasien->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokjenispasien_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokjenispasien">
<?php if (!$lokjenispasien->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokjenispasien->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokjenispasien_list->Pager)) $lokjenispasien_list->Pager = new PrevNextPager($lokjenispasien_list->StartRec, $lokjenispasien_list->DisplayRecs, $lokjenispasien_list->TotalRecs, $lokjenispasien_list->AutoHidePager) ?>
<?php if ($lokjenispasien_list->Pager->RecordCount > 0 && $lokjenispasien_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokjenispasien_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokjenispasien_list->pageUrl() ?>start=<?php echo $lokjenispasien_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokjenispasien_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokjenispasien_list->pageUrl() ?>start=<?php echo $lokjenispasien_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokjenispasien_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokjenispasien_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokjenispasien_list->pageUrl() ?>start=<?php echo $lokjenispasien_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokjenispasien_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokjenispasien_list->pageUrl() ?>start=<?php echo $lokjenispasien_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokjenispasien_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokjenispasien_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokjenispasien_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokjenispasien_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokjenispasien_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokjenispasien_list->TotalRecs > 0 && (!$lokjenispasien_list->AutoHidePageSizeSelector || $lokjenispasien_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokjenispasien">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokjenispasien_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokjenispasien_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokjenispasien_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokjenispasien_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokjenispasien_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokjenispasien_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokjenispasien_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokjenispasien->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokjenispasien_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokjenispasienlist" id="flokjenispasienlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokjenispasien_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokjenispasien_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokjenispasien">
<div id="gmp_lokjenispasien" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokjenispasien_list->TotalRecs > 0 || $lokjenispasien->isGridEdit()) { ?>
<table id="tbl_lokjenispasienlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokjenispasien_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokjenispasien_list->renderListOptions();

// Render list options (header, left)
$lokjenispasien_list->ListOptions->render("header", "left");
?>
<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
	<?php if ($lokjenispasien->sortUrl($lokjenispasien->Id_JenisPasien) == "") { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $lokjenispasien->Id_JenisPasien->headerCellClass() ?>"><div id="elh_lokjenispasien_Id_JenisPasien" class="lokjenispasien_Id_JenisPasien"><div class="ew-table-header-caption"><?php echo $lokjenispasien->Id_JenisPasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_JenisPasien" class="<?php echo $lokjenispasien->Id_JenisPasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokjenispasien->SortUrl($lokjenispasien->Id_JenisPasien) ?>',2);"><div id="elh_lokjenispasien_Id_JenisPasien" class="lokjenispasien_Id_JenisPasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokjenispasien->Id_JenisPasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokjenispasien->Id_JenisPasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokjenispasien->Id_JenisPasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
	<?php if ($lokjenispasien->sortUrl($lokjenispasien->Jenis_Pasien) == "") { ?>
		<th data-name="Jenis_Pasien" class="<?php echo $lokjenispasien->Jenis_Pasien->headerCellClass() ?>"><div id="elh_lokjenispasien_Jenis_Pasien" class="lokjenispasien_Jenis_Pasien"><div class="ew-table-header-caption"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Jenis_Pasien" class="<?php echo $lokjenispasien->Jenis_Pasien->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokjenispasien->SortUrl($lokjenispasien->Jenis_Pasien) ?>',2);"><div id="elh_lokjenispasien_Jenis_Pasien" class="lokjenispasien_Jenis_Pasien">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokjenispasien->Jenis_Pasien->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($lokjenispasien->Jenis_Pasien->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokjenispasien->Jenis_Pasien->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokjenispasien_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokjenispasien->ExportAll && $lokjenispasien->isExport()) {
	$lokjenispasien_list->StopRec = $lokjenispasien_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokjenispasien_list->TotalRecs > $lokjenispasien_list->StartRec + $lokjenispasien_list->DisplayRecs - 1)
		$lokjenispasien_list->StopRec = $lokjenispasien_list->StartRec + $lokjenispasien_list->DisplayRecs - 1;
	else
		$lokjenispasien_list->StopRec = $lokjenispasien_list->TotalRecs;
}
$lokjenispasien_list->RecCnt = $lokjenispasien_list->StartRec - 1;
if ($lokjenispasien_list->Recordset && !$lokjenispasien_list->Recordset->EOF) {
	$lokjenispasien_list->Recordset->moveFirst();
	$selectLimit = $lokjenispasien_list->UseSelectLimit;
	if (!$selectLimit && $lokjenispasien_list->StartRec > 1)
		$lokjenispasien_list->Recordset->move($lokjenispasien_list->StartRec - 1);
} elseif (!$lokjenispasien->AllowAddDeleteRow && $lokjenispasien_list->StopRec == 0) {
	$lokjenispasien_list->StopRec = $lokjenispasien->GridAddRowCount;
}

// Initialize aggregate
$lokjenispasien->RowType = ROWTYPE_AGGREGATEINIT;
$lokjenispasien->resetAttributes();
$lokjenispasien_list->renderRow();
while ($lokjenispasien_list->RecCnt < $lokjenispasien_list->StopRec) {
	$lokjenispasien_list->RecCnt++;
	if ($lokjenispasien_list->RecCnt >= $lokjenispasien_list->StartRec) {
		$lokjenispasien_list->RowCnt++;

		// Set up key count
		$lokjenispasien_list->KeyCount = $lokjenispasien_list->RowIndex;

		// Init row class and style
		$lokjenispasien->resetAttributes();
		$lokjenispasien->CssClass = "";
		if ($lokjenispasien->isGridAdd()) {
		} else {
			$lokjenispasien_list->loadRowValues($lokjenispasien_list->Recordset); // Load row values
		}
		$lokjenispasien->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokjenispasien->RowAttrs = array_merge($lokjenispasien->RowAttrs, array('data-rowindex'=>$lokjenispasien_list->RowCnt, 'id'=>'r' . $lokjenispasien_list->RowCnt . '_lokjenispasien', 'data-rowtype'=>$lokjenispasien->RowType));

		// Render row
		$lokjenispasien_list->renderRow();

		// Render list options
		$lokjenispasien_list->renderListOptions();
?>
	<tr<?php echo $lokjenispasien->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokjenispasien_list->ListOptions->render("body", "left", $lokjenispasien_list->RowCnt);
?>
	<?php if ($lokjenispasien->Id_JenisPasien->Visible) { // Id_JenisPasien ?>
		<td data-name="Id_JenisPasien"<?php echo $lokjenispasien->Id_JenisPasien->cellAttributes() ?>>
<span id="el<?php echo $lokjenispasien_list->RowCnt ?>_lokjenispasien_Id_JenisPasien" class="lokjenispasien_Id_JenisPasien">
<span<?php echo $lokjenispasien->Id_JenisPasien->viewAttributes() ?>>
<?php echo $lokjenispasien->Id_JenisPasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokjenispasien->Jenis_Pasien->Visible) { // Jenis_Pasien ?>
		<td data-name="Jenis_Pasien"<?php echo $lokjenispasien->Jenis_Pasien->cellAttributes() ?>>
<span id="el<?php echo $lokjenispasien_list->RowCnt ?>_lokjenispasien_Jenis_Pasien" class="lokjenispasien_Jenis_Pasien">
<span<?php echo $lokjenispasien->Jenis_Pasien->viewAttributes() ?>>
<?php echo $lokjenispasien->Jenis_Pasien->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokjenispasien_list->ListOptions->render("body", "right", $lokjenispasien_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokjenispasien->isGridAdd())
		$lokjenispasien_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokjenispasien->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokjenispasien_list->Recordset)
	$lokjenispasien_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokjenispasien_list->TotalRecs == 0 && !$lokjenispasien->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokjenispasien_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokjenispasien_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokjenispasien->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokjenispasien_list->terminate();
?>