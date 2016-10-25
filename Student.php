<?php

require 'App.php';
getHeader();

if (Admin::isLoggedIn()) {
getNavbar();
echo Session::flash("msg"); //Flash Notification Messeges!
	if (Input::exists("get")) {
			$sid = Input::get("sid");
			$student = new Students();
			$studentData = $student->getStudentByID($sid) ;
			$isPaid = $student->currentMonthFeePaid($sid);
			$unpaid = $student->totalDue($sid);
			$transport = $student->getTransport($sid);
			echo "Name : $studentData->name <br>Current-Month-Status: ";
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
			echo "<br>Transport: ";
			if ( !isset($transport["err"]) ) {
				// chosen for tranport
			}else if (isset($transport["err"])) {
				echo $transport["err"];
			}
	}

}	
?>

</div>
</html>