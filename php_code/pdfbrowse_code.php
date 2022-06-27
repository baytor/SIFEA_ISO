<?php

require_once('libs_code.php');
session_start();
require_once('config_viewer_code.php');

echo "<br><br><br>";
// echo "<br><br><br><br><br><br><br><br>";
echo "<div class=pdfbrowser>";


for($i = 0; $i < count($_SESSION['attachment']); ++$i)
{
  if(isset($_POST[$_SESSION['attachment'][$i][0]]))
  {
    $_SESSION['file'] = $_SESSION['attachment'][$i][1];
    if(isset($_SESSION['attachment'][$i][2]))
    {
      $_SESSION['file'] .= $_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])];
      $_SESSION['file'] .= $_SESSION['attachment'][$i][3];
    }
    echo "isset " . $_SESSION['file'] . "<br>";
  }
}

if(isset($_POST['Upload']))
{
  print_r($_FILES);
  $filefrom = $_FILES['UploadedFile']['tmp_name'];
  $fileto = $_SESSION['file'];
  move_uploaded_file($filefrom, $fileto);
  echo "POST Upload $fileto";
}
else
{
  if(!file_exists($_SESSION['file'])) //(non)esiste il file
  {
    echo "<form id=pdfbrowse method=post action=pdfbrowse.php enctype='multipart/form-data'>";
    echo "il file ".$_SESSION['file']." non trovato";
    // echo "il file ".$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])]." non esiste1<br>";
    echo "<input type=file class=btn name='UploadedFile' id=UploadedFile>";
    echo "<button type=submit class=btn name=Upload>Carica file</button>";
    echo "</form>";
  }
  else //il file esiste
  {
    if(!is_file($_SESSION['file']))
    {
      // echo "<form id=pdfbrowse method=post action=pdfbrowse.php enctype='multipart/form-data'>";
      // echo "il file ".$_SESSION['file']." non trovato";
      // // echo "il file ".$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])]." non esiste1<br>";
      // echo "<input type=file class=btn name='UploadedFile' id=UploadedFile>";
      // echo "<button type=submit class=btn name=Upload>Carica un file</button>";
      // echo "</form>";
      $a = scandir($_SESSION['file']);
      echo $_SESSION['file'] . " found<br>";
      // print_r($a);
      foreach ($a as $file)
      {
        echo "<a href=file:///" . $_SESSION['file'].$file . " target=_blank>" . $file . "</a><br>";
      }
    }
    else
    {
      exec($_SESSION['file']);
    }
  }
}

echo "</div>";
?>
