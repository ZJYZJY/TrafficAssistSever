<?php
require_once('./police_serv.php');
$username = $_REQUEST['username'];

$ser = new Service();
echo $ser->downloadAccInfo($username);
