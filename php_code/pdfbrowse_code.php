<?php

require_once('libs_code.php');
session_start();
require_once('config_viewer_code.php');

echo "<div class=pdfbrowser>";
for($i = 0; $i < count($_SESSION['attachment']); $i++)
{
  if(isset($_POST[$_SESSION['attachment'][$i][0]]))
  {
    // $file_location = $_SESSION['attachment'][$i][1]
    // .$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])]
    // .$_SESSION['attachment'][$i][3];
    // $filename = $_SESSION['attachment'][$i][0] .'.pdf'; /* Note: Always use .pdf at the end. */

    $file_location = "/SIFEA_ISO/img/C21-709.pdf";
    $filename = "C21-709.pdf";

    // $file_location = preg_replace("/'/", "&#39;", $file_location);

    // echo "<a href=$file_location>aaa</a>";

    // header('Content-type: application/pdf');
    // header('Content-Disposition: inline; filename="' . $filename . '"');
    // header('Content-Transfer-Encoding: binary');
    // header('Content-Length: ' . filesize($file_location));
    // header('Accept-Ranges: bytes');
    // readfile($file_location);

    echo "<embed src='$file_location' type='application/pdf'/>";
    // echo "<a href=$file_location>aaa</a>";

    // echo "<br>Premuto " . $_SESSION['attachment'][$i][0] . "<br>";
    // echo "file: $filename file_location: $file_location<br>";
    exit;

    // if($_SESSION['attachment'][$i][3] != "")
    // {
    //   echo "Opening $file_location<br>";
    //   // Send the file to the browser.
    //   system($file_location);
    // }
    // else
    // {
    //   //se l'estensione del file (e anche il nome file) è vuoto vorrei aprisse la directory
    //   //ma non va...
    //   echo "Opening MEH...<br>";
    //   opendir($file_location);
    // }
  }
}
echo "</div>";

?>
