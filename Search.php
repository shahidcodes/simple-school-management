<?php

require 'App.php';
getHeader();
getNavbar();
?>
<div class="row">
<div class="col-lg-6">
	<p class="lead"> Search Students By Name To Pay the Fee </p>
	<form action="" method="POST">
	    <div class="input-group">
	      <input type="text" name="searchq" class="form-control" placeholder="Search for...">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button">Go!</button>
	      </span>
	    </div><!-- /input-group -->
	</form>
  </div><!-- /.col-lg-6 -->
</div><!-- ./row -->
<?php
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		if(!empty(Input::get("searchq"))){
			$q = Input::get("searchq");
			$student = new Students();
			$b = $student->search($q);
			if ($b) {
				$student->showList($b);
			}
		}
	}
}else{
	Redirect::to("Dash");
}
?>
</div>
</body>
</html>