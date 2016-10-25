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
			<div class="panel panel-info">
				<div class="panel-heading">List Of Students:</div>
				<div class="panel-body">
					<ul class="list-group">
					<?php foreach($studentsByClassId as $std): ?>
						<li class="list-group-item"><a href="Student.php?sid=<?=$std->id?>"><?=$std->name?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
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