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
$lokkelurahan_list = new lokkelurahan_list();

// Run the page
$lokkelurahan_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lokkelurahan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$lokkelurahan->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flokkelurahanlist = currentForm = new ew.Form("flokkelurahanlist", "list");
flokkelurahanlist.formKeyCountName = '<?php echo $lokkelurahan_list->FormKeyCountName ?>';

// Form_CustomValidate event
flokkelurahanlist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flokkelurahanlist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$lokkelurahan->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($lokkelurahan_list->TotalRecs > 0 && $lokkelurahan_list->ExportOptions->visible()) { ?>
<?php $lokkelurahan_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($lokkelurahan_list->ImportOptions->visible()) { ?>
<?php $lokkelurahan_list->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$lokkelurahan_list->renderOtherOptions();
?>
<?php $lokkelurahan_list->showPageHeader(); ?>
<?php
$lokkelurahan_list->showMessage();
?>
<?php if ($lokkelurahan_list->TotalRecs > 0 || $lokkelurahan->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($lokkelurahan_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> lokkelurahan">
<?php if (!$lokkelurahan->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$lokkelurahan->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($lokkelurahan_list->Pager)) $lokkelurahan_list->Pager = new PrevNextPager($lokkelurahan_list->StartRec, $lokkelurahan_list->DisplayRecs, $lokkelurahan_list->TotalRecs, $lokkelurahan_list->AutoHidePager) ?>
<?php if ($lokkelurahan_list->Pager->RecordCount > 0 && $lokkelurahan_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($lokkelurahan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $lokkelurahan_list->pageUrl() ?>start=<?php echo $lokkelurahan_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($lokkelurahan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $lokkelurahan_list->pageUrl() ?>start=<?php echo $lokkelurahan_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $lokkelurahan_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($lokkelurahan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $lokkelurahan_list->pageUrl() ?>start=<?php echo $lokkelurahan_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($lokkelurahan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $lokkelurahan_list->pageUrl() ?>start=<?php echo $lokkelurahan_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $lokkelurahan_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($lokkelurahan_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $lokkelurahan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $lokkelurahan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $lokkelurahan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($lokkelurahan_list->TotalRecs > 0 && (!$lokkelurahan_list->AutoHidePageSizeSelector || $lokkelurahan_list->Pager->Visible)) { ?>
<div class="ew-pager">
<input type="hidden" name="t" value="lokkelurahan">
<select name="<?php echo TABLE_REC_PER_PAGE ?>" class="form-control form-control-sm ew-tooltip" title="<?php echo $Language->phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($lokkelurahan_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($lokkelurahan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($lokkelurahan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($lokkelurahan_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="40"<?php if ($lokkelurahan_list->DisplayRecs == 40) { ?> selected<?php } ?>>40</option>
<option value="50"<?php if ($lokkelurahan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($lokkelurahan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($lokkelurahan->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $lokkelurahan_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="flokkelurahanlist" id="flokkelurahanlist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($lokkelurahan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $lokkelurahan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokkelurahan">
<div id="gmp_lokkelurahan" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($lokkelurahan_list->TotalRecs > 0 || $lokkelurahan->isGridEdit()) { ?>
<table id="tbl_lokkelurahanlist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$lokkelurahan_list->RowType = ROWTYPE_HEADER;

// Render list options
$lokkelurahan_list->renderListOptions();

// Render list options (header, left)
$lokkelurahan_list->ListOptions->render("header", "left");
?>
<?php if ($lokkelurahan->Kelurahan->Visible) { // Kelurahan ?>
	<?php if ($lokkelurahan->sortUrl($lokkelurahan->Kelurahan) == "") { ?>
		<th data-name="Kelurahan" class="<?php echo $lokkelurahan->Kelurahan->headerCellClass() ?>"><div id="elh_lokkelurahan_Kelurahan" class="lokkelurahan_Kelurahan"><div class="ew-table-header-caption"><?php echo $lokkelurahan->Kelurahan->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kelurahan" class="<?php echo $lokkelurahan->Kelurahan->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $lokkelurahan->SortUrl($lokkelurahan->Kelurahan) ?>',2);"><div id="elh_lokkelurahan_Kelurahan" class="lokkelurahan_Kelurahan">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $lokkelurahan->Kelurahan->caption() ?></span><span class="ew-table-header-sort"><?php if ($lokkelurahan->Kelurahan->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($lokkelurahan->Kelurahan->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$lokkelurahan_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($lokkelurahan->ExportAll && $lokkelurahan->isExport()) {
	$lokkelurahan_list->StopRec = $lokkelurahan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($lokkelurahan_list->TotalRecs > $lokkelurahan_list->StartRec + $lokkelurahan_list->DisplayRecs - 1)
		$lokkelurahan_list->StopRec = $lokkelurahan_list->StartRec + $lokkelurahan_list->DisplayRecs - 1;
	else
		$lokkelurahan_list->StopRec = $lokkelurahan_list->TotalRecs;
}
$lokkelurahan_list->RecCnt = $lokkelurahan_list->StartRec - 1;
if ($lokkelurahan_list->Recordset && !$lokkelurahan_list->Recordset->EOF) {
	$lokkelurahan_list->Recordset->moveFirst();
	$selectLimit = $lokkelurahan_list->UseSelectLimit;
	if (!$selectLimit && $lokkelurahan_list->StartRec > 1)
		$lokkelurahan_list->Recordset->move($lokkelurahan_list->StartRec - 1);
} elseif (!$lokkelurahan->AllowAddDeleteRow && $lokkelurahan_list->StopRec == 0) {
	$lokkelurahan_list->StopRec = $lokkelurahan->GridAddRowCount;
}

// Initialize aggregate
$lokkelurahan->RowType = ROWTYPE_AGGREGATEINIT;
$lokkelurahan->resetAttributes();
$lokkelurahan_list->renderRow();
while ($lokkelurahan_list->RecCnt < $lokkelurahan_list->StopRec) {
	$lokkelurahan_list->RecCnt++;
	if ($lokkelurahan_list->RecCnt >= $lokkelurahan_list->StartRec) {
		$lokkelurahan_list->RowCnt++;

		// Set up key count
		$lokkelurahan_list->KeyCount = $lokkelurahan_list->RowIndex;

		// Init row class and style
		$lokkelurahan->resetAttributes();
		$lokkelurahan->CssClass = "";
		if ($lokkelurahan->isGridAdd()) {
		} else {
			$lokkelurahan_list->loadRowValues($lokkelurahan_list->Recordset); // Load row values
		}
		$lokkelurahan->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$lokkelurahan->RowAttrs = array_merge($lokkelurahan->RowAttrs, array('data-rowindex'=>$lokkelurahan_list->RowCnt, 'id'=>'r' . $lokkelurahan_list->RowCnt . '_lokkelurahan', 'data-rowtype'=>$lokkelurahan->RowType));

		// Render row
		$lokkelurahan_list->renderRow();

		// Render list options
		$lokkelurahan_list->renderListOptions();
?>
	<tr<?php echo $lokkelurahan->rowAttributes() ?>>
<?php

// Render list options (body, left)
$lokkelurahan_list->ListOptions->render("body", "left", $lokkelurahan_list->RowCnt);
?>
	<?php if ($lokkelurahan->Kelurahan->Visible) { // Kelurahan ?>
		<td data-name="Kelurahan"<?php echo $lokkelurahan->Kelurahan->cellAttributes() ?>>
<span id="el<?php echo $lokkelurahan_list->RowCnt ?>_lokkelurahan_Kelurahan" class="lokkelurahan_Kelurahan">
<span<?php echo $lokkelurahan->Kelurahan->viewAttributes() ?>>
<?php echo $lokkelurahan->Kelurahan->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$lokkelurahan_list->ListOptions->render("body", "right", $lokkelurahan_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$lokkelurahan->isGridAdd())
		$lokkelurahan_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$lokkelurahan->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($lokkelurahan_list->Recordset)
	$lokkelurahan_list->Recordset->Close();
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($lokkelurahan_list->TotalRecs == 0 && !$lokkelurahan->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $lokkelurahan_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$lokkelurahan_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$lokkelurahan->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$lokkelurahan_list->terminate();
?>