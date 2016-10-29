<?php

/**
* Dashboard PHP
*/
class Dashboard
{
	private $_db;
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	public function getTotalStudent()
	{
		return $this->_db->get("students", [1, "=", "1"])->count();

	}

	public function getTotalCourseFee()
	{
		// course
		$courseFee = $this->_db->get("fee", [1,"=",1])->results();
		$totalAmount = 0;
		foreach ($courseFee as $c) {
			$totalAmount += $c->amount;
		}
		return $totalAmount;
	}
	public function getTotalTransportFee()
	{
		$totalAmount = 0;
		$transportFee = $this->_db->get("transport", [1,"=",1])->results();
		foreach ($transportFee as $t) {
			$totalAmount += $t->amount;
		}
		$totalAmount;
	}

	public function getTotalOtherFee()
	{
		$totalAmount = 0;
		$transportFee = $this->_db->get("other_fee", [1,"=",1])->results();
		foreach ($transportFee as $o) {
			$totalAmount += $o->amount;
		}
		return $totalAmount;
	}
	public function listClasses()
	{
		
	}

}