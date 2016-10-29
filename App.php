<?php

/* Must Include in Every PHP File*/
session_start();
date_default_timezone_set('Asia/Kolkata'); //sets indian time zone
// echo "<pre>";
header('X-Frame-Options : DENY') ;
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'schooldb2'
		),
	'session' => [
		'admin_session' => 'kasjbrjagsnx0asdj'
		]
	);
function my_auto_loader($class){
	require_once 'Classes/'. $class .'.php';
}
spl_autoload_register('my_auto_loader');

function getNavBar(){ include 'Includes/navbar.php'; }
function getHeader(){ include 'Includes/header.php'; }
function getFooter(){ include 'Includes/footer.php'; }
function getAlert($value){	return '<div class="alert alert-danger" role="alert">'.$value.'</div>'; }
function dd($value='')
{
	if ($value) {
		die(var_dump($value));
	}
}
function sanitize($value='')
{
	return $value;
}