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
getHeader();
?>
<div class="jumbotron">
	<h1>Mohsin Public School</h1>
<div class="form">
      <form action="" method="POST" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="username" class="sr-only">Email address</label>
        <input type="username" name="username" class="form-control" placeholder="Email address" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="submit" class="btn btn-primary btn-block" value="Sign In" />
      </form>
</div>
</div>
    </div> <!-- /container -->
</body>
</html>