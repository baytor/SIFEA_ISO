<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/SIFEA_ISO/php_code/libs_code.php');

$pdf = new reportPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
$pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
