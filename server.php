<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();
$dbname =
$user_table = "utenti";

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'test');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM $user_table WHERE username= $username OR email= $email LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO $user_table (username, email, password)
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
    $_SESSION['password'] = $password_1;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
// LOGIN USER

if (isset($_POST['login_user'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if(isset($_POST['remember'])) // questa è la spunta sul login
    {
      if(!isset($_COOKIE['username'])) //ho aggiunto adesso la funzione isset()
      {
        //bisogna fare setcookie per user, password
        setcookie('username', $_POST['username'], time()+(86400 * 30 * 7));
        setcookie('password', $_POST['password'], time()+(86400 * 30 * 7));
      }

      else
      {
          //prima cancello i cookies esistenti e poi li reimposto perché non
          //me li sovrascriveva (o almeno non so come fare)
          unset($_COOKIE['username']);
          unset($_COOKIE['password']);
          setcookie('username', $_POST['username'], time()+(86400 * 30 * 7));
          setcookie('password', $_POST['password'], time()+(86400 * 30 * 7));
      }

    }

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0)
  {
  	$password = md5($password);
  	$query = "SELECT * FROM $user_table WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1)
    {
  	  $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
  	  $_SESSION['success'] .= "You are now logged in";
  	  header('location: index.php');
  	}
    else
    {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>
