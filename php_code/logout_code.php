<?php
include('server_code.php');

echo "<p>Reindirizzamento...</p>";

session_destroy();
unset($_SESSION['username']);
header("Refresh: 2; url=login.php");


 ?>
