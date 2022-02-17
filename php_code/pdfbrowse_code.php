<?php

require_once('libs_code.php');
session_start();
require_once('config_viewer_code.php');

echo "<br><br><br><br><br><br><br><br>";
echo "<div class=pdfbrowser>";
// echo "<form id=pdfbrowse method=post action=pdfbrowse.php>";
echo "<form id=pdfbrowse method=post>";

if(isset($_POST['UploadedFile']))
{
  if(isset($_FILES['UploadedFile']['tmp_name'])) echo "File caricato<br>";
  else echo "File non trovato";
  // move_uploaded_file($_FILES['UploadedFile']['tmp_name'], $file);
}

for($i = 0; $i < count($_SESSION['attachment']); ++$i)
{
  if(isset($_POST[$_SESSION['attachment'][$i][0]]))
  {


    $file =
    $_SESSION['attachment'][$i][1].
    $_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])].
    $_SESSION['attachment'][$i][3];


    // header('Content-Transfer-Encoding: binary');
    // header('Accept-Ranges: bytes');

    echo "file name: $file<br>";

    if(!file_exists($file)) //(non)esiste il file
    {
      echo "il file non esiste<br>";
      // echo "<input type=file id=UploadedFile name=UploadedFile value=$file>";
      echo "<input type=file name=UploadedFile id=UploadedFile>";
      echo "<input type=submit value='Carica file' name=submit>";

      // $info = pathinfo($_FILES['userFile']['name']);
      // $ext = $info['extension']; // get the extension of the file
      // $newname = "newname.".$ext;
      // $target = 'images/'.$newname;
    }
    else
    {
      // header('Content-type: application/pdf');
      // header('Content-Disposition: inline; filename="' . $file . '"');
      // @readfile($file);//manca qualcosa...
      echo "il file esiste<br>";
    }

    //debug
    echo "<br><br><br><br><br><br><br>".$_SESSION['attachment'][$i][0]."<br>";
  }
}
echo "</form>";
echo "</div>";

?>
