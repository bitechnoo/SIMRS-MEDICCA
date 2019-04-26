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
$login = new login();

// Run the page
$login->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$login->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<script>
var flogin = new ew.Form("flogin");

// Validate function
flogin.validate = function()
{
	var fobj = this._form;
	if (!this.validateRequired)
		return true; // Ignore validation
	if (!ew.hasValue(fobj.username))
		return this.onError(fobj.username, ew.language.phrase("EnterUid"));
	if (!ew.hasValue(fobj.password))
		return this.onError(fobj.password, ew.language.phrase("EnterPwd"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Form_CustomValidate function
flogin.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flogin.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;
</script>
<?php $login->showPageHeader(); ?>
<?php
$login->showMessage();
?>
<form name="flogin" id="flogin" class="ew-form ew-login-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($login->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $login->Token ?>">
<?php } ?>
<div class="ew-login-box">
<div class="login-logo"></div>
<div class="card">
	<div class="card-body">
	<p class="login-box-msg"><?php echo $Language->phrase("LoginMsg") ?></p>
	<div class="form-group row">
		<input type="text" name="username" id="username" class="form-control ew-control" value="<?php echo HtmlEncode($login->Username) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Username")) ?>">
	</div>
	<div class="form-group row">
		<input type="password" name="password" id="password" class="form-control ew-control" placeholder="<?php echo HtmlEncode($Language->phrase("Password")) ?>">
	</div>
	<button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("Login") ?></button>
<?php

	// OAuth login
	$providers = $AUTH_CONFIG["providers"];
	$cntProviders = 0;
	foreach ($providers as $id => $provider) {
		if ($provider["enabled"])
			$cntProviders++;
	}
	if ($cntProviders > 0) {
?>
	<div class="social-auth-links text-center mb-3">
		<p><?php echo $Language->phrase("LoginOr") ?></p>
<?php
		foreach ($providers as $id => $provider) {
			if ($provider["enabled"]) {
?>
			<a href="login.php?provider=<?php echo $id ?>" class="btn btn-block btn-<?php echo strtolower($provider["color"]) ?>"><i class="fa fa-<?php echo strtolower($id) ?> mr-2"></i><?php echo $Language->phrase("Login" . $id) ?></a>
<?php
			}
		}
?>
	</div>
<?php
	}
?>
<p>&nbsp;</p>
</div>
</div>
</div>
</form>
<?php
$login->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$login->terminate();
?>