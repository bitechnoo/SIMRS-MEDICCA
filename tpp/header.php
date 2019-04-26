<?php
namespace PHPMaker2019\tpp;
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<meta charset="utf-8">
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>adminlte3/css/<?php echo CssFile("adminlte.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>plugins/font-awesome/css/font-awesome.min.css">
<?php } ?>
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>phpcss/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>phpcss/jquery.fileupload-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>colorbox/colorbox.css">
<?php foreach ($STYLESHEET_FILES as $cssfile) { // External Stylesheets ?>
<link rel="stylesheet" type="text/css" href="<?php echo (IsRemote($cssfile) ? "" : $RELATIVE_PATH) . $cssfile ?>">
<?php } ?>
<?php } ?>
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<?php if (IsResponsiveLayout()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo CssFile(PROJECT_STYLESHEET_FILENAME) ?>">
<?php if (@$CustomExportType == "pdf" && PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?><?php echo PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jquery-3.3.1.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jquery.ui.widget.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jquery.storageapi.min.js"></script>
<?php } ?>
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<script src="<?php echo $RELATIVE_PATH ?>bootstrap4/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>adminlte3/js/adminlte.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jquery.fileDownload.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/load-image.all.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jqueryfileupload.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/typeahead.jquery.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/mobile-detect.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>moment/moment.min.js"></script>
<?php foreach ($JAVASCRIPT_FILES as $jsfile) { // External JavaScripts ?>
<script src="<?php echo (IsRemote($jsfile) ? "" : $RELATIVE_PATH) . $jsfile ?>"></script>
<?php } ?>
<?php } ?>
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/jsrender.min.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/ewp15.js"></script>
<script>
jQuery.extend(ew, {
	LANGUAGE_ID: "<?php echo $CurrentLanguage ?>",
	DATE_SEPARATOR: "<?php echo $DATE_SEPARATOR ?>", // Date separator
	TIME_SEPARATOR: "<?php echo $TIME_SEPARATOR ?>", // Time separator
	DATE_FORMAT: "<?php echo $DATE_FORMAT ?>", // Default date format
	DATE_FORMAT_ID: <?php echo $DATE_FORMAT_ID ?>, // Default date format ID
	DATETIME_WITHOUT_SECONDS: <?php echo DATETIME_WITHOUT_SECONDS ? "true" : "false" ?>, // Date/Time without seconds
	DECIMAL_POINT: "<?php echo $DECIMAL_POINT ?>",
	THOUSANDS_SEP: "<?php echo $THOUSANDS_SEP ?>",
	SESSION_TIMEOUT: <?php echo (SESSION_TIMEOUT > 0) ? SessionTimeoutTime() : 0 ?>, // Session timeout time (seconds)
	SESSION_TIMEOUT_COUNTDOWN: <?php echo SESSION_TIMEOUT_COUNTDOWN ?>, // Count down time to session timeout (seconds)
	SESSION_KEEP_ALIVE_INTERVAL: <?php echo SESSION_KEEP_ALIVE_INTERVAL ?>, // Keep alive interval (seconds)
	RELATIVE_PATH: "<?php echo $RELATIVE_PATH ?>", // Relative path
	IS_LOGGEDIN: <?php echo IsLoggedIn() ? "true" : "false" ?>, // Is logged in
	IS_SYS_ADMIN: <?php echo IsSysAdmin() ? "true" : "false" ?>, // Is sys admin
	CURRENT_USER_NAME: "<?php echo JsEncode(CurrentUserName()) ?>", // Current user name
	IS_AUTOLOGIN: <?php echo IsAutoLogin() ? "true" : "false" ?>, // Is logged in with option "Auto login until I logout explicitly"
	TIMEOUT_URL: "<?php echo $RELATIVE_PATH ?>logout.php", // Timeout URL
	API_URL: "<?php echo $RELATIVE_PATH ?><?php echo API_URL ?>", // API file name
	API_ACTION_NAME: "<?php echo API_ACTION_NAME ?>", // API action name
	API_OBJECT_NAME: "<?php echo API_OBJECT_NAME ?>", // API object name
	API_FIELD_NAME: "<?php echo API_FIELD_NAME ?>", // API field name
	API_KEY_NAME: "<?php echo API_KEY_NAME ?>", // API key name
	API_LIST_ACTION: "<?php echo API_LIST_ACTION ?>", // API list action
	API_VIEW_ACTION: "<?php echo API_VIEW_ACTION ?>", // API view action
	API_ADD_ACTION: "<?php echo API_ADD_ACTION ?>", // API add action
	API_EDIT_ACTION: "<?php echo API_EDIT_ACTION ?>", // API edit action
	API_DELETE_ACTION: "<?php echo API_DELETE_ACTION ?>", // API delete action
	API_LOGIN_ACTION: "<?php echo API_LOGIN_ACTION ?>", // API login action
	API_FILE_ACTION: "<?php echo API_FILE_ACTION ?>", // API file action
	API_UPLOAD_ACTION: "<?php echo API_UPLOAD_ACTION ?>", // API upload action
	API_JQUERY_UPLOAD_ACTION: "<?php echo API_JQUERY_UPLOAD_ACTION ?>", // API jQuery upload action
	API_SESSION_ACTION: "<?php echo API_SESSION_ACTION ?>", // API get session action
	API_LOOKUP_ACTION: "<?php echo API_LOOKUP_ACTION ?>", // API lookup action
	API_LOOKUP_TABLE: "<?php echo API_LOOKUP_TABLE ?>", // API lookup table name
	API_PROGRESS_ACTION: "<?php echo API_PROGRESS_ACTION ?>", // API progress action
	LOOKUP_FILTER_VALUE_SEPARATOR: "<?php echo LOOKUP_FILTER_VALUE_SEPARATOR ?>", // Lookup filter value separator
	AUTO_SUGGEST_MAX_ENTRIES: <?php echo AUTO_SUGGEST_MAX_ENTRIES ?>, // Auto-Suggest max entries
	DISABLE_BUTTON_ON_SUBMIT: true,
	IMAGE_FOLDER: "phpimages/", // Image folder
	SESSION_ID: "<?php echo Encrypt(session_id()) ?>", // Session ID
	UPLOAD_URL: "<?php echo API_URL ?>", // Upload URL
	UPLOAD_TYPE: "<?php echo $UPLOAD_TYPE ?>", // Upload type
	UPLOAD_THUMBNAIL_WIDTH: <?php echo UPLOAD_THUMBNAIL_WIDTH ?>, // Upload thumbnail width
	UPLOAD_THUMBNAIL_HEIGHT: <?php echo UPLOAD_THUMBNAIL_HEIGHT ?>, // Upload thumbnail height
	MULTIPLE_UPLOAD_SEPARATOR: "<?php echo MULTIPLE_UPLOAD_SEPARATOR ?>", // Upload multiple separator
	IMPORT_FILE_ALLOWED_EXT: "<?php echo IMPORT_FILE_ALLOWED_EXT ?>", // Import file allowed extensions
	USE_COLORBOX: <?php echo (USE_COLORBOX) ? "true" : "false" ?>,
	USE_JAVASCRIPT_MESSAGE: false,
	PROJECT_STYLESHEET_FILENAME: "<?php echo PROJECT_STYLESHEET_FILENAME ?>", // Project style sheet
	PDF_STYLESHEET_FILENAME: "<?php echo PDF_STYLESHEET_FILENAME ?>", // PDF style sheet
	ANTIFORGERY_TOKEN: "<?php echo @$CurrentToken ?>",
	CSS_FLIP: <?php echo ($CSS_FLIP) ? "true" : "false" ?>,
	LAZY_LOAD: <?php echo ($LAZY_LOAD) ? "true" : "false" ?>,
	RESET_HEIGHT: <?php echo ($RESET_HEIGHT) ? "true" : "false" ?>,
	DEBUG_ENABLED: <?php echo (DEBUG_ENABLED) ? "true" : "false" ?>,
	SEARCH_FILTER_OPTION: "<?php echo SEARCH_FILTER_OPTION ?>",
	OPTION_HTML_TEMPLATE: <?php echo JsonEncode($OPTION_HTML_TEMPLATE) ?>
});
</script>
<script src="<?php echo $RELATIVE_PATH ?>jquery/jquery.ewjtable.js"></script>
<?php } ?>
<?php if (@$ExportType == "" || @$ExportType == "print") { ?>
<script>
<?php echo $Language->toJson() ?>
ew.vars = <?php echo JsonEncode($CLIENT_VAR) ?>;
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $RELATIVE_PATH ?>phpcss/bootstrap-datetimepicker.css">
<script src="<?php echo $RELATIVE_PATH ?>phpjs/bootstrap-datetimepicker.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/ewdatetimepicker.js"></script>
<script src="<?php echo $RELATIVE_PATH ?>phpjs/userfn15.js"></script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $RELATIVE_PATH ?>itpro.ico"><link rel="icon" type="image/x-icon" href="<?php echo $RELATIVE_PATH ?>itpro.ico">
<meta name="generator" content="PHPMaker v2019.0.9">
</head>
<body class="<?php echo $BODY_CLASS ?>" dir="<?php echo ($CSS_FLIP) ? "rtl" : "ltr" ?>">
<?php if (@!$SkipHeaderFooter) { ?>
<?php if (@$ExportType == "") { ?>
<div class="wrapper ew-layout">
	<!-- Main Header -->
	<?php include_once $RELATIVE_PATH . "ewmenu.php" ?>
	<!-- Navbar -->
	<nav class="<?php echo $NAVBAR_CLASS ?>">
		<!-- Left navbar links -->
		<ul id="ew-navbar" class="navbar-nav">
			<a class="navbar-brand d-none d-md-block" href="#">
				<span class="brand-text">SIMRS MEDICCA</span>
			</a>
			<li class="nav-item d-block d-md-none">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
			</li>
		</ul>
		<!-- Right navbar links -->
		<ul id="ew-navbar-right" class="navbar-nav ml-auto"></ul>
	</nav>
	<!-- /.navbar -->
	<!-- Main Sidebar Container -->
	<aside class="<?php echo $SIDEBAR_CLASS ?>">
		<!-- Brand Logo //** Note: Only licensed users are allowed to change the logo ** -->
		<a href="#" class="brand-link">
			<span class="brand-text">SIMRS MEDICCA</span>
		</a>
		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar Menu -->
			<nav id="ew-menu" class="mt-2"></nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<?php if (PAGE_TITLE_STYLE <> "None") { ?>
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><?php echo CurrentPageHeading() ?> <small class="text-muted"><?php echo CurrentPageSubheading() ?></small></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<?php Breadcrumb()->render() ?>
				</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
	<?php } ?>
		<!-- Main content -->
		<section class="content">
		<div class="container-fluid">
<?php } ?>
<?php } ?>