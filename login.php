<?php
  include('server.php');
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
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>

  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" value= <?php echo $cookie_username; ?> >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password"
      name="password" value= <?php echo $cookie_password; ?> type="hidden">
  	</div>
    <div class="input-group">
    <input type="checkbox" id="rememberaccount" name="remember" checked>
    <label for="rememberaccount"> Ricordati di me</label><br>
    </div>
    <div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>

</body>
</html>
