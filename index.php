
<!DOCTYPE html>
<html>
<head>
<title>Mohsin Public School</title>
<link rel="stylesheet" type="text/css" href="Includes/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Includes/style.css">
<script type="text/javascript" src="Includes/jquery.js"></script>
<script type="text/javascript" src="Includes/main.js"></script>
</head>
<body style="background-image: url('includes/images/bg.jpg')">
<div class="container">
<?php

include 'App.php';  //contains global declartion
if (Input::exists()) {
	$username = Input::get("username");
	$password = Input::get("password");
	$login = new Login();
	if ( $login->login(["username" => $username, "password" => $password]) ){
		Admin::logUserIn();
	}
}
?>
<div class="col-md-8 col-md-push-2 form-wrapper">
  <div class="form-main">
  <div class="text text-primary"><h1>Mohsin Public School</h1></div>
    <form action="" method="POST" class="form-signin">
      <h2>Please sign in</h2>
      <label for="username" class="sr-only">Email address</label>
      <input type="username" name="username" class="form-control" placeholder="Username" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <input type="submit" class="btn btn-primary btn-block" value="Sign In" />
    </form>
  </div>
</div>
</div> <!-- /container -->
</body>
</html>