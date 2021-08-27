<?php
  require_once('libs_code.php');
  //require_once('style.css');
  session_start();
   //devo cercare di escludere quello che già compare in index --> includo libs invece che index
   //(tipo il messaggio di benvenuto e i direzionatori delle tabelle (es.: materiali d'apporto))

   //qui si settano tutti i parametri dei pulsanti di scelta presenti su index.php
   include ('config_viewer_code.php');

   //$name, $clm_header, $clm_array, $servername, $username, $password, $dbname, $table
   //servono perché li uso anche sotto
    $name = $_SESSION['name'];
    $clm_header = $_SESSION['clm_header'];
    $clm_array = $_SESSION['clm_array'];
    $input_type = $_SESSION['input_type'];
    $table = $_SESSION['table'];

    $_SESSION["entry1"] = new dbEntry($name, $clm_header, $clm_array, $input_type, "localhost", "root", "", "test", $table);
    //ATTENZIONE BISOGNA TROVARE IL POSTO PER SETTARE I DATI DEL DB

echo"<div class='formdiv'>
      <form id=searchform method=post action=viewer.php>
        <label for=where>Ricerca: </label>
        <select id=menutendina name=menutendina>";

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

      echo "</select>";

      //per escludi esauriti bisognerebbe trovare un nome generico o inserire una variabile
      echo "
        <input type=text name=searchbar>
        <br><label for=escludiesauriti>Escludi esauriti</label>
        <input type=checkbox id=escludiesauriti name=escludiesauriti checked>
        <button type=submit name=searchbtn>Cerca</button>
      </form>

      <form id=new_row method=post action=new.php>
        <button type=submit name=nuovo>Nuovo</button>
      </form></div>";

      $entry1 = $_SESSION["entry1"];
      $entry1->db_connection_on();

      //azione di aggiungere la nuova riga --> vedi new.php
      //bisogna vedere se id applica l'auto increment e bisogna settare
      //'Attiva' = 1, magari a mano in ultima riga.
      if (isset($_POST['aggiungi']))
      {
        $array_new = array();
        array_push($array_new,""); //per l'id che in realtà verrà assegnato dal DB in quanto primary, unique, AI;
        for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
        {
          array_push($array_new,$_POST[$_SESSION['entry1']->get_clm_array_at($i)]);
        }
        array_push($array_new,1); //per l'ultima voce;
        echo "voce aggiunta _ array: " .implode(" // ",$array_new);
        $_SESSION['entry1']->insert_row($array_new);
      }

      if(isset($_POST['searchbtn'])) //VEDIAMO SE SI RIESCE A FARLO PERSONALIZZABILE
        {
          // mi serve per comporre "where *menu* like *** and Attiva is 1";
          $sql_string = "SELECT * FROM " . $entry1->get_dbtable() . " WHERE " . $_POST['menutendina']
                         . " LIKE " . "'%". $_POST['searchbar'] ."%'";
         if(isset($_POST['escludiesauriti']))
          {
            $sql_string .= " AND Attiva = 1 ";
          }

          $sql_string .= " ORDER BY " . $_POST['menutendina'] . " ASC, " . $entry1->get_clm_array_at(13) . " DESC";
          //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1
          $entry1->select_rows_by_string_by_pos($sql_string, 1, count($entry1->get_clm_array())-2);

          //$entry1->select_rows_by_pos_where_like(1, 14, $_POST['menutendina'],$_POST['searchbar']);
          //$entry1->select_where($_POST['Ricerca'],$_POST['searchbar']);
        }
        else
        {
          //escludo la visualizzazione della chiave primaria alla pos 0 e "Attiva" alla pos $entry1->get_clm_array()-1
          $entry1->select_rows_by_pos(1,count($entry1->get_clm_array())-2);
        }

      $entry1->db_connection_off();
     ?>
