<?php
namespace PHPMaker2019\tpp;

// Menu Language
if ($Language && $Language->LanguageFolder == $LANGUAGE_FOLDER)
	$MenuLanguage = &$Language;
else
	$MenuLanguage = new Language();

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
$topMenu->addMenuItem(2, "mi_lokpasien", $MenuLanguage->MenuPhrase("2", "MenuText"), "lokpasienlist.php", -1, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpasien'), FALSE, FALSE, "fa-wheelchair", "", TRUE);
$topMenu->addMenuItem(4, "mi_lokdaftar", $MenuLanguage->MenuPhrase("4", "MenuText"), "lokdaftarlist.php", -1, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokdaftar'), FALSE, FALSE, "fa-history", "", TRUE);
$topMenu->addMenuItem(118, "mci_PENGATURAN", $MenuLanguage->MenuPhrase("118", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "fa-bars", "", TRUE);
$topMenu->addMenuItem(6, "mi_vlokpetugas", $MenuLanguage->MenuPhrase("6", "MenuText"), "vlokpetugaslist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}vlokpetugas'), FALSE, FALSE, "fa-user", "", TRUE);
$topMenu->addMenuItem(3, "mi_lokbiayadaftar", $MenuLanguage->MenuPhrase("3", "MenuText"), "lokbiayadaftarlist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokbiayadaftar'), FALSE, FALSE, "fa-calculator", "", TRUE);
$topMenu->addMenuItem(15, "mi_ugdbiayadaftar", $MenuLanguage->MenuPhrase("15", "MenuText"), "ugdbiayadaftarlist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugdbiayadaftar'), FALSE, FALSE, "fa-calculator", "", TRUE);
$topMenu->addMenuItem(9, "mi_lokuserlevels", $MenuLanguage->MenuPhrase("9", "MenuText"), "lokuserlevelslist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokuserlevels'), FALSE, FALSE, "fa-key", "", TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(2, "mi_lokpasien", $MenuLanguage->MenuPhrase("2", "MenuText"), "lokpasienlist.php", -1, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokpasien'), FALSE, FALSE, "fa-wheelchair", "", TRUE);
$sideMenu->addMenuItem(4, "mi_lokdaftar", $MenuLanguage->MenuPhrase("4", "MenuText"), "lokdaftarlist.php", -1, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokdaftar'), FALSE, FALSE, "fa-history", "", TRUE);
$sideMenu->addMenuItem(118, "mci_PENGATURAN", $MenuLanguage->MenuPhrase("118", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "fa-bars", "", TRUE);
$sideMenu->addMenuItem(6, "mi_vlokpetugas", $MenuLanguage->MenuPhrase("6", "MenuText"), "vlokpetugaslist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}vlokpetugas'), FALSE, FALSE, "fa-user", "", TRUE);
$sideMenu->addMenuItem(3, "mi_lokbiayadaftar", $MenuLanguage->MenuPhrase("3", "MenuText"), "lokbiayadaftarlist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokbiayadaftar'), FALSE, FALSE, "fa-calculator", "", TRUE);
$sideMenu->addMenuItem(15, "mi_ugdbiayadaftar", $MenuLanguage->MenuPhrase("15", "MenuText"), "ugdbiayadaftarlist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}ugdbiayadaftar'), FALSE, FALSE, "fa-calculator", "", TRUE);
$sideMenu->addMenuItem(9, "mi_lokuserlevels", $MenuLanguage->MenuPhrase("9", "MenuText"), "lokuserlevelslist.php", 118, "", AllowListMenu('{888F026C-2D04-4F2F-A77C-CABDD56A9360}lokuserlevels'), FALSE, FALSE, "fa-key", "", TRUE);
echo $sideMenu->toScript();
?>