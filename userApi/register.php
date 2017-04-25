<?php
require_once('./user_serv.php');
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];

$ser = new service();
if($ser->register($username, $password))
    echo 'true';
else
    echo 'false';