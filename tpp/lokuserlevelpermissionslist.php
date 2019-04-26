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
$lokuserlevelpermissions_list = new lokuserlevelpermissions_list();

// Run the page
$lokuserlevelpermissions_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokuserlevelpermissions_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokuserlevelpermissions->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokuserlevelpermissionslist = currentForm = new ew.Form("flokuserlevelpermissionslist", "list");
flokuserlevelpermissionslist.formKeyCountName = '<?php echo $lokuserlevelpermissions_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokuserlevelpermissionslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokuserlevelpermissionslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokuserlevelpermissions->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokuserlevelpermissions_list->TotalRecs > 0 && $lokuserlevelpermissions_list->ExportOptions->visible()) { ?>
<?php $lokuserlevelpermissions_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokuserlevelpermissions_list->ImportOptions->visible()) { ?>
<?php $lokuserlevelpermissions_list->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokuserlevelpermissions_list->renderOtherOptions();
?>
<?php $lokuserlevelpermissions_list->showPageHeader(); ?>
<?php
$lokuserlevelpermissions_list->showMessage();
?>
<?php if ($lokuserlevelpermissions_list->TotalRecs > 0 || $lokuserlevelpermissions->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokuserlevelpermissions_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokuserlevelpermissions">
<?php if (!$lokuserlevelpermissions->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokuserlevelpermissions->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokuserlevelpermissions_list->Pager)) $lokuserlevelpermissions_list->Pager = new PrevNextPager($lokuserlevelpermissions_list->StartRec, $lokuserlevelpermissions_list->DisplayRecs, $lokuserlevelpermissions_list->TotalRecs, $lokuserlevelpermissions_list->AutoHidePager) ?>
<?php if ($lokuserlevelpermissions_list->Pager->RecordCount > 0 && $lokuserlevelpermissions_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokuserlevelpermissions_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokuserlevelpermissions_list->pageUrl() ?>start=<?php echo $lokuserlevelpermissions_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokuserlevelpermissions_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokuserlevelpermissions_list->pageUrl() ?>start=<?php echo $lokuserlevelpermissions_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokuserlevelpermissions_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokuserlevelpermissions_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokuserlevelpermissions_list->pageUrl() ?>start=<?php echo $lokuserlevelpermissions_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokuserlevelpermissions_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokuserlevelpermissions_list->pageUrl() ?>start=<?php echo $lokuserlevelpermissions_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokuserlevelpermissions_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokuserlevelpermissions_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokuserlevelpermissions_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokuserlevelpermissions_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokuserlevelpermissions_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokuserlevelpermissions_list->TotalRecs > 0 && (!$lokuserlevelpermissions_list->AutoHidePageSizeSelector || $lokuserlevelpermissions_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokuserlevelpermissions">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokuserlevelpermissions_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokuserlevelpermissions->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokuserlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokuserlevelpermissionslist" id="flokuserlevelpermissionslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokuserlevelpermissions_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokuserlevelpermissions_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevelpermissions">
<div id="gmp_lokuserlevelpermissions" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokuserlevelpermissions_list->TotalRecs > 0 || $lokuserlevelpermissions->isGridEdit()) { ?>
<table id="tbl_lokuserlevelpermissionslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokuserlevelpermissions_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokuserlevelpermissions_list->renderListOptions();

// Render list options (header, left)
$lokuserlevelpermissions_list->ListOptions->render("header", "left");
?>
<?php if ($lokuserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
	<?php if ($lokuserlevelpermissions->sortUrl($lokuserlevelpermissions->userlevelid) == "") { ?>
		<th data-name="userlevelid" class="<?php echo $lokuserlevelpermissions->userlevelid->headerCellClass() ?>"><div id="elh_lokuserlevelpermissions_userlevelid" class="lokuserlevelpermissions_userlevelid"><div class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->userlevelid->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelid" class="<?php echo $lokuserlevelpermissions->userlevelid->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokuserlevelpermissions->SortUrl($lokuserlevelpermissions->userlevelid) ?>',2);"><div id="elh_lokuserlevelpermissions_userlevelid" class="lokuserlevelpermissions_userlevelid">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->userlevelid->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokuserlevelpermissions->userlevelid->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokuserlevelpermissions->userlevelid->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokuserlevelpermissions->_tablename->Visible) { // tablename ?>
	<?php if ($lokuserlevelpermissions->sortUrl($lokuserlevelpermissions->_tablename) == "") { ?>
		<th data-name="_tablename" class="<?php echo $lokuserlevelpermissions->_tablename->headerCellClass() ?>"><div id="elh_lokuserlevelpermissions__tablename" class="lokuserlevelpermissions__tablename"><div class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->_tablename->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_tablename" class="<?php echo $lokuserlevelpermissions->_tablename->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokuserlevelpermissions->SortUrl($lokuserlevelpermissions->_tablename) ?>',2);"><div id="elh_lokuserlevelpermissions__tablename" class="lokuserlevelpermissions__tablename">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->_tablename->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokuserlevelpermissions->_tablename->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokuserlevelpermissions->_tablename->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokuserlevelpermissions->permission->Visible) { // permission ?>
	<?php if ($lokuserlevelpermissions->sortUrl($lokuserlevelpermissions->permission) == "") { ?>
		<th data-name="permission" class="<?php echo $lokuserlevelpermissions->permission->headerCellClass() ?>"><div id="elh_lokuserlevelpermissions_permission" class="lokuserlevelpermissions_permission"><div class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->permission->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="permission" class="<?php echo $lokuserlevelpermissions->permission->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokuserlevelpermissions->SortUrl($lokuserlevelpermissions->permission) ?>',2);"><div id="elh_lokuserlevelpermissions_permission" class="lokuserlevelpermissions_permission">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokuserlevelpermissions->permission->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokuserlevelpermissions->permission->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokuserlevelpermissions->permission->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokuserlevelpermissions_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokuserlevelpermissions->ExportAll && $lokuserlevelpermissions->isExport()) {
	$lokuserlevelpermissions_list->StopRec = $lokuserlevelpermissions_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokuserlevelpermissions_list->TotalRecs > $lokuserlevelpermissions_list->StartRec + $lokuserlevelpermissions_list->DisplayRecs - 1)
		$lokuserlevelpermissions_list->StopRec = $lokuserlevelpermissions_list->StartRec + $lokuserlevelpermissions_list->DisplayRecs - 1;
	else
		$lokuserlevelpermissions_list->StopRec = $lokuserlevelpermissions_list->TotalRecs;
}
$lokuserlevelpermissions_list->RecCnt = $lokuserlevelpermissions_list->StartRec - 1;
if ($lokuserlevelpermissions_list->Recordset && !$lokuserlevelpermissions_list->Recordset->EOF) {
	$lokuserlevelpermissions_list->Recordset->moveFirst();
	$selectLimit = $lokuserlevelpermissions_list->UseSelectLimit;
	if (!$selectLimit && $lokuserlevelpermissions_list->StartRec > 1)
		$lokuserlevelpermissions_list->Recordset->move($lokuserlevelpermissions_list->StartRec - 1);
} elseif (!$lokuserlevelpermissions->AllowAddDeleteRow && $lokuserlevelpermissions_list->StopRec == 0) {
	$lokuserlevelpermissions_list->StopRec = $lokuserlevelpermissions->GridAddRowCount;
}

// Initialize aggregate
$lokuserlevelpermissions->RowType = ROWTYPE_AGGREGATEINIT;
$lokuserlevelpermissions->resetAttributes();
$lokuserlevelpermissions_list->renderRow();
while ($lokuserlevelpermissions_list->RecCnt < $lokuserlevelpermissions_list->StopRec) {
	$lokuserlevelpermissions_list->RecCnt++;
	if ($lokuserlevelpermissions_list->RecCnt >= $lokuserlevelpermissions_list->StartRec) {
		$lokuserlevelpermissions_list->RowCnt++;

		// Set up key count
		$lokuserlevelpermissions_list->KeyCount = $lokuserlevelpermissions_list->RowIndex;

		// Init row class and style
		$lokuserlevelpermissions->resetAttributes();
		$lokuserlevelpermissions->CssClass = "";
		if ($lokuserlevelpermissions->isGridAdd()) {
		} else {
			$lokuserlevelpermissions_list->loadRowValues($lokuserlevelpermissions_list->Recordset); // Load row values
		}
		$lokuserlevelpermissions->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokuserlevelpermissions->RowAttrs = array_merge($lokuserlevelpermissions->RowAttrs, array('data-rowindex'=>$lokuserlevelpermissions_list->RowCnt, 'id'=>'r' . $lokuserlevelpermissions_list->RowCnt . '_lokuserlevelpermissions', 'data-rowtype'=>$lokuserlevelpermissions->RowType));

		// Render row
		$lokuserlevelpermissions_list->renderRow();

		// Render list options
		$lokuserlevelpermissions_list->renderListOptions();
?>
	<tr<?php echo $lokuserlevelpermissions->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokuserlevelpermissions_list->ListOptions->render("body", "left", $lokuserlevelpermissions_list->RowCnt);
?>
	<?php if ($lokuserlevelpermissions->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid"<?php echo $lokuserlevelpermissions->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevelpermissions_list->RowCnt ?>_lokuserlevelpermissions_userlevelid" class="lokuserlevelpermissions_userlevelid">
<span<?php echo $lokuserlevelpermissions->userlevelid->viewAttributes() ?>>
<?php echo $lokuserlevelpermissions->userlevelid->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokuserlevelpermissions->_tablename->Visible) { // tablename ?>
		<td data-name="_tablename"<?php echo $lokuserlevelpermissions->_tablename->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevelpermissions_list->RowCnt ?>_lokuserlevelpermissions__tablename" class="lokuserlevelpermissions__tablename">
<span<?php echo $lokuserlevelpermissions->_tablename->viewAttributes() ?>>
<?php echo $lokuserlevelpermissions->_tablename->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokuserlevelpermissions->permission->Visible) { // permission ?>
		<td data-name="permission"<?php echo $lokuserlevelpermissions->permission->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevelpermissions_list->RowCnt ?>_lokuserlevelpermissions_permission" class="lokuserlevelpermissions_permission">
<span<?php echo $lokuserlevelpermissions->permission->viewAttributes() ?>>
<?php echo $lokuserlevelpermissions->permission->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokuserlevelpermissions_list->ListOptions->render("body", "right", $lokuserlevelpermissions_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokuserlevelpermissions->isGridAdd())
		$lokuserlevelpermissions_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokuserlevelpermissions->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokuserlevelpermissions_list->Recordset)
	$lokuserlevelpermissions_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokuserlevelpermissions_list->TotalRecs == 0 && !$lokuserlevelpermissions->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokuserlevelpermissions_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokuserlevelpermissions_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokuserlevelpermissions->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokuserlevelpermissions_list->terminate();
?>