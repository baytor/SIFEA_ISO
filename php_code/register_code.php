<?php
  include('server_code.php');
  include('errors_code.php');


echo "
  <form method=post action=register.php>
  	  <label>Username</label><br>
  	  <input type=text name=username value=$username><br>
  	  <label>Email</label><br>
  	  <input type=email name=email value=$email><br>
  	  <label>Password</label><br>
  	  <input type=password name=password_1><br>
  	  <label>Confirm password</label><br>
  	  <input type=password name=password_2><br>
  	  <button type=submit class=btn name=reg_user>Register</button><br>
  	<p>
  		Already a member? <a href=login.php>Sign in</a>
  	</p>
  </form>";
  ?>
