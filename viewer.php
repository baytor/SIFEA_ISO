<?php
  require_once('index.php');
   //devo cercare di escludere quello che già compare in index
   //(tipo il messaggio di benvenuto e i direzionatori delle tabelle (es.: materiali d'apporto))
   //Qui l'Header è uguale al nome delle colonne del DB --> si possono settare dei nomi formattati meglio
     $clm_header = array("id", "Nome articolo", "Gruppo Filler Metal", "SFA / AWS", "EN ISO", "Diametro", "Colata / lotto",
              "unità di misura", "quantità", "Trattamento termico", "Tempo di permanenza ", "Ordine", "Data di carico", "Data di aggiornamento", "Note", "Attiva?");
     $clm_array = array("id", "nome_articolo", "gruppo_fm", "SFA_AWS", "EN_ISO", "diametro", "Colata_lotto",
                 "unita_misura", "quantita", "HT", "permanenza_HT", "ordine", "data_carico", "data_aggiornamento", "Note", "Attiva");
     $entry_name = "Materiali apporto";
     $table_name = "materiali_apporto";


     $_SESSION["entry1"] = new dbEntry($entry_name, $clm_header, $clm_array, "localhost", "root", "", "test", $table_name);

  ?>

  <form method="post" action="viewer.php">
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
    <input type="submit" value="Cerca" name="submit"><br><br><br><br>
 </form>

 <?php

    $entry1 = $_SESSION["entry1"];
    $entry1->db_connection_on();
    if(isset($_POST['submit']))
      {
        $entry1->select_rows_by_pos_where_like(1, 14, $_POST['Ricerca'],$_POST['searchbar']);
        //$entry1->select_where($_POST['Ricerca'],$_POST['searchbar']);
      }

    $entry1->db_connection_off();

  ?>
