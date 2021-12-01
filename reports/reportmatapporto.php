<?php

  require_once('parent_report.php');
  //print_report();

  $_SESSION['pdf_report']->Cell(60,10,'Powered by FPDF.',0,1,'C', TRUE);
  $_SESSION['pdf_report']->output();



 ?>
