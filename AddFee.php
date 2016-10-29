<?php

require 'App.php';
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		$action = Input::get("action");
		echo "";
		switch ($action) {
			case 'regular':
				echo "xx";
				$sid = Input::get("sid");
				$month = Input::get("month");
				// rewrite month to check for which we are paying the fee
				$month = ( empty( $month ) )?False:$month;
				$transport = Input::get("transport");
				$transport = ( empty( $transport ) )?False:$transport;

				if(!empty($sid)){
					$student = new Students($sid);
					$route_id = $student->data()->route_id;
					$transport = [$transport, $route_id];
					$student->payFee($month, $transport);
				}
				break;
			case 'other':
				// render other fee
				$session = "";
				$amount = Input::get("amount");
				$fee_type = Input::get("fee_type");
				$sid = Input::get("sid");
				$date = date("Y-m-d H:i:s");
				$fields = [
					'amount' => $amount,
					'student_id' => $sid,
					'date'	=> $date,
					'fee_type'	=> $fee_type
					];
				$student = new Students();
				if ($student->payOtherFee($fields)) {
					$session = "Fee ($fee_type) Paid !";
				}

				Session::flash("msg", $session);
				Redirect::to("Student.php?sid=$sid");
				break;
		}
		Redirect::to("Student.php?sid=$sid");
	}
}else{
	Redirect::to("Dash");
}