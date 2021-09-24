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
elseif (isset($_POST['newrev']))
{
  echo "
  <div class=newformdiv>
  <form id=newform method=post action=modify.php>
  <div class=datadiv>";
  $_SESSION['datainsert'] = "update";
  //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
  //rozzo ma funziona

  //NB --> INPUT TYPE VA DEFINITO COME VARIABILE PERCHé A SECONDA DEL CAMPO CI SONO OPZIONI DIVERSE
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    $_SESSION['entry1']->db_connection_on();

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
  echo "
  <div class=newformdiv>
  <form id=newform method=post action=viewer.php>
  <div class=datadiv>";
  $_SESSION['datainsert'] = "update";
  //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
  //rozzo ma funziona

  //NB --> INPUT TYPE VA DEFINITO COME VARIABILE PERCHé A SECONDA DEL CAMPO CI SONO OPZIONI DIVERSE
  for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
  {
    $_SESSION['entry1']->db_connection_on();

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
      //se ci sono degli spazi bisogna mettere "' * '" negli input altrimenti inserisce solo la prima parola della frase
    }
  }
  echo "
  </div>
  <div class=buttonsdiv>
  <button type=submit class=btn name=copia>Copia</button>
  <button type=submit class=btn name=elimina>Elimina</button>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>
  </form>
  </div>";
  $_SESSION['entry1']->db_connection_off();
}

//aaa1(); //da togliere, è per vedere se posso definire una funzione su un altro file

if(isset($_SESSION['attachment']))
{
  echo "<div class=buttonsattachmentdiv>";
  create_attachment_button($_SESSION['attachment']);
  echo "</div>";
}

for($i = 0; $i < count($_SESSION['attachment']); $i++)
{
  if(isset($_POST[$_SESSION['attachment'][$i][0]]))
  {
    echo "Premuto" . $_SESSION['attachment'][$i][0] . "<br>";

    $file_location = $_SESSION['attachment'][$i][1]
                    .$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($_SESSION['attachment'][$i][2])]
                    .$_SESSION['attachment'][$i][3];

    if($_SESSION['attachment'][$i][3] != "")
    {
      echo "Opening $file_location<br>";
      system($file_location);
    }
    else
    {
      //se l'estensione del file (e anche il nome file) è vuoto vorrei aprisse la directory
      //ma non va...
      opendir($file_location);
    }

  }
}

function create_attachment_button(array $attachment)
{
  echo "<form id=attachment method=post action=new.php>";
  // "Certificato", "'Z:\Documenti\Qualità\Saldatura\Materiale d'apporto\'", 6, "'.pdf'"
  for($i = 0; $i < count($attachment); ++$i)
  {
    $btn_name       = $attachment[$i][0];
    $prefix_folder  = $attachment[$i][1];
    $clm_row        = $attachment[$i][2];
    $file_extension = $attachment[$i][3];

    $file = $prefix_folder.$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($clm_row)].$file_extension;
    // move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    // output per // DEBUG:
    // echo "<br>Session row_search: " . $_SESSION['row_search'] ." colonna: ".$_SESSION['entry1']->get_clm_array_at($clm) ." valore: ".$_SESSION['row'][$_SESSION['entry1']->get_clm_array_at($clm)] ." clm: " . $clm . " button_name " . $button_name . "<br>";
    $file = preg_replace("/'/", "&#39;", $file);
    $_SESSION['file'] = $file;
    echo "<br>bottone collegato al file: $file con attachment[0]=".$btn_name."<br>";

    //echo "<a href='$file'><button type=submit class=btn name=".$attachment[$i][0].">".$attachment[$i][0]."</button></a>";
    // echo "<input type="file" name=."$attachment[$i][0]".>"
    echo "<button type=submit class=btn name=$btn_name>$btn_name</button>";
    //echo "<a href=\\Sifea_ISO\\Ordine%20nr%2021-00448.pdf.ink>ciao</a>";
  }
  echo "</form>";
}

?>
