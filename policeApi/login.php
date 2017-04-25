<?php
require_once('./police_serv.php');
$username = $_REQUEST["username"];
$password = $_REQUEST["password"];

$ser = new service();
if($ser->login($username, $password))
    echo 'true';
else
    echo 'false';