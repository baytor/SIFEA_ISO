<?php
  include('server_code.php');
  if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
  {
    $cookie_username = $_COOKIE['username'];
    $cookie_password = $_COOKIE['password'];
  }
  else
  {
    $cookie_username = "";
    $cookie_password = "";
  }

echo  "<div class=formdiv><form method=post action=login.php>";
  	  include('errors_code.php');
echo  "<label>Username</label><br>
  		<input type=text name=username value=$cookie_username><br>
  		<label>Password</label><br>
  		<input type=password name=password value=$cookie_password type=hidden><br>
      <input type=checkbox id=rememberaccount name=remember checked>
      <label for=rememberaccount> Ricordati di me</label><br>
      <button type=submit class=btn name=login_user>Login</button><br>
  	  <p>
  		Not yet a member? <a href=register.php>Register Here</a>
  	  </p>
      </form></div>";

?>
