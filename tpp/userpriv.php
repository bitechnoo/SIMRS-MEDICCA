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
$userpriv = new userpriv();

// Run the page
$userpriv->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userpriv->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "userpriv";
var fuserpriv = currentForm = new ew.Form("fuserpriv", "userpriv");

// Form_CustomValidate event
fuserpriv.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fuserpriv.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php
$userpriv->showMessage();
?>
<script>
var fuserpriv = new ew.Form("fuserpriv");
</script>
<form name="fuserpriv" id="fuserpriv" class="form-inline ew-form ew-user-priv-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($userpriv->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $userpriv->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="lokuserlevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="x_userlevelid" id="x_userlevelid" value="<?php echo $lokuserlevels->userlevelid->CurrentValue ?>">
<div class="ew-desktop">
<div class="card ew-card ew-grid">
<div class="card-header">
	<h3 class="card-title"><?php echo $Language->Phrase("UserLevel") ?><?php echo $Security->getUserLevelName($lokuserlevels->userlevelid->CurrentValue) ?> (<?php echo $lokuserlevels->userlevelid->CurrentValue ?>)</h3>
	<div class="card-tools">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"><i class="fa fa-search"></i></span>
			</div>
			<input type="search" name="table-name" id="table-name" class="form-control form-control-sm" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>" autocomplete="off">
		</div>
	</div>
</div>
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel"></div>
</div>
<div class="ew-desktop-button">
<button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"<?php echo $userpriv->Disabled ?>><?php echo $Language->phrase("Update") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $userpriv->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</div>
</form>
<script>
var priv = <?php echo JsonEncode($userpriv->Privileges) ?>;
var chkClass = "form-check-input ew-priv";
if (priv.disabled)
	chkClass += " disabled";

function getDisplayFn(name, trueValue) {
	return function(data) {
		var row = data.record, id = name + '_' + row.index,
			checked = (row.permission & trueValue) == trueValue;
		row.checked = checked;
		return '<div class="form-check"><input type="checkbox" class="form-check-input position-static ew-priv ew-multi-select" name="' + id + '" id="' + id +
			'" value="' + trueValue + '" data-index="' + row.index + '"' +
			((checked) ? ' checked' : '') +
			(((row.allowed & trueValue) != trueValue) ? ' disabled' : '') + '></div>';
	};
}

function displayTableName(data) {
	var row = data.record;
	return row.table + '<input type="hidden" name="table_' + row.index + '" value="1">';
};

function getRecords(data, params) {
	var rows = priv.permissions.slice(0);
	if (data && data.table) {
		var table = data.table.toLowerCase();
		rows = jQuery.map(rows, function(row) {
			if (row.table.toLowerCase().includes(table))
				return row;
			return null;
		});
	}
	if (params && params.sorting) {
		var asc = params.sorting.match(/ASC$/);
		rows.sort(function(a, b) { // Case-insensitive
			if (b.table.toLowerCase() > a.table.toLowerCase())
				return (asc) ? -1 : 1;
			else if (b.table.toLowerCase() === a.table.toLowerCase())
				return 0
			else if (b.table.toLowerCase() < a.table.toLowerCase())
				return (asc) ? 1 : -1;
		});
	}
	return {
		result: "OK",
		params: jQuery.extend({}, data, params),
		records: rows
	};
}
var _fields = {
	table: {
		title: ew.language.phrase("TableOrView"),
		display: displayTableName,
		sorting: true
	},
	add: {
		title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="add" id="add" onclick="ew.selectAll(this);"><label class="form-check-label" for="add">' + ew.language.phrase("PermissionAddCopy") + '</label></div>',
		display: getDisplayFn("add", priv.ALLOW_ADD),
		sorting: false
	},
	delete: {
		title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="delete" id="delete" onclick="ew.selectAll(this);"><label class="form-check-label" for="delete">' + ew.language.phrase("PermissionDelete") + '</label></div>',
		display: getDisplayFn("delete", priv.ALLOW_DELETE),
		sorting: false
	},
	edit: {
		title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="edit" id="edit" onclick="ew.selectAll(this);"><label class="form-check-label" for="edit">' + ew.language.phrase("PermissionEdit") + '</label></div>',
		display: getDisplayFn("edit", priv.ALLOW_EDIT),
		sorting: false
	},
	list: {
		title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="list" id="list" onclick="ew.selectAll(this);"><label class="form-check-label" for="list">' +
			ew.language.phrase(priv.USER_LEVEL_COMPAT ? "PermissionListSearchView" : "PermissionList") +
			'</label></div>',
		display: getDisplayFn("list", priv.ALLOW_LIST),
		sorting: false
	}
};
if (!priv.USER_LEVEL_COMPAT) {
	$.extend(_fields, {
		view: {
			title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="view" id="view" onclick="ew.selectAll(this);"><label class="form-check-label" for="view">' + ew.language.phrase("PermissionView") + '</label></div>',
			display: getDisplayFn("view", priv.ALLOW_VIEW),
			sorting: false
		},
		search: {
			title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="search" id="search" onclick="ew.selectAll(this);"><label class="form-check-label" for="search">' + ew.language.phrase("PermissionSearch") + '</label></div>',
			display: getDisplayFn("search", priv.ALLOW_SEARCH),
			sorting: false
		}
	});
}
$.extend(_fields, {
	admin: {
		title: '<div class="form-check"><input type="checkbox" class="' + chkClass + '" name="admin" id="admin" onclick="ew.selectAll(this);"><label class="form-check-label" for="admin">' + ew.language.phrase("PermissionAdmin") + '</label></div>',
		display: getDisplayFn("admin", priv.ALLOW_ADMIN),
		sorting: false
	}
});
$(".ew-grid:first .ew-grid-middle-panel").ewjtable({
	paging: false,
	sorting: true,
	defaultSorting: "table ASC",
	fields: _fields,
	actions: { listAction: getRecords },
	rowInserted: function(event, data) {
		var $row = data.row;
		$row.find("input[type=checkbox]").on("click", function() {
			var $this = $(this), index = parseInt($this.data("index"), 10), value = parseInt($this.data("value"), 10);
			if (this.checked)
				priv.permissions[index].permission = priv.permissions[index].permission | value;
			else
				priv.permissions[index].permission = priv.permissions[index].permission ^ value;
		});
	},
	recordsLoaded: function(event, data) {
		var $ = jQuery, sorting = data.serverResponse.params.sorting,
			$c = $(this).find(".ewjtable-column-header-container:first");
		if (!$c.find(".ew-table-header-sort")[0])
			$c.append('<span class="ew-table-header-sort"><i class="fa fa-sort-down"></i></span>');
		$c.find(".ew-table-header-sort i.fa").toggleClass("fa-sort-up", !!sorting.match(/ASC$/)).toggleClass("fa-sort-down", !!sorting.match(/DESC$/));
		ew.initMultiSelectCheckboxes();
	}
});

// Re-load records when user click 'Search' button.
var _timer;
$("#table-name").on("keydown keypress cut paste", function(e) {
	if (_timer)
		_timer.cancel();
	_timer = $.later(200, null, function() {
		$(".ew-grid:first .ew-grid-middle-panel").ewjtable("load", {
			table: $("#table-name").val()
		});
	});
});

// Load all records
$("#table-name").keydown();
</script>
<script>

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$userpriv->terminate();
?>