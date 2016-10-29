<?php
include 'App.php';
getNavBar();
getHeader();
?>
<!-- Main Content -->
<div class="col-md-12 col-sm-12">
<?php
if (Admin::isLoggedIn()) {
if (Input::exists("get")) {
	$action = Input::get("action");
	switch ($action) {
		case 'view_student':
			?>
			<div class="panel panel-primary">
			<div class="panel-heading"><p class="lead">View Students In A Class </p></div>
			<div class="panel-body">
				<form class="form" role="form" action="" method="GET">
				<input type="hidden" name="action" value="view_student">
					<div class="form-group">
					<label for="class">Select Class</label>
						<select name="class" class="form-control">
					<?php
					$student = new Students();
					$classes = $student->getClass();
					foreach ($classes as $cls) {
						echo "<option value='$cls->id'>$cls->class_name</option>"	;
					}
					?>
						</select>
					</div>
					<input type="submit" class="btn btn-sm btn-info" />
				</form>
			<?php
			$id = Input::get("class");
			if ($id !== "") {
				$studentsByClassId = $student->getStudentByClassID($id, 10);
			?>
			<div>
			<!-- <ul class="list-group"> -->
			<table class="table table-stripped">
			<thead>
				<tr>
					<th>Student Name:</th>
					<th>Father Name:</th>
					<th>Operation:</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($studentsByClassId as $std): ?>
				<!-- <li class="list-group-item"> -->
				<tr>
				<td>	<a href="Student.php?sid=<?=$std->id?>"><?=$std->name?></a> </td>
				<td>	<?=$std->father_name?></td>
				<td>
				<a href="AddStudent.php?action=edit&id=<?=$std->id?>">Edit Student</a>&nbsp;/&nbsp;
				<a href="#">Pay Fee</a>&nbsp;/&nbsp;
				<a href="Dash.php?action=delete_student&id=<?=$std->id?>">Delete Student</a>
				</td>
				</tr>
				<!-- </li> -->
			<?php endforeach; ?>
			</tbody>
			<!-- </ul> -->
			</table>
		</div>
		</div> <!-- ./panel-body -->
		</div> <!-- ./panel -->
			<?php
			}
			break;
		case 'delete_student':
			$id = Input::get("id");
			$students = new Students($id);
			$students->delete();
			echo "<h4 class='bg-info'>Student Deleted!</h4>";
			break;
		default:break;
	}
}else{
$dashboard = new Dashboard();
$tCourseFee = $dashboard->getTotalCourseFee();
?>
<div class="row">
	<!-- Course Fee -->
	<div class="col-md-4 circle-box" style="text-align: center">
		<div class="panel panel-success">
			<div class="panel-heading"><b> Total Course Fee Paid </b></div>
			<div class="panel-body">
				<div class="col-md-1"></div>
				<div class="c100 p25 big green">
					<span>1200</span>
					<div class="slice">
					    <div class="bar"></div>
					    <div class="fill"></div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				Total Fee Paid = <?=$tCourseFee?> INR
			</div>
		</div>
	</div>
	<!-- Tranport Fee -->
	<div class="col-md-4 circle-box" style="text-align: center">
		<div class="panel panel-success">
			<div class="panel-heading"> Total Fee Paid</div>
			<div class="panel-body">
				<div class="col-md-1"></div>
				<div class="c100 p25 big green">
					<span>1200</span>
					<div class="slice">
					    <div class="bar"></div>
					    <div class="fill"></div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				Total Fee Paid = 12,098,19 INR
			</div>
		</div>
	</div>
	<!-- Other Fee -->
	<div class="col-md-4 circle-box" style="text-align: center">
		<div class="panel panel-success">
			<div class="panel-heading"> Total Fee Paid</div>
			<div class="panel-body">
				<div class="col-md-1"></div>
				<div class="c100 p25 big green">
					<span>1200</span>
					<div class="slice">
					    <div class="bar"></div>
					    <div class="fill"></div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				Total Fee Paid = 12,098,19 INR
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				Useful Links:
			</div>
			<div class="panel-body" style="padding: 2em;">
				<a href="AddStudent.php" class="btn btn-sm btn-danger">Add New Student</a>
				<a href="Search.php" class="btn btn-sm btn-success">Pay Fee</a>
				<a href="Routes.php" class="btn btn-sm btn-info">Add Transport Routes</a>
				<a href="Dash.php?action=view_student" class="btn btn-sm btn-warning">View Student By Class</a>
			</div>
		</div>
	</div>
</div>


<?php	
} // Default page
}else{
	print "No way";
}
?>
</div>
</div><!-- ./Container -->
</body>
</html>