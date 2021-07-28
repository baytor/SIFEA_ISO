<?php
  require_once('libs.php');
  session_start();
   //devo cercare di escludere quello che già compare in index --> includo libs invece che index
   //(tipo il messaggio di benvenuto e i direzionatori delle tabelle (es.: materiali d'apporto))

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

        <select id="menutendina" name="menutendina">
          <?php

          //mi memorizza la scelta in modo da lasciare il menù sullo stesso valore
          $_SESSION['menutendina'] = $_POST['menutendina'];

           for($i = 0; $i < count($clm_array); $i++)
           {
             if(isset($_SESSION['menutendina']) && $_SESSION['menutendina'] == $clm_array[$i])
             {  //se è uguale alla selezione precedente aggiunge l'opzione "selected"
                echo "<option value=$clm_array[$i] selected>$clm_header[$i]</option>";
             }
             else
             {  //altrimenti no la aggiunge
               echo "<option value=$clm_array[$i]>$clm_header[$i]</option>";
             }
           }
          ?>
        </select>

        <input type="text" name="searchbar">
        <input type="checkbox" id="escludiesauriti" name="escludiesauriti" checked>
        <label for="escludiesauriti"> Escludi esauriti</label><br><br>
        <input type="submit" value="Cerca" name="searchbtn"><br><br><br><br>
      </form>

     <?php
      $entry1 = $_SESSION["entry1"];
      $entry1->db_connection_on();

      if(isset($_POST['searchbtn']))
        {
          // mi serve per comporre "where *menu* like *** and Attiva is 1";
          $sql_string = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE " . $_POST['menutendina']
                         . " LIKE " . "'%". $_POST['searchbar'] ."%'";
         if(isset($_POST['escludiesauriti']))
          {
            $sql_string .= " AND Attiva = 1 ";
          }

          $sql_string .= " ORDER BY " . $_POST['menutendina'] . " ASC, " . $entry1->get_clm_array_at(13) . " DESC";
          $entry1->select_rows_by_string_by_pos($sql_string, 1, 14);

          //$entry1->select_rows_by_pos_where_like(1, 14, $_POST['menutendina'],$_POST['searchbar']);
          //$entry1->select_where($_POST['Ricerca'],$_POST['searchbar']);
        }
      $entry1->db_connection_off();
     ?>

    </body>
  </html>
