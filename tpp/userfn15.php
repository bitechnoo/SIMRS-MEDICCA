<?php
namespace PHPMaker2019\tpp;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row) {

	//echo "PersonalData Downloading";
}

// Personal Data Deleted event
function PersonalData_Deleted($row) {

	//echo "PersonalData Deleted";
}

function getGUID(){
	date_default_timezone_set("Asia/Jakarta");
	mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	$charid = strtoupper(md5(uniqid(rand(), true)));
	$uuid = chr(123)// "{"
		.date("dmYHis")
		.substr($charid, 0, 8)
		.substr($charid, 8, 4)
		.substr($charid,12, 4)
		.substr($charid,16, 4)
		.substr($charid,20,12)
		.chr(125);// "}"
	return $uuid;
}

function GetNextNoRM() {
	$sNextKode = "";
	$value = ExecuteScalar("SELECT cast(no_rm AS UNSIGNED) as no_rm FROM lokpasien ORDER BY no_rm DESC");
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sNextKode = $value + 1; // konversi ke integer, lalu tambahkan satu
		$nLength = strlen($sNextKode);
		if ($nLength < 6) {
			$nLength = 6;
			$sNextKode = sprintf('%0'.$nLength.'s', $sNextKode);
		} else {
			if($nLength % 2 == 0){
				$nLength = $nLength + 2;
				$sNextKode = sprintf('%0'.$nLength.'s', $sNextKode);
			} else {
				$nLength = $nLength + 1;
				$sNextKode = sprintf('%0'.$nLength.'s', $sNextKode);
			}
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "000001";
	}
	return $sNextKode;
}

function GetNumberID($prefix="") {
	$NumberID = "";
	$NumberID = $prefix . sprintf('%s', date_timestamp_get(date_create()));
	return $NumberID;
}
?>