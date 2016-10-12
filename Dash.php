<?php
include 'App.php';
getHeader();
?>
<?php getNavBar(); ?>
<!-- Main Content -->
<div class="col-md-8 col-sm-12">
<?php
if (Admin::isLoggedIn()) {
	$students = new Students();
	$studentsList = $students->getStudentList();
	// Show our student list
	$students->showList($studentsList);
	
}else{
	print "No way";
}
?>
</div>
</div><!-- ./Container -->
</body>
</html>