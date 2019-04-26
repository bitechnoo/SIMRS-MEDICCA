<?php
namespace PHPMaker2019\tpp;
?>
<?php if (@$ExportType == "") { ?>
<?php if (@!$SkipHeaderFooter) { ?>
		<?php if (isset($DebugTimer)) $DebugTimer->stop() ?>
		</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Main Footer -->
	<footer class="main-footer fade">
		<!-- ** Note: Only licensed users are allowed to change the copyright statement. ** -->
		<div class="ew-footer-text"><?php echo $Language->ProjectPhrase("FooterText") ?></div>
		<div class="float-right d-none d-sm-inline-block"></div>
	</footer>
</div>
<!-- ./wrapper -->
<?php } ?>
<?php if (@!$SkipHeaderFooter) { ?>
<!-- Navbar -->
<script type="text/html" id="navbar-menu-items" class="ew-js-template" data-name="navbar" data-data="navbar" data-method="appendTo" data-target="#ew-navbar">
{{if items}}
	{{for items}}
		<li id="{{:id}}" name="{{:name}}" class="{{if parentId == -1}}nav-item ew-navbar-item{{/if}}{{if isHeader && parentId > -1}}dropdown-header{{/if}}{{if items}} dropdown{{/if}}{{if items && parentId != -1}} dropdown-submenu{{/if}} d-none d-md-block">
			{{if isHeader && parentId > -1}}
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
			{{else}}
			<a href="{{:href}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}} class="{{if parentId == -1}}nav-link{{else}}dropdown-item{{/if}}{{if active}} active{{/if}}{{if items}} dropdown-toggle ew-dropdown{{/if}}"{{if items}} role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"{{/if}}>
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
			</a>
			{{/if}}
			{{if items}}
			<ul class="dropdown-menu">
				{{include tmpl="#navbar-menu-items"/}}
			</ul>
			{{/if}}
		</li>
	{{/for}}
{{/if}}
</script>
<!-- Sidebar -->
<script type="text/html" class="ew-js-template" data-name="menu" data-data="menu" data-target="#ew-menu">
{{if items}}
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="{{:accordion}}">
	{{include tmpl="#menu-items"/}}
	</ul>
{{/if}}
</script>
<script type="text/html" id="menu-items">
{{if items}}
	{{for items}}
		<li id="{{:id}}" name="{{:name}}" class="{{if isHeader}}nav-header{{else}}nav-item{{if items}} has-treeview{{/if}}{{if active}} active current{{/if}}{{if open}} menu-open{{/if}}{{/if}}{{if isNavbarItem}} d-block d-md-none{{/if}}">
			{{if isHeader}}
				{{if icon}}<i class="{{:icon}}"></i>{{/if}}
				<span>{{:text}}</span>
				{{if label}}
				<span class="right">
					{{:label}}
				</span>
				{{/if}}
			{{else}}
			<a href="{{:href}}" class="nav-link{{if active}} active{{/if}}"{{if target}} target="{{:target}}"{{/if}}{{if attrs}}{{:attrs}}{{/if}}>
				{{if icon}}<i class="nav-icon {{:icon}}"></i>{{/if}}
				<p><span>{{:text}}</span>
					{{if items}}
						<i class="right fa fa-angle-left"></i>
						{{if label}}
							<span class="right">
								{{:label}}
							</span>
						{{/if}}
					{{else}}
						{{if label}}
							<span class="right">
								{{:label}}
							</span>
						{{/if}}
					{{/if}}
				</p>
			</a>
			{{/if}}
			{{if items}}
			<ul class="nav nav-treeview"{{if open}} style="display: block;"{{/if}}">
				{{include tmpl="#menu-items"/}}
			</ul>
			{{/if}}
		</li>
	{{/for}}
{{/if}}
</script>
<?php } ?>
<?php if (@!$SkipHeaderFooter) { ?>
<script type="text/html" class="ew-js-template" data-name="languages" data-data="languages" data-method="<?php echo $Language->Method ?>" data-target="<?php echo HtmlEncode($Language->Target) ?>">
<?php echo $Language->getTemplate() ?>
</script>
<script type="text/html" class="ew-js-template" data-name="login" data-data="login" data-method="appendTo" data-target=".navbar-nav.ml-auto">
{{if isLoggedIn}}
<li class="nav-item dropdown text-body">
	<a class="nav-link" data-toggle="dropdown" href="#">
		<i class="fa fa-user"></i>
	</a>
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<div class="dropdown-item p-3"><i class="fa fa-user mr-2"></i>{{:currentUserName}}</div>
		{{if (hasPersonalData || canChangePassword)}}
		<div class="dropdown-divider"></div>
		<div class="text-nowrap p-3">
			{{if hasPersonalData}}
			<a class="btn btn-default" href="{{:personalDataUrl}}">{{:personalDataText}}</a>
			{{/if}}
			{{if canChangePassword}}
			<a class="btn btn-default" href="{{:changePasswordUrl}}">{{:changePasswordText}}</a>
			{{/if}}
		</div>
		{{/if}}
		{{if canLogout}}
		<div class="dropdown-divider"></div>
		<div class="dropdown-footer p-2 text-right">
			<a class="btn btn-default" href="{{:logoutUrl}}">{{:logoutText}}</a>
		</div>
		{{/if}}
	</div>
<li>
{{else}}
	{{if canLogin}}
<li class="nav-item"><a class="nav-link" href="{{:loginUrl}}">{{:loginText}}</a></li>
	{{/if}}
{{/if}}
</script>
<?php } ?>
<!-- modal dialog -->
<div id="ew-modal-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- modal lookup dialog -->
<div id="ew-modal-lookup-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>
<!-- add option dialog -->
<div id="ew-add-opt-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn"><?php echo $Language->phrase("AddBtn") ?></button><button type="button" class="btn btn-default ew-btn" data-dismiss="modal"><?php echo $Language->phrase("CancelBtn") ?></button></div></div></div></div>
<!-- import dialog -->
<div id="ew-import-dialog" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"></h4></div>
<div class="modal-body">
<div>
	<span class="btn btn-default fileinput-button">
		<span><?php echo $Language->phrase("ChooseFileBtn") ?></span>
		<input id="importfiles" type="file" title=" " name="importfiles[]" multiple>
	</span>
</div>
<div class="message d-none mt-3"></div>
<div class="progress d-none mt-3"><div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-default ew-close-btn" data-dismiss="modal"><?php echo $Language->phrase("CloseBtn") ?></button></div></div></div></div>
<!-- message box -->
<div id="ew-message-box" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn" data-dismiss="modal"><?php echo $Language->phrase("MessageOK") ?></button></div></div></div></div>
<!-- prompt -->
<div id="ew-prompt" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn"><?php echo $Language->phrase("MessageOK") ?></button><button type="button" class="btn btn-default ew-btn" data-dismiss="modal"><?php echo $Language->phrase("CancelBtn") ?></button></div></div></div></div>
<!-- session timer -->
<div id="ew-timer" class="modal" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-primary ew-btn" data-dismiss="modal"><?php echo $Language->phrase("MessageOK") ?></button></div></div></div></div>
<!-- tooltip -->
<div id="ew-tooltip"></div>
<?php } ?>
<?php if (@$ExportType == "") { ?>
<script>

// User event handlers
jQuery.get("<?php echo $RELATIVE_PATH ?>phpjs/userevt15.js");
</script>
<script>

// Write your global startup script here
// document.write("page loaded");

$(document).ready(function() {
	log='<?php echo CurrentUserInfo("Nama_Petugas"); ?>';
	if (log==""){
		log='Programmer';
	}
	$('div.dropdown-item.p-3').html('<i class="fa fa-user mr-2"></i>'+log).css("font-weight","bold");
	window.setTimeout(function() {
		$(".alert").fadeTo(1000, 0).slideUp(1000, function(){
			$(this).remove(); 
		});
	}, 2000);
	if ($('#kontenwrapper').text() == '') {
		$('.content-wrapper').prepend('<div id="kontenwrapper">&nbsp;</div>');
	}
	$('.content-header').hide();
});

//$("footer.main-footer").css("background-color", "rgb(54, 127, 168)");// warna footer
//$("footer.main-footer").css("height", "5"); // kecilin footer
//$("div.ewFooterText").css("font-weight", "bold"); // tebalin text footer
//$("div.ewFooterText").css("color", "white"); // ganti warna text footer

document.getElementById("ewModalDialog").setAttribute("data-backdrop", "static"); // modal tidak langsung close
document.getElementById("ewAddOptDialog").setAttribute("data-backdrop", "static");//add modal tidak langsung close

//$("div.modal-footer").css("text-align", "center");//add modal tengah tomboll
</script>
<?php } ?>
</body>
</html>
