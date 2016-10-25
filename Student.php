

<?php

require 'App.php';
getHeader();

if (Admin::isLoggedIn()) {
getNavbar();
echo Session::flash("msg"), "<br>"; //Flash Notification Messeges!
	if (Input::exists("get")) {
		$sid = Input::get("sid");
		$student = new Students();
		$studentData = $student->getStudentByID($sid) ;
		$isPaid = $student->currentMonthFeePaid($sid);
		$unpaid = $student->totalDue($sid);
		$transportDues = $student->getTransport($sid);
		$transportCurrentMonth = $student->getTransportCurrentMonth($sid);
?>
<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6">
<div class="well well-sm">
<div class="row">
<div class="col-sm-6 col-md-4">
<img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
</div>
<div class="col-sm-6 col-md-8">
<h4><b><?=$studentData->name?></b></h4>
<small>
	<cite title="San Francisco, USA"><b><?=$studentData->address?></b> <i class="glyphicon glyphicon-map-marker"></i></cite>
</small>
<p>
    <i class="glyphicon glyphicon-phone"></i><b><?=$studentData->mobile?></b>
    <br />
    <i class="glyphicon glyphicon-equalizer"><b></i><?=$studentData->father_name?></b>
    <br />
    <i class="glyphicon glyphicon-gift"></i><b><?=$studentData->dob?></b></p>
    <i class="glyphicon glyphicon-home"></i><b><?=$student->getClassNameByID($studentData->class_id)?></b></p>
    <i class="glyphicon glyphicon-road"></i><b><?=($studentData->transport)?"Yes":"No"?></b></p>
    <i class="glyphicon glyphicon-education"></i><b><?=$studentData->regnum, " / ", $studentData->rollnum?></b></p>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm-6 col-md-6">
	<div class="well well-sm">
		<?php
		if ( !isset($transportDues["err"]) ) {
			// chosen for tranport , show due months
			// if current month paid no need to show pay form
			if (!$transportCurrentMonth) {
				// show pay form
				echo "Current Month Not Paid</b>";
				Utils::renderPayForm($sid, 0);
			}else{
				echo "Paid</b>";
			}
		}else if (isset($transportDues["err"])) {
			echo $transportDues["err"];
		}
		?>
	</div>
</div>
</div>	
<?php
		/*echo "Name : $studentData->name <br>Current Month Status: ";
		// echo ($isPaid)? "Paid" : "Not Paid";
		if ($isPaid) {
			echo "<font class='text text-success'>Paid</font>";
		}else{
			echo "<font class='text text-danger'>Not Paid</font>";
		//show form to pay and send requestt to AddFee.php
			Utils::renderPayForm($sid);
		}
		echo "<br>Remaining Month Fee: ";
		if($unpaid && count($unpaid) != 0){
			foreach ($unpaid as $u) {
				echo $u . ", ";
			}
		}else if(!$unpaid){
			echo " No Fee Paid";
		}else{
			echo " All Fee Paid";
		}
		echo "<br>Current Month Transport:<b> ";
		if ( !isset($transport["err"]) ) {
			// chosen for tranport , show due months
			// if current month paid no need to show pay form
			if (!$transportCurrentMonth) {
				// show pay form
				echo "Current Month Not Paid</b>";
				Utils::renderPayForm($sid, 0);
			}else{
				echo "Paid</b>";
			}
		}else if (isset($transport["err"])) {
			echo $transport["err"];
		}*/
	}

}	
?>

</div>
</html>