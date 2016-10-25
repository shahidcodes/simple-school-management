<?php
include 'App.php';
getHeader();
?>
<?php getNavBar(); ?>
<!-- Main Content -->
<div class="col-md-8 col-sm-12">
<?php
if (Admin::isLoggedIn()) {
if (Input::exists("get")) {
	$action = Input::get("action");
	switch ($action) {
		case 'view_student':
			?>
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
				<a href="#">Edit Student</a>&nbsp;/&nbsp;
				<a href="#">Pay Fee</a>&nbsp;/&nbsp;
				<a href="#">Delete Student</a>
				</td>
				</tr>
				<!-- </li> -->
			<?php endforeach; ?>
			</tbody>
			<!-- </ul> -->
			</table>
		</div>
			<?php
			}
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