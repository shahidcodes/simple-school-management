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
	$father_name = Input::get("father_name");
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
			"father_name"=> $father_name,
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
<content>
<?php echo Session::flash("msg")?>
<h2 class="header">Add Student</h2>
<b>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group col-md-4">
		<input type="text" class="form-control" id="name_input" name="name" placeholder="Full Name">
	</div>
	<div class="form-group col-md-4">
		<input type="text" class="form-control" name="father_name" placeholder="Father Name... ">
	</div>
	<div class="form-group col-md-4 ">
		<input type="text" class="form-control" id="mobile_input" name="mobile" placeholder="Mobile Number">
	</div>
	<div class="col-md-5 form-group">
		<input type="text" class="form-control" name="regnum" placeholder="Regitration Number">
	</div>
	<div class="col-md-7 form-group">
		<input type="text" class="form-control" name="rollnum" placeholder="Roll Number">
	</div>
	<div class="col-md-12 form-group">
		<input type="text" class="form-control" name="address" placeholder="Address">
	</div>
	<div class="col-md-4 form-group">
	<label>Date Of Birth</label>
		<input type="text" class="form-control" name="dob" placeholder="Date Of Birth (DD/MM/YYYY)">
	</div>
	<div class="dropdown col-md-4 col-sm-12">
	<label>Select Class: </label>
	<select name="classid" class="form-control class-select">
	<?php

	foreach (Students::getClassLists() as $id => $value) {
		echo "<option value='$id'>$value</option>";
	}
	?>
	</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="avator">Upload Image</label>
		<input type="file" name="avator" id="avator">
		<p class="help-block">Upload Image Of Student</p>
	</div>
	<div class="col-md-12"><button type="submit" class="btn btn-default">Submit</button></div>
</form>
</b>
</content>
</div>
<?php
}
?>

</body>
</html>