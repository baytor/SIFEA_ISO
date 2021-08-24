<?php
  require_once('libs_code.php');
  //require_once('style.css');
  session_start();

    echo "
     <form id=newform class= action=viewer.php method=post>
         <br><br><input type=submit value=Aggiungi name=aggiungi>
     </form>";

     if(isset($_POST['modifica']))
     {
       //ciclo per creare il form su tutte le colonne con i valori preimpostati uguali
       //artificioso ma funziona
       for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
      {
        $_SESSION['entry1']->db_connection_on();

        $_SESSION['entry1']->sql = "SELECT " . $_SESSION['entry1']->get_clm_array_at($i)
                          . " FROM " . $_SESSION['entry1']->get_dbtable()
                          . " WHERE " . $_SESSION['entry1']->get_clm_array_at(0)
                          . " = " . $_SESSION['row_search'];
        $_SESSION['entry1']->result = $_SESSION['entry1']->conn->query($_SESSION['entry1']->sql);
        $row = $_SESSION['entry1']->result->fetch_assoc();

        echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i).":</label> ";
        echo "<input type='text' id=".$_SESSION['entry1']->get_clm_array_at($i)
            ." name=".$_SESSION['entry1']->get_clm_array_at($i)
            ." value=".$row[$_SESSION['entry1']->get_clm_array_at($i)]
            ."><br><br>";

        $_SESSION['entry1']->db_connection_off();
      }
    }
    else
    {
      //ciclo per creare il form su tutte le colonne
      for($i = 1; $i < count($_SESSION['entry1']->get_clm_array())-1; $i++)
      {
       echo "<label for=".$_SESSION['entry1']->get_clm_header_at($i).">".$_SESSION['entry1']->get_clm_header_at($i).":</label> ";
       echo "<input type='text' id=".$_SESSION['entry1']->get_clm_array_at($i)
           ." name=".$_SESSION['entry1']->get_clm_array_at($i)
           ."><br><br>";
      }
    }
     ?>
