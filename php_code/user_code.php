<?php
require_once('libs_code.php');
require_once('db_config_code.php');

session_start();

$name = "Utenti";
$clm_header = array("Nome utente", "E-mail", "password", "Amministratore");
$clm_array = array("username", "email", "password", "admin");
$input_type = array("text", "email", "text", "checkbox");
$table = "utenti";

$_SESSION['user'] = new dbEntry($name, $clm_header, $clm_array, $input_type, $servername_db, $username_db, $password_db, $dbname_db, $table);
$_SESSION['user']->db_connection_on();

if (isset($_POST['salva']))
{
  echo "Impostazioni modificate";
  header("Refresh: 2; url=index.php");
}
else
{
  echo "
  <div class=userformdiv>

  <form id=userform method=post action=user.php>

  <div class=datadiv>";

$user_clm = array(0,1);

for($i = $user_clm[0]; $i < count($user_clm); ++$i)
{//completare
  echo "
  <label for=username>Nome utente:</label><br>
  <input type=text id=user name=username value=".$_SESSION['username']."><br>
  ";
}

  echo "
  </div>

  <div class=buttonsdiv>
  <button type=submit class=btn name=salva>Salva Modifiche</button>
  <button type=submit class=btn name=esci>Esci</button>
  </div>

  </form>
  </div>
  ";
}

$_SESSION['user']->db_connection_off();

function passwd_change()
{
  //cambio password
}

function passwd_retrieve()
{
  //recupero password
}

?>
