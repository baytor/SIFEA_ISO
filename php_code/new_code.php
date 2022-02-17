<?php
require_once('libs_code.php');
session_start();
require_once('config_viewer_code.php');

if (isset($_GET['search']))
{
  // action($_GET['search']); //NNEC
  $_SESSION['row_search'] = $_GET['search'];
  // echo "<br><br>Selezionato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
}

if (isset($_POST['nuovo'])) //questo serve se si crea un oggetto nuovo da 0
{
  echo "
  <div class=newformdiv>
  <form id=newform method=post action=viewer.php>
  <div class=datadiv>";

  $_SESSION['datainsert'] = "new";
  //ciclo per creare il form su tutte le colonne
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    if ($i == count($_SESSION['entry1']->get_clm_array())-2 || $i == count($_SESSION['entry1']->get_clm_array())-3)
    {
      $today = date("Y-m-d");

      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value= '$today'"
      ."><br>";
      continue;
    }
    if($_SESSION['entry1']->get_input_type_at($i) == "textarea")
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<textarea id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ."></textarea><br>";
    }
    elseif(str_contains($_SESSION['entry1']->get_input_type_at($i), "select"))
    {
      $a = explode("___",$_SESSION['entry1']->get_input_type_at($i));

      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<select name=".$_SESSION['entry1']->get_clm_header_at($i)." id=".$_SESSION['entry1']->get_clm_header_at($i).">";
      for($t = 1; $t < count($a); $t++)
      {
        echo "<option value=".$a[$t].">".$a[$t]."</option>";
        //echo "<option value=".$row[$_SESSION['entry1']->get_clm_array_at($i)].">".$a[$t]."</option>";
      }
      echo "</select>";
    }
    elseif($_SESSION['entry1']->get_input_type_at($i) == "date") //solo se è una voce nuova
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value=".$today
      ."><br>";
    }
    else
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ."><br>";
    }
  }
  //$_SESSION['entry1']->insert_row();
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>
  </form>
  </div>";
}
elseif (isset($_POST['newrev']))
{
  $_SESSION['entry1']->db_connection_on();
  $_SESSION['datainsert'] = "update";
  //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
  //rozzo ma funziona

  //NB --> INPUT TYPE VA DEFINITO COME VARIABILE PERCHé A SECONDA DEL CAMPO CI SONO OPZIONI DIVERSE

  // for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  // {
  $_SESSION['entry1']->sql = "SELECT * "
  . " FROM " . $_SESSION['entry1']->get_dbtable()
  . " WHERE " . $_SESSION['entry1']->get_clm_array_at(0)
  . " = " . $_SESSION['row_search'];
  $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
  $row = $_SESSION['entry1']->result->fetch_assoc();

  $_SESSION['row'] = $row;
  // array_push($array_values, $row);

  //controllo riga per riga --> se come campo è richiesto il textarea devo fare una cosa completamente diversa
  //rispetto al campo input
  echo "
  <div class=newformdiv>
  <form id=newform method=post action=modify.php>
  <div class=datadiv>";

  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array()); $i++)
  {
    if ($i == count($_SESSION['entry1']->get_clm_array())-2)
    {
      $today = date("Y-m-d");


      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value= '$today'"
      ."><br>";
      continue;
    }
    if($_SESSION['entry1']->get_input_type_at($i) == "textarea")
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<textarea id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      .">"
      . $row[$_SESSION['entry1']->get_clm_array_at($i)]
      . "</textarea><br>";
    }
    elseif(str_contains($_SESSION['entry1']->get_input_type_at($i), "select"))
    {
      $a = explode("___",$_SESSION['entry1']->get_input_type_at($i));

      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<select name=".$_SESSION['entry1']->get_clm_header_at($i)." id=".$_SESSION['entry1']->get_clm_header_at($i).">";
      for($t = 1; $t < count($a); $t++)
      {
        $selected = "";
        if($a[$t] == $row[$_SESSION['entry1']->get_clm_array_at($i)])
        {$selected = "selected";}
        echo "<option value=".$a[$t]." $selected>".$a[$t]."</option>";
        // echo "<option value=".$row[$_SESSION['entry1']->get_clm_array_at($i)].">".$a[$t]."</option>";
      }
      echo "</select>";
    }
    else //text oppure number
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value='".$row[$_SESSION['entry1']->get_clm_array_at($i)]."'><br>";
      //se ci sono degli spazi bisogna mettere "' * '" negli input altrimenti inserisce solo la prima parola della frase
    }
  }
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=newrev>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>
  </form>
  </div>";
  $_SESSION['entry1']->db_connection_off();
}
else
{
  $_SESSION['datainsert'] = "update";
  //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
  //rozzo ma funziona

  //NB --> INPUT TYPE VA DEFINITO COME VARIABILE PERCHé A SECONDA DEL CAMPO CI SONO OPZIONI DIVERSE

  echo "
  <div class=newformdiv>
  <form id=newform method=post action=viewer.php>
  <div class=datadiv>";

  $_SESSION['entry1']->db_connection_on();
  $_SESSION['entry1']->sql = "SELECT * "
  . " FROM " . $_SESSION['entry1']->get_dbtable()
  . " WHERE " . $_SESSION['entry1']->get_clm_array_at(0)
  . " = " . $_SESSION['row_search'];
  $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
  $row = $_SESSION['entry1']->result->fetch_assoc();

  $_SESSION['row'] = $row;

  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array()); $i++)
  {
    // array_push($array_values, $row);

    //controllo riga per riga --> se come campo è richiesto il textarea devo fare una cosa completamente diversa
    //rispetto al campo input
    if ($i == count($_SESSION['entry1']->get_clm_array())-2)
    {
      $today = date("Y-m-d");
      echo "Today $today<br>";
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value= '$today'"
      ."><br>";
      continue;
    }
    if($_SESSION['entry1']->get_input_type_at($i) == "textarea")
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<textarea id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      .">"
      . $row[$_SESSION['entry1']->get_clm_array_at($i)]
      . "</textarea><br>";
    }
    elseif(str_contains($_SESSION['entry1']->get_input_type_at($i), 'select'))
    {
      $a = explode("___",$_SESSION['entry1']->get_input_type_at($i)); //array

      echo "<label for=".$_SESSION['entry1']->get_clm_array_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<select name=".$_SESSION['entry1']->get_clm_array_at($i)." id=".$_SESSION['entry1']->get_clm_array_at($i).">";
      for($t = 1; $t < count($a); $t++)
      {
        $selected = "";
        if($a[$t] == $row[$_SESSION['entry1']->get_clm_array_at($i)])
        {$selected = "selected";}
        echo "<option value=".$a[$t]." $selected>".$a[$t]."</option>";
        //echo "<option value=".$row[$_SESSION['entry1']->get_clm_array_at($i)].">".$a[$t]."</option>";
      }
      echo "</select>";
      $str = implode("_", $a);
      echo "array a implode: $str<br>";
    }
    elseif($_SESSION['entry1']->get_input_type_at($i) == "checkbox") //OCCHIO
    {
      $checked = "";
      if($row[$_SESSION['entry1']->get_clm_array_at($i)] == 1)
      {
        $checked = "checked";
      }
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label>";
      echo "<input type='".$_SESSION['entry1']->get_input_type_at($i)
      ."' id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value='".$row[$_SESSION['entry1']->get_clm_array_at($i)]
      ."' $checked>"; //Bisogna capire come collegare il check col valore 1 o 0
    }
    else //text oppure number
    {
      echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i)."</label><br>";
      echo "<input type=".$_SESSION['entry1']->get_input_type_at($i)
      ." id=".$_SESSION['entry1']->get_clm_array_at($i)
      ." name=".$_SESSION['entry1']->get_clm_array_at($i)
      ." value='".$row[$_SESSION['entry1']->get_clm_array_at($i)]
      ."'><br>";
      //se ci sono degli spazi bisogna mettere "' * '" negli input altrimenti inserisce solo la prima parola della frase
    }
  }
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=copia>Copia</button>
  <button type=submit class=btn name=elimina>Elimina</button>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>";
  create_optional_button($_SESSION['name']);
  echo "
  </div>
  </form>
  </div>";
  $_SESSION['entry1']->db_connection_off();
}

if(isset($_SESSION['attachment']) && !isset($_POST['nuovo'])) //se è nuovo i pulsanti degli allegati non si vedono ancora || TBD-> se il file non c'è lo carica, così se è nuovo si carica il file
echo "<form id=pdfbrowse method=post action=pdfbrowse.php target=_blank>";
{
  echo "<div class=buttonsattachmentdiv>";
  // create_attachment_button($_SESSION['attachment']);
  for($i = 0; $i < count($_SESSION['attachment']); ++$i)
  {
    $btn_name = $_SESSION['attachment'][$i][0];
    echo "<button type=submit class=btn name=$btn_name>$btn_name</button>";
  }
  echo "</form>";
  echo "</div>";
}

//Accorpato sopra per comodità --> facciamo una prova
//questa adesso è inutilizzata
function create_attachment_button(array $attachment)
{
  echo "<form id=pdfbrowse method=post action=pdfbrowse.php target=_blank>";

  for($i = 0; $i < count($attachment); ++$i)
  {
    $btn_name       = $attachment[$i][0];

    //  se il file con quel nome non esiste ==> INPUT_FILE
    //  se il file con quel no

    $file_folder    = $attachment[$i][1];
    $file_name      = $_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($attachment[$i][2])];
    $file_extension = $attachment[$i][3];

    $file = $file_folder.$file_name.$file_extension;
    $file = preg_replace("/'/", "&#39;", $file);
    echo "<input type=file id=$btn_name name=$btn_name value=$file hidden>";
    $_FILES[$btn_name]['name'] = $file_name;
    echo "<br>".$_FILES[$btn_name]['name']."<br>";
    move_uploaded_file($_FILES[$btn_name]["tmp_name"], $target_file);

    // output per // DEBUG:
    // echo "<br>Session row_search: " . $_SESSION['row_search'] ." colonna: ".$_SESSION['entry1']->get_clm_array_at($clm) ." valore: ".$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($clm)] ." clm: " . $clm . " button_name " . $button_name . "<br>";

    // $_SESSION['file'] = $file;
    //echo "<br>bottone collegato al file: $file con attachment[0]=".$btn_name."<br>";
    // echo "<a href='$file'><button type=submit class=btn name=".$attachment[$i][0].">".$attachment[$i][0]."</button></a>";
    echo "<button type=submit class=btn name=$btn_name>$btn_name</button>";
    // echo "<a href=Z:\\Documenti\Undicesimo\\01%20-%20Ordini%20Fornitori%20inviati\\>ciao</a>";
  }
  echo "</form>";
}

?>
