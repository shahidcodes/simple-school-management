<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="Includes/bootstrap.min.css">
</head>
<body>
<div class="container">
<div class="col-md-5 col-md-push-2">
<?php

require 'App.php';
if (Admin::isLoggedIn()) {
	if (Input::exists("get")) {
		$fee_type = Input::get("fee_type");
		$sid	  = Input::get("sid");
		$month	  = Input::get("month");
		$remarks = Input::get("remarks");
		$available_fee_types = ["course", "transport", "other"];
		switch ($fee_type) {
			case 'course':
				$fee_type = "Monthly Fee";
				break;
			case 'transport':
				$fee_type = "Transportation Fee";
				break;
			case 'other':
				$fee_type = $remarks;
				break;
		}
		$student = new Students($sid);
		$data = $student->data();
		$amount = $student->getClassFee();
		?>
	<div class="header">
			<h1>Mohsin Public School</h1>
		</div>
	<table class="table table-bordered">
		<tr>
			<td><b>Name:</b></td>
			<td><?=$data->name?></td>
		</tr>
		<tr>
			<td><b>S/O-D/O:</b></td>
			<td><?=$data->father_name?></td>
		</tr>
		<tr>
			<td><b>Fee Type:</b></td>
			<td><?=$fee_type?></td>
		</tr>
		<tr>
			<td><b>Amount:</b></td>
			<td><?=$amount->fee_detail?></td>
		</tr>
		<tr>
			<td><b>Class:</b></td>
			<td><?=$amount->class_name?></td>
		</tr>
		<tr>
			<td><b>Date:</b></td>
			<td><?=date("h:m:s i/F/Y")?></td>
		</tr>
		<tr>
			<td><b>Sign:</b></td>
			<td>--------------</td>
		</tr>
	</table>
	<a href="#" onclick="window.print()">Print</a>
	<?php	
	}
}else{
	Redirect::to("Dash");
}
?>
</div>
</div>
</body>
</html>