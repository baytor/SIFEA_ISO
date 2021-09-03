<?php
require_once('libs_code.php');
//require_once('style.css');
session_start();

echo "
<div class=newformdiv>
<form id=newform method=post action=viewer.php>
<div class=datadiv>"; 

if(isset($_POST['modifica']) || isset($_POST['aggiorna']))
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
}
elseif (isset($_POST['nuovo'])) //questo serve se si crea un oggetto nuovo da 0
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
}

echo "
</div>
<div class=buttonsdiv>
<button type=submit class=btn name=conferma>Conferma</button>
<button type=submit class=btn name=annulla>Annulla</button>
</div>
</form>
</div>";
?>
