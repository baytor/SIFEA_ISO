<?php
  // qui va scelta la tabella con degli appositi bottoni
  // quindi dovviamo togliere il visualizzatore e metterlo su viewer.php
  require_once('libs_code.php');
  //require_once('style.css');
  session_start();
  // echo "session start";

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("Refresh: 2; location: login.php");
  }

  // <!-- Ho modificato la parte copiata per fare in modo di avere 2 corpi:
  // 1 prima del HTML e uno alla fine del body, come richiesto su mobyrise -->

    if (isset($_SESSION['success']))
    {
      echo $_SESSION['success'];
      unset($_SESSION['success']);
    }

   if (isset($_SESSION['username']))
  {
     echo "<p1>Welcome ". $_SESSION['username']."<br><br></p1>";
     //echo "<a href=index.php?logout='1' style=color: red;>logout</a> </p>";
  }


echo "
<form id=catalogo method=get action=viewer.php>
  <button type=submit name=matapporto>Materiali d'apporto</button>
</form>";

?>
