<?php
  function search()
  {
    //echo $_SESSION['entry1']->select_where(1,"860");
    echo $_SESSION['entry1']->get_name();
  }
  if(isset($_POST['submit']))
  {
    search();
  }
?>
