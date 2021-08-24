<?php
  include('server_code.php');
  include('errors_code.php');


echo "
  <form method=post action=register.php>
  	<div class=input-group>
  	  <label>Username</label>
  	  <input type=text name=username value=$username>
  	</div>
  	<div class=input-group>
  	  <label>Email</label>
  	  <input type=email name=email value=$email>
  	</div>
  	<div class=input-group>
  	  <label>Password</label>
  	  <input type=password name=password_1>
  	</div>
  	<div class=input-group>
  	  <label>Confirm password</label>
  	  <input type=password name=password_2>
  	</div>
  	<div class=input-group>
  	  <button type=submit class=btn name=reg_user>Register</button>
  	</div>
  	<p>
  		Already a member? <a href=login.php>Sign in</a>
  	</p>
  </form>";
  ?>
