<?php

require 'App.php';
getNavbar();
getHeader();
?>
<div class="col-md-12">
<div class="panel panel-primary">
	<div class="panel-heading">
		<p class="lead"> Search Students By Name To Pay the Fee </p>
	</div>
	<div class="panel-body">
	<div class="col-md-8">
		<form action="" method="POST">
		    <div class="input-group">
		      <input type="text" name="searchq" class="form-control" placeholder="Search for...">
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="button">Go!</button>
		      </span>
		    </div>
		</form>
	</div>
<?php
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		if(!empty(Input::get("searchq"))){
			$q = Input::get("searchq");
			$student = new Students();
			$b = $student->search($q);
			if ($b) {
				?>
				<br>
		<div class="col-md-8">
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

			<?php foreach($b as $std): ?>
			<tr>
				<!-- <li class="list-group-item"> -->
				<td>	<a href="Student.php?sid=<?=$std->id?>"><?=$std->name?></a> </td>
				<td>	<?=$std->father_name?></td>
				<td>
				<a href="AddStudent.php?action=edit&id=<?=$std->id?>">Edit Student</a>&nbsp;/&nbsp;
				<a href="Student.php?sid=<?=$std->id?>">Pay Fee</a>&nbsp;/&nbsp;
				<a href="Dash.php?action=delete_student&id=<?=$std->id?>">Delete Student</a>
				</td>
				<!-- </li> -->
			</tr>
			<?php endforeach; ?>
			</tbody>
			<!-- </ul> -->
			</table>
		</div>
				<?php
			}
		}
	}
}else{
	Redirect::to("Dash");
}
?>
</div><!-- /.panel -->
</div><!-- /.col-lg-6 -->
</div><!-- ./row -->
</div>
</body>
</html>