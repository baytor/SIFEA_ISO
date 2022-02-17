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
  $_SESSION['row_search'] = $_GET['search'];
  $entry1 = $_SESSION['entry1'];
  $entry1->db_connection_on();

  // mi serve per comporre "where *menu* like *** and Attiva is 1";
  $sql_string = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE " . $entry1->get_clm_array_at(0) . " = ". $_SESSION['row_search']
  . " ORDER BY "
  . $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC"; //$entry1->get_clm_array_at(13) è la data di aggiornamento
  //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1


  $_SESSION['entry1']->sql = $sql_string;
  $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
  $row = $_SESSION['entry1']->result->fetch_assoc();
  $_SESSION['row'] = $row;

  // sarebbe bello integrare la riga successiva all'interno del ciclo FOR sfruttando $_GET['search'] che è la chiave primaria

  $entry1->select_rows_by_string_by_array($sql_string, $_SESSION['clm_data_array'][0]);
  echo "<br><p>Elenco revisioni:</p><br>";


  // for($i = 1; $i < count($_SESSION['clm_data_array']); ++$i)
  // {
  //   $sql_string2 = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE "
  //   . $entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i]) . " = '"
  //   . $row[$entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i])];
  //   $sql_string2 .= "' ORDER BY ";
  //   $sql_string2 .= $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC";
  //
  //   $entry1->select_rows_by_string_by_array($sql_string2, $_SESSION['clm_data_array'][$i]);
  // }

$sql_string2 = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE ";
  for($i = 1; $i < count($_SESSION['clm_data_array']); ++$i)
  {
    $sql_string2 .= $entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i]) . " = '"
    . $row[$entry1->get_clm_array_at($_SESSION['clm_data_array_dataindex'][$i])];
    $sql_string2 .= "' ORDER BY ";
    $sql_string2 .= $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC";

    $entry1->select_rows_by_string_by_array($sql_string2, $_SESSION['clm_data_array'][$i]);
    echo "$sql_string2<br>";
  }

  $entry1->db_connection_off();
}

if (isset($_POST['esci']))
{
  echo "sei uscito su viewer.php<br>";
  echo $sql_string."<br>";
  //echo "<p>Operazione annullata...</p><br>"; //Brutto da vedere perché resta lìììììììì
}

if(isset($_POST['newrev']))
{
  $_SESSION['entry1']->db_connection_on();

  //mette ATTIVA = 0
  $array_old = array();
  array_push($array_old, $_SESSION['row_search']);
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    array_push($array_old, $_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($i)]);
  }
  array_push($array_old,0); //per l'ultima voce;
  $_SESSION['entry1']->update_row($_SESSION['row_search'], $array_old);

  //inserisce la nuova riga
  $array_new = array();
  array_push($array_new,""); //per l'id che in realtà verrà assegnato dal DB in quanto primary, unique, AI;
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    array_push($array_new,$_POST[$_SESSION['entry1']->get_clm_array_at($i)]);
  }

  $status = 0;
  if (isset($_POST[$_SESSION['entry1']->get_clm_array_at(count($_SESSION['entry1']->get_clm_array())-1)])) $status = 1;
  array_push($array_new,$status); //per l'ultima voce;
  $_SESSION['entry1']->insert_row($array_new);

  echo "<br><br>Aggiunta revisione all'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
  $_SESSION['entry1']->db_connection_off();
}

echo "
<div class='formdiv'>
<form id=nuovo method=post action=new.php>
<button type=submit class=btn name=newrev>Aggiungi revisione</button>
</form>
<form id=revform method=post action=viewer.php>
<button type=submit class=btn name=esci>Esci</button>
</form>
</div>";
?>
