<?php
require_once('libs_code.php');
require_once('db_config_code.php');

//devo cercare di escludere quello che già compare in index --> includo libs invece che index
//(tipo il messaggio di benvenuto e i direzionatori delle tabelle (es.: materiali d'apporto))
session_start();

//qui si settano tutti i parametri dei pulsanti di scelta presenti su index.php
include('config_viewer_code.php');

//$name, $clm_header, $clm_array, $servername, $username, $password, $dbname, $table
//servono perché li uso anche sotto
$name = $_SESSION['name'];
$clm_header = $_SESSION['clm_header'];
$clm_array = $_SESSION['clm_array'];
$input_type = $_SESSION['input_type'];
$table = $_SESSION['table'];

//datainsert serve per sapere quale pulsante per inserimento dati è premuto:
//nuovo (new), modifica (salva), aggiungi revisione (newrev), copia(copia)
//elimina (elimina) o esci(esci)
if(!isset($_SESSION['datainsert']))
{
  $_SESSION['datainsert'] = "";
}

$_SESSION["entry1"] = new dbEntry($name, $clm_header, $clm_array, $input_type, $servername_db, $username_db, $password_db, $dbname_db, $table);

$entry1 = $_SESSION["entry1"];
$entry1->db_connection_on();

echo
"<div class='searchformdiv'>
<form id=searchform method=post action=viewer.php>
<div class='selectdiv'>
<label for=where>Ricerca: </label>
<select id=menutendina name=menutendina>";

//mi memorizza la scelta in modo da lasciare il menù sullo stesso valore
$_SESSION['menutendina'] = $_POST['menutendina'];

echo "<option value='concat(";
//ricerca tutti i campi
for($i = 0; $i < count($clm_array)-2; $i++)
{
  echo $clm_array[$i]. ", ";
}
echo $clm_array[count($clm_array)-2]; //così si esclude Attiva (che viene aggiunto dopo se richiesto)
if(isset($_SESSION['menutendina']) && $_SESSION['menutendina'] == $clm_array[$i])
{  //se è uguale alla selezione precedente aggiunge l'opzione "selected"
  echo ")' selected>Tutti i campi</option>";
}
else
{  //altrimenti non la aggiunge
  echo ")'>Tutti i campi</option>";
}

//ricerca i singoli campi
for($i = 0; $i < count($clm_array); $i++)
{
  if(isset($_SESSION['menutendina']) && $_SESSION['menutendina'] == $clm_array[$i])
  {  //se è uguale alla selezione precedente aggiunge l'opzione "selected"
    echo "<option value=$clm_array[$i] selected>$clm_header[$i]</option>";
  }
  else
  {  //altrimenti non la aggiunge
    echo "<option value=$clm_array[$i]>$clm_header[$i]</option>";
  }
}

echo "</select>";

//per escludi esauriti bisognerebbe trovare un nome generico o inserire una variabile
echo "
<input type=text name=searchbar>
</div>
<div class='checkboxdiv'>
<label for=escludiesauriti>Escludi esauriti</label>
<input type=checkbox id=escludiesauriti name=escludiesauriti checked>
</div>
<div class='searchbtndiv'>
<button type=submit name=searchbtn>Cerca</button>
</div>
</form>
</div>

<div class='newbtnformdiv'>
<form id=new_row method=post action=new.php>
<button type=submit name=nuovo>Nuovo</button>
</form>
</div>";

if (isset($_POST['copia']))
{
  // sarebbe utile che, dopo aver premuto copia, si vada sulla pagina col giusto id
  // corrispondente all'oggetto copiato in modo da modificarlo subito
  // e che magari abbia già la data di creazione impostata (ma anche no...)
  //
  //   echo "<br><br>(_DA FARE_) Copiato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
}
if (isset($_POST['elimina']))
{
  echo "<br><br>Eliminato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
  $_SESSION['entry1']->delete_row($_SESSION['row_search']);
}
if (isset($_POST['newrev']))
{
  //   copiare con cambiato il/gli elementi che servono
  //   echo "<br><br>(_DA FARE_) Copiato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
}
//azione di salvataggio riga (sia nuova che modificata)--> vedi new.php
//bisogna vedere se id applica l'auto increment e bisogna settare
//'Attiva' = 1, magari a mano in ultima riga.
if (isset($_POST['salva']))
{
  $array_new = array();
  array_push($array_new,""); //per l'id che in realtà verrà assegnato dal DB in quanto primary, unique, AI;
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    array_push($array_new,$_POST[$_SESSION['entry1']->get_clm_array_at($i)]);
  }
  array_push($array_new,1); //per l'ultima voce;

  if ($_SESSION['datainsert'] == "new") //funziona
  {
    $_SESSION['entry1']->insert_row($array_new);
  }
  elseif ($_SESSION['datainsert'] == "update") // funziona
  {
    //echo "updated id: ". $_SESSION['row_search'] . " array: ".implode("_",$array_new). "<br>";
    $_SESSION['entry1']->update_row($_SESSION['row_search'], $array_new);
    //echo $_SESSION['entry1']->sql; //per DEBUG
  }
  else
  {
    echo "datainsert is: " . $_SESSION['datainsert'] . "<br>";
    echo "<p>FATAL ERROR!!!!!!!!<br>WE'RE ALL GONNA DIIIIIIIIIIIIIIIIIIIIIIIEEEEEEEEEEEEEEEEEEEEEEEE!!!!</p>";
  }
}

if (isset($_POST['esci']))
{
  //echo "<p>Operazione annullata...</p><br>"; //Brutto da vedere perché resta lìììììììì
}

if(isset($_POST['searchbtn'])) //VEDIAMO SE SI RIESCE A FARLO PERSONALIZZABILE DIFFERENZIANDOLO PER OGNI PULSANTE
{
  // mi serve per comporre "where *menu* like *** and Attiva is 1";
  $sql_string = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE " . $_POST['menutendina']
  . " LIKE " . "'%". $_POST['searchbar'] ."%'";
  if(isset($_POST['escludiesauriti']))
  {
    $sql_string .= " AND " . $entry1->get_clm_array_at(count($entry1->get_clm_array())-1) . "= 1";
  }
  $sql_string .= " ORDER BY ";
  //se si ricerca in tutti i valori, esclude l'ordinamento per valore
  if(strpos($_POST['menutendina'], 'oncat') != true) //concat per intero non lo prendeva...
  {
    $sql_string .= $_POST['menutendina'] . " ASC, ";
  }
  //$entry1->get_clm_array_at(13) è la data di aggiornamento
  $sql_string .= $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC";
  //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1
  echo $sql_string;
  $entry1->select_rows_by_string_by_pos($sql_string, 1, count($entry1->get_clm_array())-2);
  //$entry1->select_rows_by_string_by_array($sql_string, $_SESSION['clm_data_array']);
}
else
{
  //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1
  // mi serve per comporre "where *menu* like *** and Attiva is 1";
  $sql_string = "SELECT * FROM " . $entry1->get_dbtable();
  $sql_string .= " WHERE " . $entry1->get_clm_array_at(count($entry1->get_clm_array())-1) . "=1";
  $sql_string .= " ORDER BY ";
  //$entry1->get_clm_array_at(13) è la data di aggiornamento
  $sql_string .= $entry1->get_clm_array_at(count($entry1->get_clm_array())-3) . " DESC";

  //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1
  //echo $sql_string;  //NNEC
  $entry1->select_rows_by_string_by_pos($sql_string, 1, count($entry1->get_clm_array())-2);
  //$entry1->select_rows_by_string_by_array($sql_string, $_SESSION['clm_data_array']);
}

$entry1->db_connection_off();
?>
