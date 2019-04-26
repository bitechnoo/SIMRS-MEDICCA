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
$lokuserlevels_list = new lokuserlevels_list();

// Run the page
$lokuserlevels_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokuserlevels_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokuserlevels->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokuserlevelslist = currentForm = new ew.Form("flokuserlevelslist", "list");
flokuserlevelslist.formKeyCountName = '<?php echo $lokuserlevels_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokuserlevelslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokuserlevelslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokuserlevels->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokuserlevels_list->TotalRecs > 0 && $lokuserlevels_list->ExportOptions->visible()) { ?>
<?php $lokuserlevels_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokuserlevels_list->ImportOptions->visible()) { ?>
<?php $lokuserlevels_list->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokuserlevels_list->renderOtherOptions();
?>
<?php $lokuserlevels_list->showPageHeader(); ?>
<?php
$lokuserlevels_list->showMessage();
?>
<?php if ($lokuserlevels_list->TotalRecs > 0 || $lokuserlevels->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokuserlevels_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokuserlevels">
<?php if (!$lokuserlevels->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokuserlevels->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokuserlevels_list->Pager)) $lokuserlevels_list->Pager = new PrevNextPager($lokuserlevels_list->StartRec, $lokuserlevels_list->DisplayRecs, $lokuserlevels_list->TotalRecs, $lokuserlevels_list->AutoHidePager) ?>
<?php if ($lokuserlevels_list->Pager->RecordCount > 0 && $lokuserlevels_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokuserlevels_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokuserlevels_list->pageUrl() ?>start=<?php echo $lokuserlevels_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokuserlevels_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokuserlevels_list->pageUrl() ?>start=<?php echo $lokuserlevels_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokuserlevels_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokuserlevels_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokuserlevels_list->pageUrl() ?>start=<?php echo $lokuserlevels_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokuserlevels_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokuserlevels_list->pageUrl() ?>start=<?php echo $lokuserlevels_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokuserlevels_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokuserlevels_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokuserlevels_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokuserlevels_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokuserlevels_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokuserlevels_list->TotalRecs > 0 && (!$lokuserlevels_list->AutoHidePageSizeSelector || $lokuserlevels_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokuserlevels">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokuserlevels_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokuserlevels_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokuserlevels_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokuserlevels_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokuserlevels_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokuserlevels_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokuserlevels_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokuserlevels->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokuserlevels_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokuserlevelslist" id="flokuserlevelslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokuserlevels_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokuserlevels_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevels">
<div id="gmp_lokuserlevels" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokuserlevels_list->TotalRecs > 0 || $lokuserlevels->isGridEdit()) { ?>
<table id="tbl_lokuserlevelslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokuserlevels_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokuserlevels_list->renderListOptions();

// Render list options (header, left)
$lokuserlevels_list->ListOptions->render("header", "left");
?>
<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
	<?php if ($lokuserlevels->sortUrl($lokuserlevels->userlevelid) == "") { ?>
		<th data-name="userlevelid" class="<?php echo $lokuserlevels->userlevelid->headerCellClass() ?>"><div id="elh_lokuserlevels_userlevelid" class="lokuserlevels_userlevelid"><div class="ew-table-header-caption"><?php echo $lokuserlevels->userlevelid->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelid" class="<?php echo $lokuserlevels->userlevelid->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokuserlevels->SortUrl($lokuserlevels->userlevelid) ?>',2);"><div id="elh_lokuserlevels_userlevelid" class="lokuserlevels_userlevelid">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokuserlevels->userlevelid->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokuserlevels->userlevelid->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokuserlevels->userlevelid->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
	<?php if ($lokuserlevels->sortUrl($lokuserlevels->userlevelname) == "") { ?>
		<th data-name="userlevelname" class="<?php echo $lokuserlevels->userlevelname->headerCellClass() ?>"><div id="elh_lokuserlevels_userlevelname" class="lokuserlevels_userlevelname"><div class="ew-table-header-caption"><?php echo $lokuserlevels->userlevelname->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="userlevelname" class="<?php echo $lokuserlevels->userlevelname->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokuserlevels->SortUrl($lokuserlevels->userlevelname) ?>',2);"><div id="elh_lokuserlevels_userlevelname" class="lokuserlevels_userlevelname">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokuserlevels->userlevelname->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokuserlevels->userlevelname->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokuserlevels->userlevelname->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokuserlevels_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokuserlevels->ExportAll && $lokuserlevels->isExport()) {
	$lokuserlevels_list->StopRec = $lokuserlevels_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokuserlevels_list->TotalRecs > $lokuserlevels_list->StartRec + $lokuserlevels_list->DisplayRecs - 1)
		$lokuserlevels_list->StopRec = $lokuserlevels_list->StartRec + $lokuserlevels_list->DisplayRecs - 1;
	else
		$lokuserlevels_list->StopRec = $lokuserlevels_list->TotalRecs;
}
$lokuserlevels_list->RecCnt = $lokuserlevels_list->StartRec - 1;
if ($lokuserlevels_list->Recordset && !$lokuserlevels_list->Recordset->EOF) {
	$lokuserlevels_list->Recordset->moveFirst();
	$selectLimit = $lokuserlevels_list->UseSelectLimit;
	if (!$selectLimit && $lokuserlevels_list->StartRec > 1)
		$lokuserlevels_list->Recordset->move($lokuserlevels_list->StartRec - 1);
} elseif (!$lokuserlevels->AllowAddDeleteRow && $lokuserlevels_list->StopRec == 0) {
	$lokuserlevels_list->StopRec = $lokuserlevels->GridAddRowCount;
}

// Initialize aggregate
$lokuserlevels->RowType = ROWTYPE_AGGREGATEINIT;
$lokuserlevels->resetAttributes();
$lokuserlevels_list->renderRow();
while ($lokuserlevels_list->RecCnt < $lokuserlevels_list->StopRec) {
	$lokuserlevels_list->RecCnt++;
	if ($lokuserlevels_list->RecCnt >= $lokuserlevels_list->StartRec) {
		$lokuserlevels_list->RowCnt++;

		// Set up key count
		$lokuserlevels_list->KeyCount = $lokuserlevels_list->RowIndex;

		// Init row class and style
		$lokuserlevels->resetAttributes();
		$lokuserlevels->CssClass = "";
		if ($lokuserlevels->isGridAdd()) {
		} else {
			$lokuserlevels_list->loadRowValues($lokuserlevels_list->Recordset); // Load row values
		}
		$lokuserlevels->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokuserlevels->RowAttrs = array_merge($lokuserlevels->RowAttrs, array('data-rowindex'=>$lokuserlevels_list->RowCnt, 'id'=>'r' . $lokuserlevels_list->RowCnt . '_lokuserlevels', 'data-rowtype'=>$lokuserlevels->RowType));

		// Render row
		$lokuserlevels_list->renderRow();

		// Render list options
		$lokuserlevels_list->renderListOptions();
?>
	<tr<?php echo $lokuserlevels->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokuserlevels_list->ListOptions->render("body", "left", $lokuserlevels_list->RowCnt);
?>
	<?php if ($lokuserlevels->userlevelid->Visible) { // userlevelid ?>
		<td data-name="userlevelid"<?php echo $lokuserlevels->userlevelid->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevels_list->RowCnt ?>_lokuserlevels_userlevelid" class="lokuserlevels_userlevelid">
<span<?php echo $lokuserlevels->userlevelid->viewAttributes() ?>>
<?php echo $lokuserlevels->userlevelid->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($lokuserlevels->userlevelname->Visible) { // userlevelname ?>
		<td data-name="userlevelname"<?php echo $lokuserlevels->userlevelname->cellAttributes() ?>>
<span id="el<?php echo $lokuserlevels_list->RowCnt ?>_lokuserlevels_userlevelname" class="lokuserlevels_userlevelname">
<span<?php echo $lokuserlevels->userlevelname->viewAttributes() ?>>
<?php echo $lokuserlevels->userlevelname->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokuserlevels_list->ListOptions->render("body", "right", $lokuserlevels_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokuserlevels->isGridAdd())
		$lokuserlevels_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokuserlevels->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokuserlevels_list->Recordset)
	$lokuserlevels_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokuserlevels_list->TotalRecs == 0 && !$lokuserlevels->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokuserlevels_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokuserlevels_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokuserlevels->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokuserlevels_list->terminate();
?>