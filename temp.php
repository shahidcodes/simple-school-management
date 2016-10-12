<?php

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