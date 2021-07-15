<?php
  require_once('index.php');

  if (isset($_GET['search']))
    {
        //search($_GET['search']);
        $_SESSION['entry1']->db_connection_on();
        //$_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$_GET['search']);
        $_SESSION['entry1']->select_rows_by_string("SELECT * FROM ".$_SESSION['entry1']->table .
                                                    " WHERE " .$_SESSION['entry1']->clm_array[6] . " = ".$_GET['search'].
                                                    " ORDER BY ". $_SESSION['entry1']->clm_array[15]);
        $_SESSION['entry1']->db_connection_off();
    }

    // function Search($res)
    // {
    //     $_SESSION['entry1']->db_connection_on();
    //     $_SESSION['entry1']->select_where($_SESSION['entry1']->clm_array[0],$res);
    //     $_SESSION['entry1']->db_connection_off();
    // }

?>
