<?php
  require_once('libs_code.php');
  session_start();

  if (isset($_GET['search']))
    {
        action($_GET['search']);
        $_SESSION['row_search'] = $_GET['search'];
        echo "<br><br>Selezionato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
    }

    if(isset($_POST['copia'])) //DA FARE
    {
      echo "<br><br>Copiato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
    }

    if(isset($_POST['elimina']))
    {
      $_SESSION['entry1']->db_connection_on();
      echo "<br><br>Eliminato l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
      $_SESSION['entry1']->delete_row($_SESSION['row_search']);
      $_SESSION['entry1']->db_connection_off();
      echo "Redirecting in 2 seconds";
      header("refresh:2; url=viewer.php");
    }

    if(isset($_POST['modifica'])) //DA FARE
    {
      //modifica la voce selezionata
      $_SESSION['entry1']->db_connection_on();
      echo "<br><br>Modifica l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";

      $_SESSION['entry1']->db_connection_off();
    }

    if(isset($_POST['aggiorna'])) //DA FARE
    {
      $_SESSION['entry1']->db_connection_on();
      //aggiorna una voce:
      //  + copia la voce mettendola in revisione (es.: aumenta il n° rev, aggiorna la data proponendo quella odierna...)
      //    dando la possibilità di modificare i campi già esistenti;
      //  + mette inattiva (0) la voce vecchia

      echo "<br><br>Aggiorna l'oggetto con chiave primaria = " . $_SESSION['row_search']."<br>";
      $_SESSION['entry1']->db_connection_off();
    }

    function action($search)
    {
      //search($_GET['search']);
      $_SESSION['entry1']->db_connection_on();
      //$_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$search);
      $_SESSION['entry1']->select_rows_by_string_by_pos("SELECT * FROM ".$_SESSION['entry1']->get_dbtable().
                                                   " WHERE ".$_SESSION['entry1']->get_clm_array_at(0)."=".$search.
                                                   " ORDER BY ".$_SESSION['entry1']->get_clm_array_at(15). " DESC",
                                                   1,count($_SESSION['entry1']->get_clm_array())-2);
      $_SESSION['entry1']->db_connection_off();
    }

echo "<div class='formdiv'>
    <form id=row_options method=post action=modify.php>
      <br><br>
      <button type=submit name=copia>Copia</button>
      <button type=submit name=elimina>Elimina</button>
    </form>
    <form id=row_options method=post action=new.php>
      <br>
      <button type=submit name=modifica>Modifica</button>
      <button type=submit name=aggiorna>Aggiorna</button>
    </form></div>";

    ?>
