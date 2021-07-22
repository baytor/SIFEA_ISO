<?php include('server.php'); ?>

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
      <!-- il problema ce l'ho qui che quando apro la pagina è come se i COOKIES non ci fossero -->
  		<input type="text" name="username" value= <?php echo $_COOKIE['username']; ?> >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
      <!-- il problema ce l'ho qui che quando apro la pagina è come se i COOKIES non ci fossero (come sopra)-->
  		<input type="password" name="password" value= <?php echo $_COOKIE['password']; ?> type="hidden">
  	</div>
    <div class="input-group">
    <input type="checkbox" id="rememberaccount" name="remember" value="true">
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
