<?php

/**
* A basic login class
*/
class Login
{
	private $db;

	public function __construct(){
		$this->db = DB::getInstance();
	}

	public function login($login_data=array())
	{
		if (!empty($login_data)) {
			$username = $this->validate($login_data["username"]);
			$password = $this->validate($login_data["password"]);
			$dbpassword = $this->db->get("admin", ["username", "=", $username])->first()->password;
			if($password === $dbpassword){
				Admin::logUserIn();
			}
		}
	}

	/*Validation function*/

	public function validate($value=null)
	{
		if ($value) {
			$to_replace = ["'", '"', " "];
			$replacement = ["", "", ""];
			$value = str_replace($to_replace, $replacement, $value);
			return trim($value);
		}
	}
}