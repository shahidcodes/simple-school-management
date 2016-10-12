<?php

include 'App.php';  //contains global declartion

$login = new Login();
$login->login(["username" => "admin", "password" => "admin"]);