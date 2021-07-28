<?php
  require_once('viewer.php');

  if (isset($_GET['search']))
    {
        action($_GET['search']);
        $_SESSION['row_search'] = $_GET['search'];
        echo "L'oggetto con chiave primaria = " . $_GET['search'] .
              " si chiama " .$_SESSION['entry1']->get_clm_header_at(2)."<br>";
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

    function action($search)
    {
      //search($_GET['search']);
      $_SESSION['entry1']->db_connection_on();
      //$_SESSION['entry1']->select_rows_where_is($_SESSION['entry1']->clm_array[0],$search);
      $_SESSION['entry1']->select_rows_by_string_by_pos("SELECT * FROM ".$_SESSION['entry1']->get_dbtable().
                                                   " WHERE ".$_SESSION['entry1']->get_clm_array_at(0)."=".$search.
                                                   " ORDER BY ".$_SESSION['entry1']->get_clm_array_at(15). " DESC",1,14);
      $_SESSION['entry1']->db_connection_off();
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
