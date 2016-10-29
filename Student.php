

<?php

require 'App.php';
if (Admin::isLoggedIn()) {
	getNavbar();
	getHeader();
    echo Session::flash("msg"), "<br>"; //Flash Notification Messeges!
    if (Input::exists("get")) {
        $sid                   = Input::get("sid");
        $student               = new Students($sid);
        $studentData           = $student->getStudentByID($sid);
        $isPaid                = $student->currentMonthFeePaid($sid);
        $unpaid                = $student->totalDue($sid);
        $transportDues         = $student->getTransport($sid);
        $transportCurrentMonth = $student->getTransportCurrentMonth($sid);
        ?>
<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6">
	<div class="well well-sm">
		<div class="row">
			<div class="col-sm-6 col-md-4">
			<img src="<?=($studentData->avator)?$studentData->avator:"avators/mm.png"?>" alt="" class="img-rounded img-responsive" />
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
			    <i class="glyphicon glyphicon-road"></i><b>
			    	<!-- if opted for transport then show which -->
			    	<?php
			    	if($studentData->transport){
			    		echo "YES";
			    		echo "|Route: ", $student->getRouteByStudentID()->route_name;
			    	}
			    	?>
			    </b></p>
			    <i class="glyphicon glyphicon-education"></i><b><?=$studentData->regnum, " / ", $studentData->rollnum?></b></p>
			    <i class="glyphicon glyphicon-edit"></i><b><a href="AddStudent.php?action=edit&id=<?=$studentData->id?>">Edit Profile</a></b>
			</div>
		</div>
		</div>
	</div>
<div class="col-xs-12 col-sm-6 col-md-6">
	<div class="well well-sm">
		<table class="table">
		<thead>
			<tr>
				<th>Fee Type</th>
				<th>Remaining Months</th>
				<th>Current Month Status</th>
			</tr>
		</thead>
			<tr class="danger">
				<td><h4>Course Fee</h4></td>
				<td>
				<?php
				if ($unpaid) {
					foreach ($unpaid as $unpaidMonth) {
						echo $unpaidMonth, ",";
					}
				}else{
					echo "No Remaining Months/ No Fee Paid";
				}
				?>
				</td>
				<td>
				<?php
		if (!$isPaid) {
            Utils::renderPayForm($sid);
        } else {
            echo "<h4>Paid<a class='text text-info' href='print.php?fee_type=course&month=current&sid=$studentData->id'>(Print Fee)</a></h4>";
        }

        ?>
				</td>

			</tr>
			<tr class="danger">
			<td><h4>Transport Fee Paid</h4></td>
			<td>
			<!-- due months -->
			<?php
			if ($transportDues) {
				foreach ($transportDues as $tm) {
					echo $tm, ",";
				}
			}else{
				echo "No Remaining Months/ No Fee Paid";
			}
			?>
			</td>
			<td>
			<?php
		if (!$transportCurrentMonth) {
            Utils::renderPayForm($sid, 0);
        } else {
            echo "<h4>Paid <a class='text text-info' href='print.php?fee_type=transport&month=current&sid=$studentData->id'>(Print Fee)</a></h4>";
        }

        ?>
			</td>
			</tr>

		</table>
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