<?php

require 'App.php';
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		$sid = Input::get("sid");
		$month = Input::get("month");
		// rewrite month to check for which we are paying the fee
		$month = ( empty( $month ) )?False:$month;
		$transport = Input::get("transport");
		$transport = ( empty( $transport ) )?False:$transport;
		if(!empty($sid)){
			$student = new Students($sid);
			$student->payFee($month, $transport);
		}
	}
}else{
	Redirect::to("Dash");
}