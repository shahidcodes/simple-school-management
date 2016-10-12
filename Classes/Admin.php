<?php


/**
* Just to create admin session or check it
*/
class Admin
{
	
	public static function isLoggedIn()
	{
		if (Session::exists(Config::get("session/admin_session"))) {
			return true;
		}

		return false;
	}

	public static function logUserIn()
	{
		$random = md5(rand(10, 100));
		Session::put(Config::get("session/admin_session"), $random);
		redirect::to("Dash.php");
	}
}