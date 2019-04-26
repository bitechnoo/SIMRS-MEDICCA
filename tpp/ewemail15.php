<?php
namespace PHPMaker2019\tpp;
?>
<form id="ew-email-form" class="ew-horizontal ew-form ew-email-form" action="<?php echo CurrentPageName() ?>">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="export" id="export" value="email">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="sender"><?php echo $Language->Phrase("EmailFormSender") ?></label>
		<div class="col-sm-10"><input type="text" class="form-control ew-control" name="sender" id="sender"></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="recipient"><?php echo $Language->Phrase("EmailFormRecipient") ?></label>
		<div class="col-sm-10"><input type="text" class="form-control ew-control" name="recipient" id="recipient"></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="cc"><?php echo $Language->Phrase("EmailFormCc") ?></label>
		<div class="col-sm-10"><input type="text" class="form-control ew-control" name="cc" id="cc"></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="bcc"><?php echo $Language->Phrase("EmailFormBcc") ?></label>
		<div class="col-sm-10"><input type="text" class="form-control ew-control" name="bcc" id="bcc"></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="subject"><?php echo $Language->Phrase("EmailFormSubject") ?></label>
		<div class="col-sm-10"><input type="text" class="form-control ew-control" name="subject" id="subject"></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label ew-label" for="message"><?php echo $Language->Phrase("EmailFormMessage") ?></label>
		<div class="col-sm-10"><textarea class="form-control ew-control" rows="6" name="message" id="message"></textarea></div>
	</div>
</form>
