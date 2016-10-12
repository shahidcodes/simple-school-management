<?php

require 'App.php';
if (Admin::isLoggedIn()) {
	if (Input::exists()) {
		$sid = Input::get("sid");
		$month = Input::get("month");
		if(!empty($sid) && !empty($month)){
			$student = new Students($sid);
			$student->payFee($month);
		}
	}
}else{
	Redirect::to("Dash");
}