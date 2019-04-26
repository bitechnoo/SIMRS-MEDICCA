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
$index = new index();

// Run the page
$index->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());
?>
<?php include_once "header.php" ?>
<?php
$index->showMessage();
?>
<?php include_once "footer.php" ?>
<?php
$index->terminate();
?>