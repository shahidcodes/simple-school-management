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
		'db' => 'schooldb'
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
function getAlert($value){	return "<p class='bg-danger'>$value</p>"; }