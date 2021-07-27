<?php
  require_once('libs.php');
  session_start();
   //devo cercare di escludere quello che già compare in index
   //(tipo il messaggio di benvenuto e i direzionatori delle tabelle (es.: materiali d'apporto))
   //Qui l'Header è uguale al nome delle colonne del DB --> si possono settare dei nomi formattati meglio

   //qui si settano tutti i parametri dei pulsanti di scelta presenti su index.php
   if(isset($_GET['matapporto']))
   {
     $_SESSION['clm_header'] = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
          "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");
     $_SESSION['clm_array'] = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",
             "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");
     $_SESSION['name'] = "Materiali apporto";
     $_SESSION['table'] = "materiali_apporto";
   }

   //$name, $clm_header, $clm_array, $servername, $username, $password, $dbname, $table

    $name = $_SESSION['name'];
    $clm_header = $_SESSION['clm_header'];
    $clm_array = $_SESSION['clm_array'];
    $table = $_SESSION['table'];

    $_SESSION["entry1"] = new dbEntry($name, $clm_header, $clm_array, "localhost", "root", "", "test", $table);

  ?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title></title>
    </head>
    <style>

 	 		table {
 				border-collapse: collapse;
 				width: 100%;
 			}

 			th, td {
 				padding: 15px;
   			text-align: center;
 				border-bottom: 5px solid #ddd;
 			}

 			tr:hover {background-color:#f5f5f5;}

 	 </style>
    <body>

      <form id="searchform" method="post" action="viewer.php">
        <label for="where">Ricerca: </label>

        <select id="Ricerca" name="Ricerca">
          <?php
           for($i = 0; $i < count($clm_array); $i++)
           {
             echo "<option value=$clm_array[$i]>$clm_header[$i]</option>";
           }
          ?>
        </select>

        <input type="text" name="searchbar"><br><br>
        <input type="submit" value="Cerca" name="search"><br><br><br><br>
     </form>

     <?php

      $entry1 = $_SESSION["entry1"];
      $entry1->db_connection_on();
      if(isset($_POST['search']))
        {
          $entry1->select_rows_by_pos_where_like(1, 14, $_POST['Ricerca'],$_POST['searchbar']);
          //$entry1->select_where($_POST['Ricerca'],$_POST['searchbar']);
        }
      $entry1->db_connection_off();
     ?>

    </body>
  </html>
