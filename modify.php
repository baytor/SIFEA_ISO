<?php
  require_once('viewer.php');

  if (isset($_GET['search']))
    {
        //search($_GET['search']);
        $_SESSION['entry1']->db_connection_on();
        //$_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$_GET['search']);
        $_SESSION['entry1']->select_rows_by_string("SELECT * FROM ".$_SESSION['entry1']->table.
                                                     " WHERE ".$_SESSION['entry1']->clm_array[6]." = ".$_GET['search'].
                                                     " ORDER BY ".$_SESSION['entry1']->clm_array[15]);
      //aggiungi bottoni di COPIA, AGGIORNA e ELIMINA

        $_SESSION['entry1']->db_connection_off();
    }
?>
