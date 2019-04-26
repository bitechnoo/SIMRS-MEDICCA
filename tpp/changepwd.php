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
$changepwd = new changepwd();

// Run the page
$changepwd->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$changepwd->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<script>
var fchangepwd = new ew.Form("fchangepwd");

// Extend form with Validate function
fchangepwd.validate = function() {
	var $ = jQuery, fobj = this._form, $npwd = $(fobj.npwd);
	if (!this.validateRequired)
		return true; // Ignore validation
<?php if (!IsPasswordReset()) { ?>
	if (!ew.hasValue(fobj.opwd))
		return this.onError(fobj.opwd, ew.language.phrase("EnterOldPassword"));
<?php } ?>
	if (!ew.hasValue(fobj.npwd))
		return this.onError(fobj.npwd, ew.language.phrase("EnterNewPassword"));
	if (fobj.npwd.value != fobj.cpwd.value)
		return this.onError(fobj.cpwd, ew.language.phrase("MismatchPassword"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Extend form with Form_CustomValidate function
fchangepwd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fchangepwd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;
</script>
<?php $changepwd->showPageHeader(); ?>
<?php
$changepwd->showMessage();
?>
<form name="fchangepwd" id="fchangepwd" class="ew-form ew-change-pwd-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($changepwd->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $changepwd->Token ?>">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="d-none" type="text" name="<?php echo Encrypt(Random()) ?>">
<input class="d-none" type="password" name="<?php echo Encrypt(Random()) ?>">
<div class="ew-change-pwd-box">
<div class="card">
<div class="card-body">
<p class="login-box-msg"><?php echo $Language->phrase("ChangePwdMsg") ?></p>
<?php if (!IsPasswordReset()) { ?>
	<div class="form-group row">
		<input type="password" name="opwd" id="opwd" class="form-control ew-control" placeholder="<?php echo HtmlEncode($Language->phrase("OldPassword")) ?>">
	</div>
<?php } ?>
	<div class="form-group row flex-column">
			<input type="password" name="npwd" id="npwd" class="form-control ew-control" placeholder="<?php echo HtmlEncode($Language->phrase("NewPassword")) ?>">
	</div>
	<div class="form-group row">
		<input type="password" name="cpwd" id="cpwd" class="form-control ew-control" placeholder="<?php echo HtmlEncode($Language->phrase("ConfirmPassword")) ?>">
	</div>
	<button class="btn btn-primary ew-btn" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("ChangePwdBtn") ?></button>
</div>
</div>
</div>
</form>
<?php
$changepwd->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$changepwd->terminate();
?>