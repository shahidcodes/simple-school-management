<?php

require 'App.php';
getHeader();
getNavbar();
?>
<div class="row">
<div class="col-lg-6">
	<p class="lead"> Search Students By Name To Pay the Fee </p>
	<form action="" method="POST">
	    <div class="input-group">
	      <input type="text" name="searchq" class="form-control" placeholder="Search for...">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button">Go!</button>
	      </span>
	    </div><!-- /input-group -->
	</form>
  </div><!-- /.col-lg-6 -->
</div><!-- ./row -->
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
</div>
</body>
</html>