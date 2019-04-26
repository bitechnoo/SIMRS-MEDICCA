<?php
	namespace PHPMaker2019\tpp;
	if (session_id() == "") 
		session_start();
	ob_start();
	require_once "autoload.php";

	require('fpdf/code128.php'); // adjust the location of your fpdf
	ob_end_clean();
	
	$cId_Pasien = $_GET['Id_Pasien'];
	$sql = "SELECT no_rm, nama_pasien FROM lokpasien WHERE id_pasien = '".$cId_Pasien."'";
		
	$rs = ExecuteRow($sql);
	
	$pdf = new \PDF_Code128('P','mm',array(80, 83.8));
	//$pdf = new \FPDF();
	// Add first page
	$pdf->AddPage();
	 
	// Set initial x and y position per page
	$y_axis_initial = 0;
	$x_axis_initial = 0;	
	 
	// Set Y and X initial position
	$pdf->SetY($y_axis_initial);
	$pdf->SetX($x_axis_initial);
		
	$pdf->SetMargins(1,1);
	$pdf->SetAutoPageBreak(false);

	// Print it out now ...
	$pdf->Cell(0, 19, "", 0, 1, 'C');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0, 5, strtoupper(trim($rs['nama_pasien'])), 0, 1, 'C');
	$pdf->Cell(0, 5, $rs['no_rm'], 0, 1, 'C');
	
	$pdf->Code128($pdf->GetX()+20, $pdf->GetY(), $rs['no_rm'], 40, 8);
		
	$pdf->SetXY($pdf->GetX(), $pdf->GetY()+8);
	$pdf->Cell(0, 2, "", 0, 1, 'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0, 4, "KARTU INI HARAP DIBAWA BILA BEROBAT", 0, 1, 'C');
		
	//$pdf->IncludeJS("print(true);");
	//$pdf->SelectPrinter("///localhost/EPSON LX-300+II ESC/P", true);
	$pdf->Output("kartupasien.pdf", "I");
?>