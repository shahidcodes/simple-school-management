<?php

$dob = "12/06/2015";
$s = ["/", ","];
$dob = date("Y-m-d",strtotime(str_replace($s, "-", $dob))) ;
print $dob;

die();
require 'App.php';
getHeader();
getNavbar();
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		
	}
}else{
	Redirect::to("Dash");
}
?>
</div>
</body>
</html>