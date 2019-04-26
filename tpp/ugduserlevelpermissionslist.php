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
$ugduserlevelpermissions_list = new ugduserlevelpermissions_list();

// Run the page
$ugduserlevelpermissions_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ugduserlevelpermissions_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fugduserlevelpermissionslist = currentForm = new ew.Form("fugduserlevelpermissionslist", "list");
fugduserlevelpermissionslist.formKeyCountName = '<?php echo $ugduserlevelpermissions_list->FormKeyCountName ?>';

// Form_CustomValidate event
fugduserlevelpermissionslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fugduserlevelpermissionslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fugduserlevelpermissionslistsrch = currentSearchForm = new ew.Form("fugduserlevelpermissionslistsrch");

// Filters
fugduserlevelpermissionslistsrch.filterList = <?php echo $ugduserlevelpermissions_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($ugduserlevelpermissions_list->TotalRecs > 0 && $ugduserlevelpermissions_list->ExportOptions->visible()) { ?>
<?php $ugduserlevelpermissions_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($ugduserlevelpermissions_list->ImportOptions->visible()) { ?>
<?php $ugduserlevelpermissions_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($ugduserlevelpermissions_list->SearchOptions->visible()) { ?>
<?php $ugduserlevelpermissions_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($ugduserlevelpermissions_list->FilterOptions->visible()) { ?>
<?php $ugduserlevelpermissions_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$ugduserlevelpermissions_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$ugduserlevelpermissions->isExport() && !$ugduserlevelpermissions->CurrentAction) { ?>
<form name="fugduserlevelpermissionslistsrch" id="fugduserlevelpermissionslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($ugduserlevelpermissions_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fugduserlevelpermissionslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="ugduserlevelpermissions">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($ugduserlevelpermissions_list->BasicSearch->getKeyword()) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($ugduserlevelpermissions_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $ugduserlevelpermissions_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($ugduserlevelpermissions_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($ugduserlevelpermissions_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($ugduserlevelpermissions_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($ugduserlevelpermissions_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $ugduserlevelpermissions_list->showPageHeader(); ?>
<?php
$ugduserlevelpermissions_list->showMessage();
?>
<?php if ($ugduserlevelpermissions_list->TotalRecs > 0 || $ugduserlevelpermissions->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($ugduserlevelpermissions_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> ugduserlevelpermissions">
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$ugduserlevelpermissions->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($ugduserlevelpermissions_list->Pager)) $ugduserlevelpermissions_list->Pager = new PrevNextPager($ugduserlevelpermissions_list->StartRec, $ugduserlevelpermissions_list->DisplayRecs, $ugduserlevelpermissions_list->TotalRecs, $ugduserlevelpermissions_list->AutoHidePager) ?>
<?php if ($ugduserlevelpermissions_list->Pager->RecordCount > 0 && $ugduserlevelpermissions_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($ugduserlevelpermissions_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $ugduserlevelpermissions_list->pageUrl() ?>start=<?php echo $ugduserlevelpermissions_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($ugduserlevelpermissions_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $ugduserlevelpermissions_list->pageUrl() ?>start=<?php echo $ugduserlevelpermissions_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $ugduserlevelpermissions_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($ugduserlevelpermissions_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $ugduserlevelpermissions_list->pageUrl() ?>start=<?php echo $ugduserlevelpermissions_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($ugduserlevelpermissions_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $ugduserlevelpermissions_list->pageUrl() ?>start=<?php echo $ugduserlevelpermissions_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $ugduserlevelpermissions_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($ugduserlevelpermissions_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $ugduserlevelpermissions_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $ugduserlevelpermissions_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $ugduserlevelpermissions_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($ugduserlevelpermissions_list->TotalRecs > 0 && (!$ugduserlevelpermissions_list->AutoHidePageSizeSelector || $ugduserlevelpermissions_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="ugduserlevelpermissions">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($ugduserlevelpermissions_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($ugduserlevelpermissions->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $ugduserlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fugduserlevelpermissionslist" id="fugduserlevelpermissionslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($ugduserlevelpermissions_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $ugduserlevelpermissions_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ugduserlevelpermissions">
<div id="gmp_ugduserlevelpermissions" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($ugduserlevelpermissions_list->TotalRecs > 0 || $ugduserlevelpermissions->isGridEdit()) { ?>
<table id="tbl_ugduserlevelpermissionslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$ugduserlevelpermissions_list->RowType = ROWTYPE_HEADER;

// Render list options
$ugduserlevelpermissions_list->renderListOptions();

// Render list options (header, left)
$ugduserlevelpermissions_list->ListOptions->render("header", "left");
?>
<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
	<?php if ($ugduserlevelpermissions->sortUrl($ugduserlevelpermissions->userlevelid) == "") { ?>
		<th data-name="userlevelid" class="<?php echo $ugduserlevelpermissions->userlevelid->headerCellClass() ?>"><div id="elh_ugduserlevelpermissions_userlevelid" class="ugduserlevelpermissions_userlevelid"><div class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelid" class="<?php echo $ugduserlevelpermissions->userlevelid->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugduserlevelpermissions->SortUrl($ugduserlevelpermissions->userlevelid) ?>',2);"><div id="elh_ugduserlevelpermissions_userlevelid" class="ugduserlevelpermissions_userlevelid">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->userlevelid->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugduserlevelpermissions->userlevelid->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugduserlevelpermissions->userlevelid->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
	<?php if ($ugduserlevelpermissions->sortUrl($ugduserlevelpermissions->_tablename) == "") { ?>
		<th data-name="_tablename" class="<?php echo $ugduserlevelpermissions->_tablename->headerCellClass() ?>"><div id="elh_ugduserlevelpermissions__tablename" class="ugduserlevelpermissions__tablename"><div class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->_tablename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_tablename" class="<?php echo $ugduserlevelpermissions->_tablename->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugduserlevelpermissions->SortUrl($ugduserlevelpermissions->_tablename) ?>',2);"><div id="elh_ugduserlevelpermissions__tablename" class="ugduserlevelpermissions__tablename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->_tablename->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($ugduserlevelpermissions->_tablename->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugduserlevelpermissions->_tablename->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
	<?php if ($ugduserlevelpermissions->sortUrl($ugduserlevelpermissions->permission) == "") { ?>
		<th data-name="permission" class="<?php echo $ugduserlevelpermissions->permission->headerCellClass() ?>"><div id="elh_ugduserlevelpermissions_permission" class="ugduserlevelpermissions_permission"><div class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->permission->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="permission" class="<?php echo $ugduserlevelpermissions->permission->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $ugduserlevelpermissions->SortUrl($ugduserlevelpermissions->permission) ?>',2);"><div id="elh_ugduserlevelpermissions_permission" class="ugduserlevelpermissions_permission">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $ugduserlevelpermissions->permission->caption() ?></span><span class="ew-table-header-sort"><?php if ($ugduserlevelpermissions->permission->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($ugduserlevelpermissions->permission->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$ugduserlevelpermissions_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($ugduserlevelpermissions->ExportAll && $ugduserlevelpermissions->isExport()) {
	$ugduserlevelpermissions_list->StopRec = $ugduserlevelpermissions_list->TotalRecs;
} else {

	// Set the last record to display
	if ($ugduserlevelpermissions_list->TotalRecs > $ugduserlevelpermissions_list->StartRec + $ugduserlevelpermissions_list->DisplayRecs - 1)
		$ugduserlevelpermissions_list->StopRec = $ugduserlevelpermissions_list->StartRec + $ugduserlevelpermissions_list->DisplayRecs - 1;
	else
		$ugduserlevelpermissions_list->StopRec = $ugduserlevelpermissions_list->TotalRecs;
}
$ugduserlevelpermissions_list->RecCnt = $ugduserlevelpermissions_list->StartRec - 1;
if ($ugduserlevelpermissions_list->Recordset && !$ugduserlevelpermissions_list->Recordset->EOF) {
	$ugduserlevelpermissions_list->Recordset->moveFirst();
	$selectLimit = $ugduserlevelpermissions_list->UseSelectLimit;
	if (!$selectLimit && $ugduserlevelpermissions_list->StartRec > 1)
		$ugduserlevelpermissions_list->Recordset->move($ugduserlevelpermissions_list->StartRec - 1);
} elseif (!$ugduserlevelpermissions->AllowAddDeleteRow && $ugduserlevelpermissions_list->StopRec == 0) {
	$ugduserlevelpermissions_list->StopRec = $ugduserlevelpermissions->GridAddRowCount;
}

// Initialize aggregate
$ugduserlevelpermissions->RowType = ROWTYPE_AGGREGATEINIT;
$ugduserlevelpermissions->resetAttributes();
$ugduserlevelpermissions_list->renderRow();
while ($ugduserlevelpermissions_list->RecCnt < $ugduserlevelpermissions_list->StopRec) {
	$ugduserlevelpermissions_list->RecCnt++;
	if ($ugduserlevelpermissions_list->RecCnt >= $ugduserlevelpermissions_list->StartRec) {
		$ugduserlevelpermissions_list->RowCnt++;

		// Set up key count
		$ugduserlevelpermissions_list->KeyCount = $ugduserlevelpermissions_list->RowIndex;

		// Init row class and style
		$ugduserlevelpermissions->resetAttributes();
		$ugduserlevelpermissions->CssClass = "";
		if ($ugduserlevelpermissions->isGridAdd()) {
		} else {
			$ugduserlevelpermissions_list->loadRowValues($ugduserlevelpermissions_list->Recordset); // Load row values
		}
		$ugduserlevelpermissions->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$ugduserlevelpermissions->RowAttrs = array_merge($ugduserlevelpermissions->RowAttrs, array('data-rowindex'=>$ugduserlevelpermissions_list->RowCnt, 'id'=>'r' . $ugduserlevelpermissions_list->RowCnt . '_ugduserlevelpermissions', 'data-rowtype'=>$ugduserlevelpermissions->RowType));

		// Render row
		$ugduserlevelpermissions_list->renderRow();

		// Render list options
		$ugduserlevelpermissions_list->renderListOptions();
?>
	<tr<?php echo $ugduserlevelpermissions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$ugduserlevelpermissions_list->ListOptions->render("body", "left", $ugduserlevelpermissions_list->RowCnt);
?>
	<?php if ($ugduserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid"<?php echo $ugduserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_list->RowCnt ?>_ugduserlevelpermissions_userlevelid" class="ugduserlevelpermissions_userlevelid">
<span<?php echo $ugduserlevelpermissions->userlevelid->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->userlevelid->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugduserlevelpermissions->_tablename->Visible) { // tablename ?>
		<td data-name="_tablename"<?php echo $ugduserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_list->RowCnt ?>_ugduserlevelpermissions__tablename" class="ugduserlevelpermissions__tablename">
<span<?php echo $ugduserlevelpermissions->_tablename->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->_tablename->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($ugduserlevelpermissions->permission->Visible) { // permission ?>
		<td data-name="permission"<?php echo $ugduserlevelpermissions->permission->cellAttributes() ?>>
<span id="el<?php echo $ugduserlevelpermissions_list->RowCnt ?>_ugduserlevelpermissions_permission" class="ugduserlevelpermissions_permission">
<span<?php echo $ugduserlevelpermissions->permission->viewAttributes() ?>>
<?php echo $ugduserlevelpermissions->permission->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$ugduserlevelpermissions_list->ListOptions->render("body", "right", $ugduserlevelpermissions_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$ugduserlevelpermissions->isGridAdd())
		$ugduserlevelpermissions_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$ugduserlevelpermissions->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($ugduserlevelpermissions_list->Recordset)
	$ugduserlevelpermissions_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($ugduserlevelpermissions_list->TotalRecs == 0 && !$ugduserlevelpermissions->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $ugduserlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$ugduserlevelpermissions_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$ugduserlevelpermissions->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$ugduserlevelpermissions_list->terminate();
?>