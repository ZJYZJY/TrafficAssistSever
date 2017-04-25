<?php
require_once('./user_serv.php');
$username = $_REQUEST["username"];

$ser = new service();
echo $ser->downloadHistory($username);