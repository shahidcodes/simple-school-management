<?php
require 'App.php';
getHeader();

if (Admin::isLoggedIn()) {
getNavbar();
if (Input::exists()) {
	$name = Input::get("name");
	$mobile = Input::get("mobile");
	$regnum = Input::get("regnum");
	$rollnum = Input::get("rollnum");
	$address = Input::get("address");
	$dob = Input::get("dob");
	$classid = Input::get("classid");
	if (!empty($_FILES)) {
		$avator = Students::uploadAvator();
	}else{
		// use mm for students with no images
		$avator = "avators/mm.png";
	}

	if ($name != '' || $mobile != '' ||$regnum != '' || $classid != '' ||
		$rollnum != '' || $address != '' || $dob != '' || $avator != '') {
		$students = new Students();
		
		$students->addStudent([
			"name" 		=> $name,
			"mobile" 	=> $mobile,
			"regnum"	=> $regnum,
			"rollnum"	=> $rollnum,
			"address"	=> $address,
			"dob"		=> $dob,
			"avator"	=> $avator,
			"class_id"	=> $classid
			]);
	}

}
?>
<div class="container">
<div class="jumbotron">
	<h1>Mohsin Public School</h1>
	<h3>Add Students</h3>
</div>
<content>
<div><code style="padding: 15px;"><? echo Session::flash("msg")?></code></div>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
	<input type="text" class="form-control" id="name_input" name="name" placeholder="Full Name">
	<input type="text" class="form-control" id="mobile_input" name="mobile" placeholder="Mobile Number">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" name="regnum" placeholder="Regitration Number">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" name="rollnum" placeholder="Roll Number">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" name="address" placeholder="Address">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" name="dob" placeholder="Date Of Birth (DD/MM/YYYY)">
	</div>
	<div class="dropdown">
	<label>Select Class: </label>
	<select name="classid" class="class-select">
	<?php

	foreach (Students::getClassLists() as $id => $value) {
		echo "<option value='$id'>$value</option>";
	}
	?>
	</select>
	</div>
	<div class="form-group">
		<label for="avator">Upload Image</label>
		<input type="file" name="avator" id="avator">
		<p class="help-block">Upload Image Of Student</p>
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
</form>
</content>
</div>
<?php
}
?>

</body>
</html>