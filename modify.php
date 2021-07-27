<?php
  require_once('viewer.php');

  function action($search)
  {
    //search($_GET['search']);
    $_SESSION['entry1']->db_connection_on();
    $_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$search);
    // $_SESSION['entry1']->select_rows_by_string("SELECT * FROM ".$_SESSION['entry1']->table.
    //                                              " WHERE ".$_SESSION['entry1']->clm_array[6]." = ".$_GET['search'].
    //                                              " ORDER BY ".$_SESSION['entry1']->clm_array[15]);

    $_SESSION['entry1']->db_connection_off();
  }

  if (isset($_GET['search']))
    {
        action($_GET['search']);
        $_SESSION['row_search'] = $_GET['search'];
    }

    if(isset($_POST['copia']))
    {
      echo "copia<br>";
      $_SESSION['row_search'] = $_GET['search'];
    }

    if(isset($_POST['elimina']))
    {
      echo "elimina<br>";
      $_SESSION['row_search'] = $_GET['search'];
    }

    if(isset($_POST['modifica']))
    {
      echo "modifica<br>";
      $_SESSION['row_search'] = $_GET['search'];
    }

    if(isset($_POST['aggiorna']))
    {
      echo "aggiorna<br>";
      $_SESSION['row_search'] = $_GET['search'];
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <form id="row_options" method="post" action="modify.php">
      <button type="submit" name="copia">Copia</button>
      <button type="submit" name="elimina">Elimina</button>
      <button type="submit" name="modifica">Modifica</button>
      <button type="submit" name="aggiorna">Aggiorna</button>
    </form>

  </body>
</html>
