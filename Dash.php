<?php
include 'App.php';
getNavBar();
getHeader();
?>
<!-- Main Content -->
<div class="col-md-8 col-sm-12">
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
}
?>

<?php	
}else{
	print "No way";
}
?>
</div>
</div><!-- ./Container -->
</body>
</html>