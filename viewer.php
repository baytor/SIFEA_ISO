<?php
  require_once('index.php');

  if (isset($_GET['search']))
    {
        search($_GET['search']);
    }

    function Search($res)
    {
        //real search code goes here
        echo $res;
    }



?>
