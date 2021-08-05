<?php
  require_once('libs.php');
  require_once('style.css');
  session_start();

  //array array_new();
 ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf8_general_ci">
     <title></title>
   </head>
   <body>

     <form id="newform" class="" action="viewer.php" method="post">
       <?php
       for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
        {
         echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i).":</label> ";
         echo "<input type='text' id=".$_SESSION['entry1']->get_clm_array_at($i)." name=".$_SESSION['entry1']->get_clm_array_at($i)."><br><br>";
        }
       ?>

         <br><br><input type="submit" value="Aggiungi" name="aggiungi">
     </form>
   </body>
 </html>
