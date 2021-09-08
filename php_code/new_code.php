<?php
require_once('libs_code.php');
//require_once('style.css');
session_start();

if (isset($_GET['search']))
{
  // action($_GET['search']); //NNEC
  $_SESSION['row_search'] = $_GET['search'];
  // echo "<br><br>Selezionato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
}

echo "
<div class=newformdiv>
<form id=newform method=post action=viewer.php>
<div class=datadiv>";

if (isset($_POST['nuovo'])) //questo serve se si crea un oggetto nuovo da 0
{
  $_SESSION['datainsert'] = "new";
  //ciclo per creare il form su tutte le colonne
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    if($_SESSION['entry1']->get_input_type_at($i) == "textarea")
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<textarea id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ."></textarea><br>";
    }
    else
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ."><br>";
    }
  }
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>
  </form>
  </div>";
}
else
{
  $_SESSION['datainsert'] = "update";
  //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
  //rozzo ma funziona

  //NB --> INPUT TYPE VA DEFINITO COME VARIABILE PERCHé A SECONDA DEL CAMPO CI SONO OPZIONI DIVERSE
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    $_SESSION['entry1']->db_connection_on();

    $_SESSION['entry1']->sql = "SELECT " . $_SESSION['entry1']->get_clm_array_at($i)
    . " FROM " . $_SESSION['entry1']->get_dbtable()
    . " WHERE " . $_SESSION['entry1']->get_clm_array_at(0)
    . " = " . $_SESSION['row_search'];
    $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
    $row = $_SESSION['entry1']->result->fetch_assoc();

    //controllo riga per riga --> se come campo è richiesto il textarea devo fare una cosa completamente diversa
    //rispetto al campo input

    if($_SESSION['entry1']->get_input_type_at($i) == "textarea")
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<textarea id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      .">"
      . $row[$_SESSION['entry1']->get_clm_array_at($i)]
      . "</textarea><br>";
    }
    else
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value='".$row[$_SESSION['entry1']->get_clm_array_at($i)]."'><br>";
      //se ci sono degli spazi bisogna mettere '" * "' negli input altrimenti inserisce solo la prima parola della frase
    }
    $_SESSION['entry1']->db_connection_off();
  }
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=copia>Copia</button>
  <button type=submit class=btn name=elimina>Elimina</button>
  <button type=submit class=btn name=newrev>Aggiungi revisione</button>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>
  </form>
  </div>";
}

// function action($search)  //NNEC
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
?>
