<?php
require 'App.php';
getHeader();

if (Admin::isLoggedIn()) {
getNavbar();
$editForm=false;
if (Input::exists("get")) {
	if(Input::get("action") == "edit"){
		$id = Input::get("id");
		$editForm = true;
		$students = new Students($id);
		$data = $students->data();
	}
}
if (Input::exists()) {
	$name = Input::get("name");
	$mobile = Input::get("mobile");
	$regnum = Input::get("regnum");
	$rollnum = Input::get("rollnum");
	$address = Input::get("address");
	$dob = Input::get("dob");
	$classid = Input::get("classid");
	$father_name = Input::get("father_name");
	$transport = Input::get("transport");
	$route_id = "";
	if ($transport == "on") {
		$transport = true;
		$route_id = Input::get("route_id");
	}
	if (!empty($_FILES)) {
		$avator = Students::uploadAvator();
	}else{
		// use mm for students with no images
		$avator = "avators/mm.png";
	}
	$fields = [
				"name" 		=> $name,
				"mobile" 	=> $mobile,
				"father_name"=> $father_name,
				"regnum"	=> $regnum,
				"rollnum"	=> $rollnum,
				"address"	=> $address,
				"dob"		=> $dob,
				"avator"	=> $avator,
				"class_id"	=> $classid,
				"transport"	=> $transport,
				"route_id"	=> $route_id
				];
	if ($name != '' || $mobile != '' ||$regnum != '' || $classid != '' ||
		$rollnum != '' || $address != '' || $dob != '' || $avator != '') 
	{
		$students = new Students();
		if (Input::get("action") == "edit") {
			$id = Input::get("id");
			$students->update($id, $fields);
			$students->getStudentByID($id); // refresh the data
			$data = $students->data();
		}else{
			$students->addStudent($fields);
		}
	}

}
?>
<content>
<?php echo Session::flash("msg")?>
<div class="row">
<div class="col-md-8">
	<h2 class="header"><?=($editForm)?"Edit": "Add" ?> Student</h2>
</div>
<?php if($editForm): ?>
<div class="col-md-4">
	<a href="Student.php?sid=<?=$data->id?>">View Student</a>
</div>
<?php endif; ?>
</div>
<b>
<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group col-md-4">
		<input type="text" class="form-control" id="name_input" name="name" value="<?=($editForm)?$data->name:""?>" placeholder="Full Name">
	</div>
	<div class="form-group col-md-4">
		<input type="text" class="form-control" name="father_name" value="<?=($editForm)?$data->father_name:""?>" placeholder="Father Name... ">
	</div>
	<div class="form-group col-md-4 ">
		<input type="text" class="form-control" id="mobile_input" value="<?=($editForm)?$data->mobile:""?>" name="mobile" placeholder="Mobile Number">
	</div>
	<div class="col-md-5 form-group">
		<input type="text" class="form-control" name="regnum" value="<?=($editForm)?$data->regnum:""?>" placeholder="Regitration Number">
	</div>
	<div class="col-md-7 form-group">
		<input type="text" class="form-control" name="rollnum" value="<?=($editForm)?$data->rollnum:""?>" placeholder="Roll Number">
	</div>
	<div class="col-md-12 form-group">
		<input type="text" class="form-control" name="address" value="<?=($editForm)?$data->address:""?>" placeholder="Address">
	</div>
	<div class="col-md-4 form-group">
	<label>Date Of Birth</label>
		<input type="text" class="form-control" name="dob" value="<?=($editForm)?$data->dob:""?>" placeholder="Date Of Birth (DD/MM/YYYY)">
	</div>
	<div class="dropdown col-md-4 col-sm-12">
	<label>Select Class: </label>
	<select name="classid" class="form-control class-select">
	<?php

	foreach (Students::getClassLists() as $id => $value) {
		$v = "<option value='$id'>$value</option>";
		if ($data->class_id == $id) {
			$v = "<option value='$id' selected='selected'>$value</option>";
		}
		echo $v;
	}
	?>
	</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="avator">Upload Image</label>
		<input type="file" name="avator" id="avator">
		<p class="help-block">Upload Image Of Student/ Upload To Update</p>
	</div>
	<div class="col-md-12 checkbox">
		<label>
			<input type="checkbox" id="transportCheckBox" name="transport" <?=($editForm && $data->transport)?"checked":""?>/> Applied For Transport?
		</label>
	</div>
	<div class="col-md-8 col-sm-12 <?=($data->transport)?"":"routeSelect"?>">
		<label>Select Route: </label>
		<select name="route_id" class="form-control class-select">
		<?php

		foreach (Students::getRoutes() as $id => $value) {
			$v = "<option value='$id'>$value</option>";
			if ($data->route_id == $id) {
				$v = "<option value='$id' selected='selected'>$value</option>";
			}
			echo $v;
		}
		?>
		</select>
	</div>
	<div class="col-md-12"><button type="submit" class="btn btn-default"><?=($editForm)?"Update Profile":"Insert Student"?></button></div>
</form>
</b>
</content>
</div>
<?php
}
?>

</body>
</html>