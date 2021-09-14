<?php     //Potermmo usarla per confermare la modifica o la cancellazione delle pagine
require_once('libs_code.php');
require_once('db_config_code.php');
session_start();


//potrei reintrodurre questa pagina e fare in modo che su questa pagina si vedano 2 blocchi:

//1) la parte comune a tutte le revisioni
//2) l'elenco di tutto quello che cambia ad ogni revisione
//

if (isset($_GET['search']))
{
  $entry1 = $_SESSION['entry1'];
  $entry1->db_connection_on();

  // mi serve per comporre "where *menu* like *** and Attiva is 1";
  $sql_string = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE " . $entry1->get_clm_array_at(0) . " = ". $_GET['search']
  . " ORDER BY "
  . $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC"; //$entry1->get_clm_array_at(13) è la data di aggiornamento
  //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1

  $_SESSION['entry1']->sql = $sql_string;
  $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
  $row = $_SESSION['entry1']->result->fetch_assoc();

  // sarebbe bello integrare la riga successiva all'interno del ciclo FOR sfruttando $_GET['search'] che è la chiave primaria
  $entry1->select_rows_by_string_by_array($sql_string, $_SESSION['clm_data_array'][0]);

  for($i = 1; $i < count($_SESSION['clm_data_array']); ++$i)
  {
    $sql_string2 = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE "
    . $entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i]) . " = "
    . $row[$entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i])];
    $sql_string2 .= " ORDER BY ";
    $sql_string2 .= $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC";

    $entry1->select_rows_by_string_by_array($sql_string2, $_SESSION['clm_data_array'][$i]);
    echo "<br>";
  }

  $entry1->db_connection_off();
}

//bisogna anche valutare che pulsanti mettere

// if (isset($_GET['search']))
// {
//   action($_GET['search']);
//   $_SESSION['row_search'] = $_GET['search'];
//   echo "<br><br>Selezionato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
// }
//
// if(isset($_POST['copia'])) //DA FARE
// {
//   // sarebbe utile che, dopo aver premuto copia, si vada su una pagina modify
//   // corrispondente all'oggetto copiato in modo da modificarlo subito
//   // e che magari abbia già la data di creazione impostata (ma anche no...)
//
//   echo "<br><br>(_DA FARE_) Copiato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
// }
//
// if(isset($_POST['elimina']))
// {
//   $_SESSION['entry1']->db_connection_on();
//   echo "<br><br>Eliminato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
//   $_SESSION['entry1']->delete_row($_SESSION['row_search']);
//   $_SESSION['entry1']->db_connection_off();
//   echo "Redirecting in 2 seconds";
//   header("refresh:2; url=viewer.php");
// }
//
// if(isset($_POST['modifica'])) //DA FARE
// {
//   //modifica la voce selezionata
//   $_SESSION['entry1']->db_connection_on();
//   echo "<br><br>(_DA FARE_) Modifica l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
//
//   $_SESSION['entry1']->db_connection_off();
// }
//
// if(isset($_POST['aggiorna'])) //DA FARE
// {
//   $_SESSION['entry1']->db_connection_on();
//   //aggiorna una voce:
//   //  + copia la voce mettendola in revisione (es.: aumenta il n° rev, aggiorna la data proponendo quella odierna...)
//   //    dando la possibilità di modificare i campi già esistenti;
//   //  + mette inattiva (0) la voce vecchia
//
//   echo "<br><br>(_DA FARE_) Aggiorna l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
//   $_SESSION['entry1']->db_connection_off();
// }
//
// function action($search)
// {
//   //search($_GET['search']);
//   $_SESSION['entry1']->db_connection_on();
//   //$_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$search);
//   $_SESSION['entry1']->select_rows_by_string_by_pos("SELECT * FROM ".$_SESSION['entry1']->get_dbtable().
//   " WHERE ".$_SESSION['entry1']->get_clm_array_at(0)."=".$search.
//   " ORDER BY ".$_SESSION['entry1']->get_clm_array_at(15). " DESC",
//   1,count($_SESSION['entry1']->get_clm_array())-2);
//   $_SESSION['entry1']->db_connection_off();
// }
//
// echo "
// <div class='formdiv'>
// <form id=row_options method=post action=modify.php>
// <button type=submit name=copia>Copia</button>
// <button type=submit name=elimina>Elimina</button>
// </form>
// <form id=row_options method=post action=new.php>
// <button type=submit name=modifica>Modifica</button>
// <button type=submit name=aggiorna>Aggiorna</button>
// </form>
// </div>";

?>
