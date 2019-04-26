<?php
namespace PHPMaker2019\tpp;

// Set up relative path
$RELATIVE_PATH = "../";
$ROOT_RELATIVE_PATH = "../";
include_once $RELATIVE_PATH . "autoload.php";

// Create language object
$Language = new Language();
$Api = new Api();
$Api->run();
?>