<?php
require 'App.php';
getNavbar();
getHeader();

if (Admin::isLoggedIn()) {
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
	$dob = date("Y-m-d",strtotime($dob)) ;
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
<?php echo Session::flash("msg")?>
<script src="Includes/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="Includes/jquery-ui.min.css" />
<div class="panel panel-primary">
	<div class="panel-heading">
		<p class="lead">
			<h2 class="header"><?=($editForm)?"Edit": "Add" ?> Student</h2>
		</p>
		<?php if($editForm): ?>
			<a class="btn btn-sm btn-danger" href="Student.php?sid=<?=$data->id?>">View Student</a>
		<?php endif; ?>
	</div>
	<div class="panel-body">
		<form class="form" role="form" action="" method="POST" enctype="multipart/form-data">
			<div class="col-md-8 col-sm-12">
			<div class="form-group">
				<input type="text" class="form-control" name="name" value="<?=($editForm)?$data->name:""?>" placeholder="Full Name">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="father_name" value="<?=($editForm)?$data->father_name:""?>" placeholder="Father Name... ">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" value="<?=($editForm)?$data->mobile:""?>" name="mobile" placeholder="Mobile Number">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="regnum" value="<?=($editForm)?$data->regnum:""?>" placeholder="Regitration Number">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="rollnum" value="<?=($editForm)?$data->rollnum:""?>" placeholder="Roll Number">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="address" value="<?=($editForm)?$data->address:""?>" placeholder="Address">
			</div>
			<div class="form-group">
			<label>Date Of Birth</label>
				<input type="text" id="datepicker" class="form-control" name="dob" value="<?=($editForm)?$data->dob:""?>" placeholder="Date Of Birth (DD/MM/YYYY)">
			</div>
			<div class="dropdown">
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
			<div class="form-group">
				<label for="avator">Upload Image</label>
				<input type="file" name="avator" id="avator">
				<p class="help-block">Upload Image Of Student/ Upload To Update</p>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="transportCheckBox" name="transport" <?=($editForm && $data->transport)?"checked":""?>/> Applied For Transport?
				</label>
			</div>
			<div class="<?=($data->transport)?"":"routeSelect"?>">
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
			<div class="btn"><button type="submit" class="btn btn-primary"><?=($editForm)?"Update Profile":"Insert Student"?></button></div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<?php
}
?>
<script>
$(document).ready(function () {
	$( "#datepicker" ).datepicker();
});

  </script>
</body>
</html>